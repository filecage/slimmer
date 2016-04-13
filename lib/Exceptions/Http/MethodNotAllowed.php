<?php
    
    namespace Slimmer\Exceptions\Http;
    
    use Slimmer\HeaderContainer;

    class MethodNotAllowed extends HttpException {
        const HTTP_STATUS = HeaderContainer::HTTP_STATUS_METHOD_NOT_ALLOWED;
    }