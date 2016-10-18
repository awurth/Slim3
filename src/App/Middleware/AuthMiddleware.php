<?php

namespace App\Middleware;

class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (!$this->auth->check()) {
            $this->flash->addMessage('danger', 'You must be logged in to access this page!');
            return $response->withRedirect($this->router->pathFor('login'));
        }

        return $next($request, $response);
    }
}