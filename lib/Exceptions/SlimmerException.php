<?php
    
    namespace Slimmer\Exceptions;

    use Slimmer\Buffer;
    use Slimmer\HeaderContainer;
    use Slimmer\Response;

    class SlimmerException extends \Exception {

        /**
         * @param \Exception $e
         *
         * @return static
         */
        static function convertFromGenericException (\Exception $e) {
            return new static($e->getMessage(), $e->getCode(), $e);
        }

        /**
         * @return int
         */
        function getHttpStatus () {
            return HeaderContainer::HTTP_STATUS_SERVER_ERROR;
        }

        /**
         * @return array
         */
        function getExceptionOutput () {
            $exception = $this->getPrevious() ?: $this;
            return [
                'type' => get_class($exception),
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace()
            ];
        }

        /**
         * @return Response
         */
        function getExceptionResponse () {
            $buffer = new Buffer($this->getExceptionOutput());
            $header = new HeaderContainer($this->getHttpStatus());

            return new Response($buffer, $header);
        }

    }