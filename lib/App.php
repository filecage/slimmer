<?php

    namespace Slimmer;

    use Creator\Creator;
    use Slimmer\Exceptions\Http\MethodNotAllowed;
    use Slimmer\Exceptions\Http\NotImplemented;
    use Slimmer\Exceptions\SlimmerException;
    use Slimmer\Http\Http;
    use Slimmer\Interfaces\ContentConverterInterface;
    use Slimmer\Interfaces\Hookable;
    use Slimmer\Router\Router;

    class App {

        /**
         * @var Creator
         */
        private $creator;

        /**
         * @var Router
         */
        private $router;

        /**
         * @var Http
         */
        private $http;

        /**
         * @var ContentConverterInterface
         */
        private $contentConverter;

        /**
         * @param Creator $creator
         * @param ContentConverterInterface $contentConverter
         */
        function __construct (Creator $creator = null, ContentConverterInterface $contentConverter = null) {
            $this->http = new Http();

            $this->creator = $creator ?: new Creator();
            $this->creator->registerClassResource($this->http->getRequest());
            $this->creator->registerClassResource($this->http->getResponse());

            $this->router = $this->creator->create(Router::class);
            $this->contentConverter = $contentConverter ?: new JsonContentConverter();
        }

        /**
         * @return Router
         */
        function getRouter () {
            return $this->router;
        }

        /**
         * @param ContentConverterInterface $contentConverter
         *
         * @return $this
         */
        function setContentConverter (ContentConverterInterface $contentConverter) {
            $this->contentConverter = $contentConverter;

            return $this;
        }

        /**
         * @return $this
         */
        function run () {
            $response = $this->http->getResponse();

            try {
                $routeMatch = $this->router->getMatchingRoute(trim($this->http->getRequest()->getParameter('route'), '/'));
                $this->creator->registerClassResource($routeMatch->getArguments());
                $route = $routeMatch->getRoute();

                $httpHook = $this->getHttpHookByHttpMethod();
                if (!$route->supportsHook($httpHook)) {
                    throw new MethodNotAllowed($route);
                }

                $route->injectCreator($this->creator)
                    ->callHook($httpHook, $response);

                $route->callHook('slimmer:beforeSend', $response);
            } catch (\Exception $e) {
                if (!$e instanceof SlimmerException) {
                    $e = SlimmerException::convertFromGenericException($e);
                }
                $response = $e->getExceptionResponse();
            }

            $this->http->send($response, $this->contentConverter);

            return $this;
        }

        /**
         * @return string
         * @throws \Exception
         */
        private function getHttpHookByHttpMethod () {
            $request = $this->http->getRequest();
            if ($request->isGet()) {
                return Hookable::HOOK_HTTP_GET;
            } elseif ($request->isPost()) {
                return Hookable::HOOK_HTTP_POST;
            } elseif ($request->isPut()) {
                return Hookable::HOOK_HTTP_PUT;
            } elseif ($request->isDelete()) {
                return Hookable::HOOK_HTTP_DELETE;
            } elseif ($request->isOptions()) {
                return Hookable::HOOK_HTTP_OPTIONS;
            }

            throw new NotImplemented;
        }
    }