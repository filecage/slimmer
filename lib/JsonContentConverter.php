<?php

    namespace Slimmer;

    use Slimmer\Interfaces\ContentConverterInterface;

    class JsonContentConverter implements ContentConverterInterface {

        function convert (Response $response) {
            $buffer = $response->getBody();
            if ($buffer->hasContent()) {
                $buffer->setContent(json_encode($buffer->getContent()));
            }
            
            $response->getHeaderContainer()->setContentType('application/json');
        }

    }