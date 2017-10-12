<?php

namespace App\Middleware;

use App\Exception\AccessDeniedException;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware extends Middleware
{
    /**
     * @var string
     */
    protected $role;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     * @param string             $role
     */
    public function __construct(ContainerInterface $container, $role = null)
    {
        parent::__construct($container);

        $this->role = $role;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if (!$this->auth->check()) {
            $this->flash->addMessage('error', 'You must be logged in to access this page!');

            return $response->withRedirect($this->router->pathFor('login'));
        } elseif ($this->role && !$this->auth->inRole($this->role)) {
            throw new AccessDeniedException();
        }

        return $next($request, $response);
    }
}
