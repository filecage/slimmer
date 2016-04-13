<?php
    
    namespace Slimmer\Exceptions\Http;
    
    use Slimmer\HeaderContainer;

    class BadRequest extends HttpException {
        const HTTP_STATUS = HeaderContainer::HTTP_STATUS_BAD_REQUEST;
    }