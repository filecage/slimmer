<?php

    namespace Slimmer;

    class Response {

        /**
         * @var Buffer
         */
        private $buffer;

        /**
         * @var HeaderContainer
         */
        private $headerContainer;

        function __construct() {
            $this->buffer = new Buffer();
            $this->headerContainer = new HeaderContainer();
        }

        /**
         * @return Buffer
         */
        function getBuffer () {
            return $this->buffer;
        }

        /**
         * @return HeaderContainer
         */
        function getHeaderContainer () {
            return $this->headerContainer;
        }

    }