<?php

    $loader = require(__DIR__  . '/../vendor/autoload.php');

    $app = new \Slimmer\App();

    $app->getRouter()
        ->registerGetHandler('/hello/{(.*)variable}', function (\Slimmer\Buffer $buffer, \Slimmer\Arguments $arguments) {
            $buffer->hello = 'world';
            $buffer->timestamp = time();
            $buffer->variable = $arguments->get('variable');
        })->registerGetHandler(null, function(){
            return 'I am a default route with a body merged into the global buffer.';
        });

    $app->run();