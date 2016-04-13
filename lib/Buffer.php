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

        /**
         * @param Buffer $mergeBuffer
         *
         * @return $this
         * @throws \Exception
         */
        function mergeContents (Buffer $mergeBuffer) {
            if (!$mergeBuffer->hasContent()) {
                return $this;
            }

            $mergeContent = $mergeBuffer->getContent();
            if (is_array($mergeContent) && is_array($this->content)) {
                $this->content = array_merge($mergeContent, $this->content);
            } elseif (is_string($mergeContent) && is_string($this->content)) {
                $this->content = $this->content . "\n" . $mergeContent;
            } else {
                throw new \Exception('Unable to merge buffers, unmergeable buffer content types');
            }

            return $this;
        }
    }