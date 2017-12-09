<?php

namespace App\Middleware;

use App\Exception\AccessDeniedException;
use Cartalyst\Sentinel\Sentinel;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var Messages
     */
    protected $flash;

    /**
     * @var string
     */
    protected $role;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Sentinel
     */
    protected $sentinel;

    /**
     * Constructor.
     *
     * @param Router   $router
     * @param Messages $flash
     * @param Sentinel $sentinel
     * @param string   $role
     */
    public function __construct(Router $router, Messages $flash, Sentinel $sentinel, $role = null)
    {
        $this->router = $router;
        $this->flash = $flash;
        $this->sentinel = $sentinel;
        $this->role = $role;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if (!$this->sentinel->check()) {
            $this->flash->addMessage('error', 'You must be logged in to access this page!');

            return $response->withRedirect($this->router->pathFor('login'));
        } elseif ($this->role && !$this->sentinel->inRole($this->role)) {
            throw new AccessDeniedException($request, $response);
        }

        return $next($request, $response);
    }
}
