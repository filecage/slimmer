<?php

    namespace Slimmer\Exceptions\Http;

    use Slimmer\Exceptions\SlimmerException;
    use Slimmer\Http\HeaderContainer;

    abstract class HttpException extends SlimmerException {
        const HTTP_STATUS = HeaderContainer::HTTP_STATUS_SERVER_ERROR;

        /**
         * @var array
         */
        protected $exceptionOutput;

        /**
         * Theres no exception output for HTTP exceptions
         *
         * @return null
         */
        function getExceptionOutput () : ?array {
            return $this->exceptionOutput ?? null;
        }

        /**
         * @param array $exceptionOutput
         *
         * @return HttpException
         */
        function setExceptionOutput (array $exceptionOutput) : HttpException {
            $this->exceptionOutput = $exceptionOutput;

            return $this;
        }

        /**
         * @return int
         */
        function getHttpStatus () {
            return static::HTTP_STATUS;
        }

    }