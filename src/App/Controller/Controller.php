<?php

namespace App\Controller;

use Interop\Container\ContainerInterface;
use Slim\Flash\Messages;
use Slim\Router;
use Slim\Views\Twig;

/**
 * @property Twig view
 * @property Router router
 * @property Messages flash
 */
class Controller
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

    public function pathFor($route, array $params = array())
    {
        return $this->container->get('router')->pathFor($route, $params);
    }

    public function redirect($route, array $params = array()) {
        return $this->container->get('response')->withRedirect(
            $this->pathFor($route, $params)
        );
    }

    public function flash($name, $message)
    {
        $this->container->get('flash')->addMessage($name, $message);
    }

    public function __get($property)
    {
        return $this->container->get($property);
    }
}
