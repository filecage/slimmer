<?php

    namespace Slimmer;

    class Router {

        /**
         * @var array
         */
        private $routes = [];

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerGetHandler ($routeIdentifier, callable $handler) {
            return $this->registerRoute($routeIdentifier, (new Route())->registerHook('http:get', $handler));
        }

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerPostHandler ($routeIdentifier, callable $handler) {
            return $this->registerRoute($routeIdentifier, (new Route())->registerHook('http:post', $handler));
        }

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerPutHandler ($routeIdentifier, callable $handler) {
            return $this->registerRoute($routeIdentifier, (new Route())->registerHook('http:put', $handler));
        }

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerDeleteHandler ($routeIdentifier, callable $handler) {
            return $this->registerRoute($routeIdentifier, (new Route())->registerHook('http:delete', $handler));
        }

        /**
         * @param $routeIdentifier
         * @param Route $route
         *
         * @return $this
         */
        function registerRoute($routeIdentifier, Route $route) {
            if (!isset($this->routes[$routeIdentifier])) {
                $this->routes[$routeIdentifier] = [];
            }

            $this->routes[$routeIdentifier][] = $route;

            return $this;
        }

        /**
         * @param string $routeString
         *
         * @return Route[]
         */
        function getMatchingRoutes ($routeString) {
            foreach ($this->routes as $routeIdentifier => $routes) {
                if ($routeString === $routeIdentifier || preg_match('/' . $routeIdentifier . '/', $routeString, $variables)) {
                    return $routes;
                }
            }

            return [];
        }

    }