<?php

    namespace Slimmer;

    use Slimmer\Exceptions\SlimmerException;

    class Buffer {

        /**
         * @var array
         */
        protected $content;

        /**
         * @param mixed $content
         */
        function __construct($content = null) {
            if ($content) {
                $this->content = $content;
            }
        }

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
         * @param string $index
         *
         * @return bool
         */
        function hasIndex ($index) {
            return isset($this->content[$index]);
        }

        /**
         * @param string $index
         * @param mixed $default
         *
         * @return mixed
         */
        function getIndex ($index, $default = null) {
            if (!$this->hasIndex($index)) {
                return $default;
            }

            return $this->content[$index];
        }

        /**
         * @param Buffer $mergeBuffer
         *
         * @return $this
         * @throws SlimmerException
         */
        function mergeContents (Buffer $mergeBuffer) {
            if (!$mergeBuffer->hasContent()) {
                return $this;
            }

            $mergeContent = $mergeBuffer->getContent();
            if (!$this->hasContent()) {
                $this->content = $mergeContent;
            } elseif (is_array($mergeContent) && is_array($this->content)) {
                $this->content = array_merge($mergeContent, $this->content);
            } elseif (is_string($mergeContent) && is_string($this->content)) {
                $this->content = $this->content . "\n" . $mergeContent;
            } else {
                throw new SlimmerException('Unable to merge buffers, unmergeable buffer content types; please keep buffer writing consistent!');
            }

            return $this;
        }
    }