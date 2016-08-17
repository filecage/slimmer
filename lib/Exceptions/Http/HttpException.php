<?php

    namespace Slimmer\Exceptions\Http;

    use Slimmer\Exceptions\SlimmerException;
    use Slimmer\Http\HeaderContainer;

    abstract class HttpException extends SlimmerException {
        const HTTP_STATUS = HeaderContainer::HTTP_STATUS_SERVER_ERROR;

        /**
         * Theres no exception output for HTTP exceptions
         *
         * @return null
         */
        function getExceptionOutput () {
            return null;
        }

        /**
         * @return int
         */
        function getHttpStatus () {
            return static::HTTP_STATUS;
        }

    }