<?php

    namespace Slimmer;

    class Response {

        /**
         * @var Buffer
         */
        private $body;

        /**
         * @var HeaderContainer
         */
        private $headerContainer;

        /**
         * @param Buffer $body
         * @param HeaderContainer $headerContainer
         */
        function __construct($body = null, $headerContainer = null) {
            $this->body = $body ?: new Buffer();
            $this->headerContainer = $headerContainer ?: new HeaderContainer();
        }

        /**
         * @return Buffer
         */
        function getBody () {
            return $this->body;
        }

        /**
         * @return HeaderContainer
         */
        function getHeaderContainer () {
            return $this->headerContainer;
        }

    }