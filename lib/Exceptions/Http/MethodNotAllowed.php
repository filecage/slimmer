<?php
    
    namespace Slimmer\Exceptions\Http;
    
    use Slimmer\HeaderContainer;
    use Slimmer\Interfaces\Hookable;
    use Slimmer\Request;
    use Slimmer\Response;
    use Slimmer\Route;

    class MethodNotAllowed extends HttpException {
        const HTTP_STATUS = HeaderContainer::HTTP_STATUS_METHOD_NOT_ALLOWED;
        /**
         * @var Route
         */
        private $route;

        /**
         * @param Route $route
         */
        function __construct(Route $route) {
            $this->route = $route;
        }

        /**
         * @return Response
         */
        function getExceptionResponse () {
            $response = parent::getExceptionResponse();
            $allowed = [];

            if ($this->route->supportsHook(Hookable::HOOK_HTTP_GET)) {
                $allowed[] = Request::GET;
            }

            if ($this->route->supportsHook(Hookable::HOOK_HTTP_POST)) {
                $allowed[] = Request::POST;
            }

            if ($this->route->supportsHook(Hookable::HOOK_HTTP_PUT)) {
                $allowed[] = Request::PUT;
            }

            if ($this->route->supportsHook(Hookable::HOOK_HTTP_DELETE)) {
                $allowed[] = Request::DELETE;
            }

            $response->getHeaderContainer()->setHeader('Allow', implode(', ', $allowed));

            return $response;
        }
    }