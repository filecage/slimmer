<?php

    namespace Slimmer;

    use Creator\Creator;
    use Slimmer\Exceptions\Http\MethodNotAllowed;
    use Slimmer\Exceptions\Http\NotImplemented;
    use Slimmer\Exceptions\SlimmerException;
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
         * @var Request
         */
        private $request;

        /**
         * @var Response
         */
        private $response;

        /**
         * @var ContentConverterInterface
         */
        private $contentConverter;

        /**
         * @param Creator $creator
         */
        function __construct (Creator $creator = null) {
            $this->request = new Request($_REQUEST, $_SERVER);
            $this->response = new Response();
            $this->contentConverter = new JsonContentConverter();

            $this->creator = $creator ?: new Creator();
            $this->creator->registerClassResource($this->request);
            $this->creator->registerClassResource($this->response);

            $this->router = $this->creator->create(Router::class);
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
         * @return Buffer
         */
        function run () {
            $response = $this->response;

            try {
                $routeMatch = $this->router->getMatchingRoute(trim($this->request->getParameter('route'), '/'));
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

            return $this->send($response);
        }

        /**
         * @param Response $response
         *
         * @return $this
         */
        protected function send(Response $response) {
            if (isset($this->contentConverter)) {
                $this->contentConverter->convert($response);
            }

            if ($response->getHeaderContainer()->getStatus() === HeaderContainer::HTTP_STATUS_SUCCESS && !$response->getBody()->hasContent()) {
                $response->getHeaderContainer()->setStatus(HeaderContainer::HTTP_STATUS_SUCCESS_NOCONTENT);
            }

            $this->setHeaders($response->getHeaderContainer())
                ->setContent($response->getBody());

            return $this;
        }

        /**
         * @param HeaderContainer $headerContainer
         *
         * @return $this
         */
        protected function setHeaders (HeaderContainer $headerContainer) {
            foreach ($headerContainer->getHeaders() as $header => $value) {
                header(sprintf('%s: %s', $header, $value));
            }

            http_response_code($headerContainer->getStatus());

            return $this;
        }

        /**
         * @param Buffer $buffer
         *
         * @return $this
         */
        protected function setContent (Buffer $buffer) {
            $content = $buffer->getContent();
            if (is_string($content) && !empty($content)) {
                echo $content;
            }

            return $this;
        }

        /**
         * @return string
         * @throws \Exception
         */
        private function getHttpHookByHttpMethod () {
            if ($this->request->isGet()) {
                return Hookable::HOOK_HTTP_GET;
            } elseif ($this->request->isPost()) {
                return Hookable::HOOK_HTTP_POST;
            } elseif ($this->request->isPut()) {
                return Hookable::HOOK_HTTP_PUT;
            } elseif ($this->request->isDelete()) {
                return Hookable::HOOK_HTTP_DELETE;
            } elseif ($this->request->isOptions()) {
                return Hookable::HOOK_HTTP_OPTIONS;
            }

            throw new NotImplemented;
        }
    }