<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GuestMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($this->auth->check()) {
            return $response->withRedirect($this->router->pathFor('home'));
        }

        return $next($request, $response);
    }
}
