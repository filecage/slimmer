<?php

    namespace Slimmer\Exceptions\Http;

    use Slimmer\HeaderContainer;

    class NotImplemented extends HttpException {
        const HTTP_STATUS = HeaderContainer::HTTP_STATUS_NOT_IMPLEMENTED;
    }