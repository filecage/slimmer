<?php

    namespace Slimmer\Interfaces;

    use Slimmer\Buffer;

    interface Hookable {

        /**
         * @param $hook
         * @param Buffer $buffer
         *
         * @return mixed
         */
        function callHook($hook, Buffer $buffer);

    }