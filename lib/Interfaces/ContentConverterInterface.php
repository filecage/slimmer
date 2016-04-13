<?php

    namespace Slimmer\Interfaces;

    use Slimmer\Response;

    interface ContentConverterInterface {

        /**
         * @param Response $response
         *
         * @return mixed
         */
        function convert(Response $response);

    }