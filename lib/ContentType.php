<?php

    namespace Slimmer;

    class ContentType {

        /**
         * @var string
         */
        private $type;

        /**
         * @var string
         */
        private $charset;

        /**
         * @param string $headerString
         *
         * @return static
         */
        static function createFromString ($headerString) {
            $headerParts = explode(';', $headerString);
            $contentType = isset($headerParts[0]) ? $headerParts[0] : null;
            $charset = isset($headerParts[1]) ? $headerParts[1] : null;

            return new static($contentType, $charset);
        }

        /**
         * @param $type
         * @param string $charset
         */
        function __construct ($type, $charset = 'utf-8') {
            $this->type = $type;
            $this->charset = $charset;
        }

        /**
         * @return string
         */
        function getType () {
            return $this->type;
        }

        /**
         * @return string
         */
        function getCharset () {
            return $this->charset;
        }

    }