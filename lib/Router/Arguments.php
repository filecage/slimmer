<?php

    namespace Slimmer\Router;

    class Arguments {

        /**
         * @var array
         */
        private $arguments;

        /**
         * @param array $arguments
         */
        function __construct(array $arguments = []) {
            $this->arguments = $arguments;
        }

        /**
         * @param string $key
         * @param mixed $value
         */
        function set($key, $value) {
            $this->arguments[$key] = $value;
        }

        /**
         * @param string $key
         * @param null $default
         *
         * @return mixed|null
         */
        function get($key, $default = null) {
            if (!$this->has($key)) {
                return $default;
            }

            return $this->arguments[$key];
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        function has($key) {
            return isset($this->arguments[$key]);
        }

    }