<?php

    $loader = require(__DIR__  . '/../vendor/autoload.php');

    $app = new \Slimmer\App();

    $app->getRouter()->registerGetHandler('(.*)', function (\Slimmer\Buffer $buffer) {
        $buffer->hello = 'world';
        $buffer->timestamp = time();
    });

    $app->run();