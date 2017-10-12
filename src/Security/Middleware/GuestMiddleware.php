<?php

namespace Security\Middleware;

use App\Middleware\Middleware;
use Slim\Http\Request;
use Slim\Http\Response;

class GuestMiddleware extends Middleware
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($this->auth->check()) {
            return $response->withRedirect($this->router->pathFor('home'));
        }

        return $next($request, $response);
    }
}
