<?php

namespace App\Middleware;

use App\TwigExtension\CsrfExtension;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CsrfMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $this->view->addExtension(new CsrfExtension($request));
        return $next($request, $response);
    }
}
