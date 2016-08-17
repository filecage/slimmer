<?php

    namespace Slimmer\Exceptions\Http;

    use Slimmer\Http\HeaderContainer;

    class NotImplemented extends HttpException {
        const HTTP_STATUS = HeaderContainer::HTTP_STATUS_NOT_IMPLEMENTED;
    }