<?php

    namespace Slimmer;

    class Buffer {
        /**
         * @var array
         */
        protected $bufferContent;

        /**
         * @param string $key
         * @param mixed $value
         */
        function __set($key, $value) {
            if (!isset($this->bufferContent)) {
                $this->bufferContent = [];
            }

            $this->bufferContent[$key] = $value;
        }

        /**
         * @return $this
         */
        function clearBuffer () {
            unset($this->bufferContent);

            return $this;
        }

        /**
         * @param $bufferContent
         *
         * @return $this
         */
        function setBufferContent ($bufferContent) {
            $this->bufferContent = $bufferContent;

            return $this;
        }

        /**
         * @return mixed
         */
        function getBufferContent () {
            return $this->bufferContent;
        }
    }