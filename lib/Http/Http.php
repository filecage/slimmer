<?php

    namespace Slimmer\Http;

    use Slimmer\Buffer;
    use Slimmer\Interfaces\ContentConverterInterface;

    class Http {

        /**
         * @var Request
         */
        protected $request;

        /**
         * @var Response
         */
        protected $response;

        function __construct () {
            $this->request = new Request($_REQUEST, $_SERVER);
            $this->response = new Response();
        }

        /**
         * @return Request
         */
        function getRequest () {
            return $this->request;
        }

        /**
         * @return Response
         */
        function getResponse () {
            return $this->response;
        }

        /**
         * @param Response $response
         * @param ContentConverterInterface $contentConverter
         *
         * @return $this
         */
        function send (Response $response, ContentConverterInterface $contentConverter) {
            $contentConverter->convert($response);

            if ($response->getHeaderContainer()->getStatus() === HeaderContainer::HTTP_STATUS_SUCCESS && !$response->getBody()->hasContent()) {
                $response->getHeaderContainer()->setStatus(HeaderContainer::HTTP_STATUS_SUCCESS_NOCONTENT);
            }

            $this->setHeaders($response->getHeaderContainer())->setContent($response->getBody());

            return $this;
        }

        /**
         * @param HeaderContainer $headerContainer
         *
         * @return $this
         */
        function setHeaders (HeaderContainer $headerContainer) {
            foreach ($headerContainer->getHeaders() as $header => $value) {
                header(sprintf('%s: %s', $header, $value));
            }

            http_response_code($headerContainer->getStatus());

            return $this;
        }

        /**
         * @param Buffer $buffer
         *
         * @return $this
         */
        function setContent (Buffer $buffer) {
            $content = $buffer->getContent();
            if (is_string($content) && !empty($content)) {
                echo $content;
            }

            return $this;
        }

    }