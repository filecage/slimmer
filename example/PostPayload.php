<?php

    $loader = require(__DIR__  . '/../vendor/autoload.php');

    $app = new \Slimmer\App();

    $app->getRouter()->registerPostHandler('(.*)', function (\Slimmer\Buffer $buffer, \Slimmer\Request $request) {
        $buffer->request = $request->getBody()->getContent();
    });

    $app->run();