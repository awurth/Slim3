<?php

namespace App\Controller;

use Awurth\Slim\Validation\Validator;
use Cartalyst\Sentinel\Sentinel;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\NotFoundException;
use Slim\Flash\Messages;
use Slim\Router;
use Slim\Views\Twig;

/**
 * @property Twig view
 * @property Router router
 * @property Messages flash
 * @property Validator validator
 * @property Sentinel auth
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

    /**
     * Redirect to url
     *
     * @param Response $response
     * @param string $url
     *
     * @return Response
     */
    public function redirectTo(Response $response, $url)
    {
        return $response->withRedirect($url);
    }

    /**
     * Add a flash message
     *
     * @param string $name
     * @param string $message
     */
    public function flash($name, $message)
    {
        $this->flash->addMessage($name, $message);
    }

    /**
     * Create new NotFoundException
     *
     * @param ServerRequestInterface $request
     * @param Response $response
     * @return NotFoundException
     */
    public function notFoundException(ServerRequestInterface $request, Response $response)
    {
        return new NotFoundException($request, $response);
    }

    public function __get($property)
    {
        return $this->container->get($property);
    }
}
