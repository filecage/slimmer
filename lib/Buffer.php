<?php

    namespace Slimmer;

    class Buffer {
        /**
         * @var array
         */
        protected $content;

        /**
         * @param string $key
         * @param mixed $value
         */
        function __set($key, $value) {
            if (!isset($this->content)) {
                $this->content = [];
            }

            $this->content[$key] = $value;
        }

        /**
         * @return $this
         */
        function clearContent () {
            unset($this->content);

            return $this;
        }

        /**
         * @param $bufferContent
         *
         * @return $this
         */
        function setContent ($bufferContent) {
            $this->content = $bufferContent;

            return $this;
        }

        /**
         * @return bool
         */
        function hasContent () {
            return isset($this->content);
        }

        /**
         * @return mixed
         */
        function getContent () {
            return $this->content;
        }
    }