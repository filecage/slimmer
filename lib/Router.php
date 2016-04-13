<?php

    namespace Slimmer;

    use Slimmer\Exceptions\Http\NotFound;
    use Slimmer\Exceptions\SlimmerException;
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
            return $this->registerRouteHookHandler($routeIdentifier, Hookable::HOOK_HTTP_GET, $handler);
        }

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerPostHandler ($routeIdentifier, callable $handler) {
            return $this->registerRouteHookHandler($routeIdentifier, Hookable::HOOK_HTTP_POST, $handler);
        }

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerPutHandler ($routeIdentifier, callable $handler) {
            return $this->registerRouteHookHandler($routeIdentifier, Hookable::HOOK_HTTP_PUT, $handler);
        }

        /**
         * @param string $routeIdentifier
         * @param callable $handler
         *
         * @return Router
         */
        function registerDeleteHandler ($routeIdentifier, callable $handler) {
            return $this->registerRouteHookHandler($routeIdentifier, Hookable::HOOK_HTTP_DELETE, $handler);
        }

        /**
         * @param $routeIdentifier
         * @param Route $route
         *
         * @return $this
         * @throws SlimmerException
         */
        function registerRoute($routeIdentifier, Route $route) {
            if (isset($this->routes[$routeIdentifier])) {
                throw new SlimmerException('Multiple routes defined for route identifier "' . $routeIdentifier . '"');
            }

            $this->routes[$routeIdentifier] = $route;

            return $this;
        }

        /**
         * @param string $routeString
         *
         * @return Route
         * @throws NotFound
         */
        function getMatchingRoute ($routeString) {
            foreach ($this->routes as $routeIdentifier => $routes) {
                if ($routeString === $routeIdentifier || preg_match('/' . $routeIdentifier . '/', $routeString, $variables)) {
                    return $routes;
                }
            }

            throw new NotFound;
        }

        /**
         * @param string $routerIdentifier
         * @param string $hook
         * @param callable $handler
         *
         * @return $this
         * @throws SlimmerException
         */
        protected function registerRouteHookHandler ($routerIdentifier, $hook, callable $handler) {
            if (isset($this->routes[$routerIdentifier])) {
                $route = $this->routes[$routerIdentifier];
            } else {
                $route = new Route();
                $this->registerRoute($routerIdentifier, $route);
            }

            $route->registerHook($hook, $handler);

            return $this;
        }

    }