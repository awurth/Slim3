<?php

namespace App\Middleware;

use Cartalyst\Sentinel\Sentinel;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;

/**
 * @property Twig     view
 * @property Router   router
 * @property Messages flash
 * @property Sentinel auth
 */
abstract class Middleware
{
    /**
     * Slim application container
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Method call when the class is user as a function.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     */
    abstract public function __invoke(Request $request, Response $response, callable $next);

    /**
     * Gets a service from the container.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->container->get($property);
    }
}
