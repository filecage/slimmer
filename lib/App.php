<?php

    namespace Slimmer;

    use Creator\Creator;

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
         * @param Creator $creator
         */
        function __construct(Creator $creator = null) {
            $this->creator = $creator ?: new Creator();
            $this->router = $this->creator->create(Router::class);
            $this->request = new Request($_REQUEST, $_SERVER);
            $this->response = new Response();

            $this->creator->registerClassResource($this->request);
            $this->creator->registerClassResource($this->response);
        }

        /**
         * @return Router
         */
        function getRouter () {
            return $this->router;
        }

        /**
         * @return Buffer
         */
        function run () {
            foreach ($this->router->getMatchingRoutes($this->request->getParameter('route')) as $route) {
                $route->injectCreator($this->creator)->callHook($this->getHttpHookByHttpMethod(), $this->response);
            }

            return $buffer;
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