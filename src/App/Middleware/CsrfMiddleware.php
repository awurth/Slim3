<?php

namespace App\Middleware;

use App\TwigExtension\Csrf;
use Interop\Container\ContainerInterface;

class CsrfMiddleware
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next)
    {
        $this->container['view']->addExtension(new Csrf($this->container['csrf']));
        return $next($request, $response);
    }
}