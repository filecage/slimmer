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

        /**
         * @param Buffer $buffer
         * @param HeaderContainer $headerContainer
         */
        function __construct($buffer = null, $headerContainer = null) {
            $this->buffer = $buffer ?: new Buffer();
            $this->headerContainer = $headerContainer ?: new HeaderContainer();
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