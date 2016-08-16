<?php

    namespace Slimmer\Router;

    use Creator\Creation;

    class Routing {

        /**
         * @var Creation|Route
         */
        private $route;

        /**
         * @var Identifier
         */
        private $identifier;

        /**
         * @var Arguments
         */
        private $arguments;

        /**
         * @param Route|Creation $route
         * @param string $identifier
         */
        function __construct ($route, $identifier) {
            $this->route = $route;
            $this->identifier = new Identifier($identifier);
        }

        /**
         * @return Identifier
         */
        function getIdentifier () {
            return $this->identifier;
        }

        /**
         * @return Creation|Route
         */
        function getRoute () {
            return $this->route;
        }

        /**
         * @return Arguments
         */
        function getArguments () {
            return $this->arguments ?? new Arguments();
        }

        /**
         * @param string $routeString
         *
         * @return bool
         */
        function matches (string $routeString) {
            if (!$this->identifier->getRegularExpression() && $routeString == $this->identifier->getAsString()) {
                return true;
            }

            if ($this->identifier->getRegularExpression() !== null && preg_match('/' . $this->identifier->getRegularExpression() . '/', $routeString, $variables)) {
                $this->arguments = new Arguments(array_combine($this->identifier->getArguments(), array_slice($variables, 1)));

                return true;
            }

            return false;
        }
    }