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
        private $arguments;

        /**
         * @param string $routeIdentifierString
         */
        function __construct($routeIdentifierString) {
            $this->routeIdentifierString = $routeIdentifierString;
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
            if (!isset($this->regularExpression)) {
                $this->parseIdentifier();
            }

            return $this->regularExpression;
        }

        /**
         * @return array
         */
        function getArguments () {
            if (!isset($this->arguments)) {
                $this->parseIdentifier();
            }

            return $this->arguments;
        }

        /**
         * @return $this
         */
        private function parseIdentifier () {
            $this->arguments = [];
            $regularExpression = preg_replace_callback('/{([^}]+)}/', function($matches){
                $definition = array_pop($matches);
                preg_match('/^([A-Za-z0-9_]+)#([^#]+)$/', $definition, $matches);

                $regex = array_pop($matches);
                $this->arguments[] = array_pop($matches);

                return $regex;
            }, $this->routeIdentifierString);

            if ($regularExpression === $this->routeIdentifierString) {
                return $this;
            }

            $this->regularExpression = str_replace('/', '\/', trim($regularExpression, '/'));

            return $this;
        }

    }