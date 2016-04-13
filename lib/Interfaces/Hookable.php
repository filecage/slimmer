<?php

    namespace Slimmer\Interfaces;
    
    use Slimmer\Response;

    interface Hookable {

        /**
         * @param $hook
         * @param Response $buffer
         *
         * @return mixed
         */
        function callHook($hook, Response $buffer);

    }