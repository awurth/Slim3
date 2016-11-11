<?php

namespace App\Controller;

use App\Service\Validator;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Support\Facades\Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface;
use Slim\Exception\NotFoundException;
use Slim\Flash\Messages;
use Slim\Router;
use Slim\Views\Twig;
use App\Service\Auth;

/**
 * @property Twig view
 * @property Router router
 * @property Messages flash
 * @property Auth auth
 * @property Validator validator
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
     * @param Request $request
     * @param Response $response
     * @return NotFoundException
     */
    public function notFoundException(Request $request, Response $response)
    {
        return new NotFoundException($request, $response);
    }

    public function __get($property)
    {
        return $this->container->get($property);
    }
}
