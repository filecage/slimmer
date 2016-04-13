<?php

    namespace Slimmer\Interfaces;

    use Slimmer\Response;

    interface Hookable {

        const HOOK_HTTP_GET = 'http:get';
        const HOOK_HTTP_POST = 'http:post';
        const HOOK_HTTP_PUT = 'http:put';
        const HOOK_HTTP_DELETE = 'http:delete';

        /**
         * @param $hook
         * @param Response $buffer
         *
         * @return mixed
         */
        function callHook($hook, Response $buffer);

    }