<?php

namespace App\Controller;

use Cartalyst\Sentinel\Sentinel;
use Psr\Http\Message\ResponseInterface as Response;
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
 * @property Sentinel sentinel
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

    /**
     * Redirect to route
     *
     * @param Response $response
     * @param string $route
     * @param array $params
     * @return Response
     */
    public function redirect(Response $response, $route, array $params = array())
    {
        return $response->withRedirect($this->router->pathFor($route, $params));
    }

    public function flash($name, $message)
    {
        $this->flash->addMessage($name, $message);
    }

    public function __get($property)
    {
        return $this->container->get($property);
    }
}
