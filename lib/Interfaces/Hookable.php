<?php

    namespace Slimmer\Interfaces;

    use Slimmer\Http\Response;

    interface Hookable {

        const HOOK_HTTP_GET = 'http:get';
        const HOOK_HTTP_POST = 'http:post';
        const HOOK_HTTP_PUT = 'http:put';
        const HOOK_HTTP_DELETE = 'http:delete';
        const HOOK_HTTP_OPTIONS = 'http:options';

        const HOOK_SLIMMER_BEFORESEND = 'slimmer:beforeSend';
        const HOOK_SLIMMER_BEFOREROUTING = 'slimmer:beforeRouting';

        /**
         * @param $hook
         * @param Response $buffer
         *
         * @return mixed
         */
        function callHook($hook, Response $buffer);

        /**
         * @param string $hook
         *
         * @return bool
         */
        function supportsHook ($hook);

    }