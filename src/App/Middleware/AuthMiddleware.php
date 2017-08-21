<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware extends Middleware
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if (!$this->auth->check()) {
            $this->flash->addMessage('danger', 'You must be logged in to access this page!');

            return $response->withRedirect($this->router->pathFor('login'));
        }

        return $next($request, $response);
    }
}
