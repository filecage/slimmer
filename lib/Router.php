<?php

    namespace Slimmer;

    class Router {

        /**
         * @var array
         */
        private $routes = [];

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
         * @return Route[]|null
         */
        function getMatchingRoutes ($routeString) {
            foreach ($this->routes as $routeIdentifier => $routes) {
                if ($routeString === $routeIdentifier || preg_match('/' . $routeIdentifier . '/', $routeString, $variables)) {
                    return $routes;
                }
            }

            return null;
        }
        
    }