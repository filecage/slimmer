<?php

    namespace Slimmer;

    class RouteIdentifier {

        /**
         * @var string
         */
        private $routeIdentifierString;

        /**
         * @var string
         */
        private $regularExpression;

        /**
         * @var string
         */
        private $arguments = [];

        /**
         * @param $routeIdentifierString
         */
        function __construct($routeIdentifierString) {
            $this->routeIdentifierString = $routeIdentifierString;
            $this->parseIdentifier($routeIdentifierString);
        }

        /**
         * @return string
         */
        function getRegularExpression () {
            return $this->regularExpression;
        }

        /**
         * @return string
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
            $this->regularExpression = str_replace('/', '\/', preg_replace_callback('/{(.+)}/', function($matches){
                $definition = array_pop($matches);
                preg_match('/^([^A-Za-z0-9_]+)([A-Za-z0-9_]+)$/', $definition, $matches);

                $this->arguments[] = array_pop($matches);

                return array_pop($matches);
            }, $identifier));

            return $this;
        }

    }