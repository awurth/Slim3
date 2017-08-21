<?php

namespace App\Middleware;

use App\TwigExtension\CsrfExtension;
use Slim\Http\Request;
use Slim\Http\Response;

class CsrfMiddleware extends Middleware
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $this->view->addExtension(new CsrfExtension($request));

        return $next($request, $response);
    }
}
