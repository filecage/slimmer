<?php

    namespace Slimmer;

    use Creator\Creator;
    use Slimmer\Exceptions\SlimmerException;
    use Slimmer\Interfaces\ContentConverterInterface;

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
                foreach ($this->router->getMatchingRoutes($this->request->getParameter('route')) as $route) {
                    $route->injectCreator($this->creator)->callHook($this->getHttpHookByHttpMethod(), $response);
                }
            } catch (\Exception $e) {
                if (!$e instanceof SlimmerException) {
                    $e = SlimmerException::convertFromGenericException($e);
                }
                $response = $e->getExceptionResponse();
            }

            return $this->send($response);
        }

        protected function send(Response $response) {
            if (isset($this->contentConverter)) {
                $this->contentConverter->convert($response);
            }

            $this->setHeaders($response->getHeaderContainer())
                ->setContent($response->getBuffer());

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
                return 'http:get';
            } elseif ($this->request->isPost()) {
                return 'http:post';
            } elseif ($this->request->isPut()) {
                return 'http:put';
            } elseif ($this->request->isDelete()) {
                return 'http:delete';
            }

            throw new \Exception('Bad Method');
        }
    }