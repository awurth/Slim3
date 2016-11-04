<?php

namespace App\Middleware;

use Interop\Container\ContainerInterface;

use Slim\Flash\Messages;
use Slim\Router;
use Slim\Views\Twig;
use App\Service\Auth;

/**
 * @property Twig view
 * @property Router router
 * @property Messages flash
 * @property Auth auth
 */
class Middleware
{
    /**
     * Slim application container
     *
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        return $this->container->get($property);
    }
}