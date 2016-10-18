<?php

namespace App\Middleware;

use App\TwigExtension\Csrf;

class CsrfMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $this->view->addExtension(new Csrf($this->csrf));
        return $next($request, $response);
    }
}