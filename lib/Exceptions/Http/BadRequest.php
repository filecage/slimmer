<?php
    
    namespace Slimmer\Exceptions\Http;

    use Slimmer\Http\HeaderContainer;

    class BadRequest extends HttpException {
        const HTTP_STATUS = HeaderContainer::HTTP_STATUS_BAD_REQUEST;
    }