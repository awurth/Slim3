<?php

namespace App\Middleware;

use Cartalyst\Sentinel\Sentinel;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;

class GuestMiddleware implements MiddlewareInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Sentinel
     */
    protected $sentinel;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     * @param Sentinel        $sentinel
     */
    public function __construct(RouterInterface $router, Sentinel $sentinel)
    {
        $this->router = $router;
        $this->sentinel = $sentinel;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($this->sentinel->check()) {
            return $response->withRedirect($this->router->pathFor('home'));
        }

        return $next($request, $response);
    }
}
