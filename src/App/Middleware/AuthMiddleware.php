<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if (!$this->auth->check()) {
            $this->flash->addMessage('danger', 'You must be logged in to access this page!');
            return $response->withRedirect($this->router->pathFor('login'));
        }

        return $next($request, $response);
    }
}
