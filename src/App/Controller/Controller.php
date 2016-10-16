<?php

namespace App\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;

class Controller
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render(string $template, array $params = array()): Response
    {
        return $this->container->get('view')->render(
            $this->container->get('response'),
            $template,
            $params
        );
    }

    public function pathFor(string $route, array $params = array()): string
    {
        return $this->container->get('router')->pathFor($route, $params);
    }

    public function redirect(string $route, array $params = array()): Response {
        return $this->container->get('response')->withRedirect(
            $this->pathFor($route, $params)
        );
    }

    public function flash(string $name, string $message)
    {
        $this->container->get('flash')->addMessage($name, $message);
    }

    public function __get(string $property)
    {
        return $this->container->get($property);
    }
}
