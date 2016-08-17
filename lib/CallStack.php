<?php

    namespace Slimmer;

    use Creator\Creator;
    use Slimmer\Interfaces\Hookable;

    class CallStack implements \Iterator {

        /**
         * @var Hookable[]
         */
        private $stack = [];

        /**
         * @var bool
         */
        private $locked = false;

        /**
         * @param Hookable $hookable
         *
         * @return $this
         */
        function appendHookable (Hookable $hookable) {
            $this->stack[] = $hookable;

            return $this;
        }

        /**
         * @return $this
         */
        function lock () {
            $this->locked = true;

            return $this;
        }

        /**
         * @return bool|Hookable
         */
        function current () {
            return current($this->stack);
        }

        /**
         * @return bool|Hookable
         */
        function next () {
            return next($this->stack);
        }

        /**
         * @return int
         */
        function key () {
            return key($this->stack);
        }

        /**
         * @return bool
         */
        function valid () {
            return isset($this->stack[$this->key()]);
        }

        /**
         * @return bool|Hookable
         */
        function rewind () {
            return reset($this->stack);
        }


    }