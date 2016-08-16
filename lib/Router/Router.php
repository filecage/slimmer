<?php

    namespace Slimmer\Router;

    use Slimmer\Exceptions\Http\NotFound;
    use Slimmer\Exceptions\SlimmerException;
    use Slimmer\Interfaces\Hookable;

    class Router {

        /**
         * @var Route[]
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
         * @param $route
         *
         * @return $this
         * @throws SlimmerException
         */
        function registerRoute($routeIdentifier, $route) {
            if (isset($this->routes[$routeIdentifier])) {
                throw new SlimmerException('Multiple routes defined for route identifier "' . $routeIdentifier . '"');
            }

            $this->routes[$routeIdentifier] = $route;

            return $this;
        }

        /**
         * @param string $routeString
         *
         * @return Routing
         * @throws NotFound
         */
        function getMatchingRoute ($routeString) {
            foreach ($this->routes as $routeIdentifier => $route) {
                $routing = new Routing($route, $routeIdentifier);
                if ($routing->matches($routeString)) {
                    return $routing;
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