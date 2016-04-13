<?php

    namespace Slimmer;

    use Slimmer\Exceptions\Http\NotFound;
    use Slimmer\Interfaces\Hookable;

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
            return $this->registerRoute($routeIdentifier, (new Route())->registerHook(Hookable::HOOK_HTTP_GET, $handler));
        }

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerPostHandler ($routeIdentifier, callable $handler) {
            return $this->registerRoute($routeIdentifier, (new Route())->registerHook(Hookable::HOOK_HTTP_POST, $handler));
        }

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerPutHandler ($routeIdentifier, callable $handler) {
            return $this->registerRoute($routeIdentifier, (new Route())->registerHook(Hookable::HOOK_HTTP_PUT, $handler));
        }

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerDeleteHandler ($routeIdentifier, callable $handler) {
            return $this->registerRoute($routeIdentifier, (new Route())->registerHook(Hookable::HOOK_HTTP_DELETE, $handler));
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
         * @throws NotFound
         */
        function getMatchingRoutes ($routeString) {
            foreach ($this->routes as $routeIdentifier => $routes) {
                if ($routeString === $routeIdentifier || preg_match('/' . $routeIdentifier . '/', $routeString, $variables)) {
                    return $routes;
                }
            }

            throw new NotFound;
        }

    }