<?php

    namespace Slimmer;

    class Request {

        const GET = 'GET';
        const POST = 'POST';
        const PUT = 'PUT';
        const DELETE = 'DELETE';
        const OPTIONS = 'OPTIONS';

        const CONTENT_TYPE_JSON = 'application/json';
        const CONTENT_TYPE_URLENCODED = 'application/x-www-form-urlencoded';

        const ENVIRONMENT_KEY_METHOD = 'REQUEST_METHOD';
        const ENVIRONMENT_KEY_CONTENT_TYPE = 'CONTENT_TYPE';

        /**
         * @var array
         */
        private $data;

        /**
         * @var array
         */
        private $environment;

        /**
         * @var ContentType
         */
        private $contentType;

        /**
         * @param array $data
         * @param array $environment
         */
        function __construct(Array $data, Array $environment) {
            $this->data = $data;
            $this->environment = $environment;
        }

        /**
         * @return array
         */
        function getData() {
            return $this->data;
        }

        /**
         * @return string
         */
        function getMethod() {
            return (!empty($this->environment[self::ENVIRONMENT_KEY_METHOD])) ? $this->environment[self::ENVIRONMENT_KEY_METHOD] : null;
        }

        /**
         * @return ContentType
         */
        function getContentType () {
            if (!isset($this->contentType)) {
                $this->contentType = ContentType::createFromString(!empty($this->environment[self::ENVIRONMENT_KEY_CONTENT_TYPE]) ? $this->environment[self::ENVIRONMENT_KEY_CONTENT_TYPE] : null);
            }

            return $this->contentType;
        }

        /**
         * @param string $parameterKey
         * @param mixed $default
         *
         * @return mixed
         */
        function getParameter($parameterKey, $default = null) {
            return (isset($this->data[$parameterKey])) ? $this->data[$parameterKey] : $default;
        }

        /**
         * @return Buffer
         */
        function getBody () {
            $body = new Buffer();
            if (!$this->isPost()) {
                return $body;
            }

            $bodyRaw = $this->getBodyRaw();
            switch ($this->getContentType()) {
                case self::CONTENT_TYPE_JSON:
                    $content = json_decode($bodyRaw, true);
                    break;

                case self::CONTENT_TYPE_URLENCODED:
                    parse_str($bodyRaw, $content);
                    break;
            }

            if (!empty($content)) {
                $body->setContent($content);
            }

            return $body;
        }

        /**
         * @return string
         */
        function getBodyRaw () {
            return file_get_contents('php://input');
        }

        /**
         * @return bool
         */
        function isGet() {
            return $this->getMethod() == self::GET;
        }

        /**
         * @return bool
         */
        function isPost() {
            return $this->getMethod() == self::POST;
        }

        /**
         * @return bool
         */
        function isPut() {
            return $this->getMethod() == self::PUT;
        }

        /**
         * @return bool
         */
        function isDelete() {
            return $this->getMethod() == self::DELETE;
        }

        /**
         * @return bool
         */
        function isOptions() {
            return $this->getMethod() == self::OPTIONS;
        }

    }