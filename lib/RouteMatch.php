<?php
    
    namespace Slimmer;
    
    class RouteMatch {

        /**
         * @var Route
         */
        private $route;
        
        /**
         * @var Arguments
         */
        private $arguments;

        /**
         * @param Route $route
         * @param Arguments $arguments
         */
        function __construct(Route $route, Arguments $arguments) {
            $this->route = $route;
            $this->arguments = $arguments;
        }

        /**
         * @return Route
         */
        function getRoute () {
            return $this->route;
        }

        /**
         * @return Arguments
         */
        function getArguments () {
            return $this->arguments;
        }
        
    }