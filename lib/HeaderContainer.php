<?php

    namespace Slimmer;

    class HeaderContainer {

        /**
         * @var array
         */
        private $headers = [];

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