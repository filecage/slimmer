<?php

    namespace Slimmer;

    class HeaderContainer {

        /**
         * @var array
         */
        private $headers = [];

        /**
         * @param string $contentType
         * @param string $charset
         *
         * @return HeaderContainer
         */
        function setContentType ($contentType, $charset = 'utf-8') {
            return $this->setHeader('Content-Type', sprintf('%s; charset=%s;', $contentType, $charset));
        }

        /**
         * @param string $header
         * @param string $value
         *
         * @return $this
         */
        function setHeader($header, $value) {
            $this->headers[$header] = $value;

            return $this;
        }

        /**
         * @return array
         */
        function getHeaders () {
            return $this->headers;
        }

    }