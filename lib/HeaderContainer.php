<?php

    namespace Slimmer;

    class HeaderContainer {

        const HTTP_STATUS_SUCCESS = 200;
        const HTTP_STATUS_SUCCESS_NOCONTENT = 204;
        const HTTP_STATUS_REDIRECT_MOVED_PERMANENTLY = 301;
        const HTTP_STATUS_REDIRECT_FOUND = 302;
        const HTTP_STATUS_REDIRECT_SEE_OTHER = 303;
        const HTTP_STATUS_BAD_REQUEST = 401;
        const HTTP_STATUS_FORBIDDEN = 403;
        const HTTP_STATUS_NOT_FOUND = 404;
        const HTTP_STATUS_METHOD_NOT_ALLOWED = 405;
        const HTTP_STATUS_SERVER_ERROR = 500;
        const HTTP_STATUS_NOT_IMPLEMENTED = 501;
        const HTTP_STATUS_SERVER_TEMPORARILY_UNAVAILABLE = 503;

        /**
         * @var array
         */
        private $headers = [];

        /**
         * @var int
         */
        private $status;

        /**
         * @param int $status
         */
        function __construct($status = self::HTTP_STATUS_SUCCESS) {
            $this->status = $status;
        }

        /**
         * @param string $contentType
         * @param string $charset
         *
         * @return HeaderContainer
         */
        function setContentType ($contentType, $charset = 'utf-8') {
            return $this->setHeader('Content-Type', sprintf('%s; charset=%s', $contentType, $charset));
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
         * @param $status
         *
         * @return $this
         */
        function setStatus ($status) {
            $this->status = $status;

            return $this;
        }

        /**
         * @return array
         */
        function getHeaders () {
            return $this->headers;
        }

        /**
         * @return int
         */
        function getStatus () {
            return $this->status;
        }

    }