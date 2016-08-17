<?php
    
    namespace Slimmer\Exceptions\Http;
    
    use Slimmer\Http\HeaderContainer;

    class NotFound extends HttpException {
        const HTTP_STATUS = HeaderContainer::HTTP_STATUS_NOT_FOUND;
    }