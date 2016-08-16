<?php

    namespace Slimmer\Router;

    class Identifier {

        /**
         * @var string
         */
        private $routeIdentifierString;

        /**
         * @var string
         */
        private $regularExpression;

        /**
         * @var array
         */
        private $arguments = [];

        /**
         * @param string $routeIdentifierString
         */
        function __construct($routeIdentifierString) {
            $this->routeIdentifierString = $routeIdentifierString;
            $this->parseIdentifier($routeIdentifierString);
        }

        /**
         * @return string
         */
        function getAsString () {
            return $this->routeIdentifierString;
        }

        /**
         * @return string
         */
        function getRegularExpression () {
            return $this->regularExpression;
        }

        /**
         * @return array
         */
        function getArguments () {
            return $this->arguments;
        }

        /**
         * @param $identifier
         *
         * @return $this
         */
        private function parseIdentifier ($identifier) {
            $regularExpression = preg_replace_callback('/{(.+)}/', function($matches){
                $definition = array_pop($matches);
                preg_match('/^([^A-Za-z0-9_]+)([A-Za-z0-9_]+)$/', $definition, $matches);

                $this->arguments[] = array_pop($matches);

                return array_pop($matches);
            }, $identifier);

            if ($regularExpression === $identifier) {
                return $this;
            }

            $this->regularExpression = str_replace('/', '\/', $regularExpression);

            return $this;
        }

    }