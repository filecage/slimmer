<?php

    namespace Slimmer;

    class Request {

        const GET    = 'GET';
        const POST   = 'POST';
        const PUT    = 'PUT';
        const DELETE = 'DELETE';

        const ENVIRONMENT_KEY_METHOD = 'REQUEST_METHOD';

        /**
         * @var array
         */
        private $data;

        /**
         * @var array
         */
        private $environment;

        /**
         * @param array $data
         * @param array $environment
         */
        function __construct(Array $data, Array $environment) {
            $this->data = $data;
            $this->environment = $environment;
        }

        /**
         * @return array
         */
        function getData() {
            return $this->data;
        }

        /**
         * @return string
         */
        function getMethod() {
            return (!empty($this->environment[self::ENVIRONMENT_KEY_METHOD])) ? $this->environment[self::ENVIRONMENT_KEY_METHOD] : null;
        }

        /**
         * @param string $parameterKey
         * @param mixed $default
         *
         * @return mixed
         */
        function getParameter($parameterKey, $default = null) {
            return (isset($this->data[$parameterKey])) ? $this->data[$parameterKey] : $default;
        }

        /**
         * @return bool
         */
        function isGet() {
            return $this->getMethod() == self::GET;
        }

        /**
         * @return bool
         */
        function isPost() {
            return $this->getMethod() == self::POST;
        }

        /**
         * @return bool
         */
        function isPut() {
            return $this->getMethod() == self::PUT;
        }

        /**
         * @return bool
         */
        function isDelete() {
            return $this->getMethod() == self::DELETE;
        }

    }