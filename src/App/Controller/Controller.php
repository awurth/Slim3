<?php

namespace App\Controller;

use Awurth\SlimValidation\Validator;
use Cartalyst\Sentinel\Sentinel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface;
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
abstract class Controller
{
    /**
     * Slim application container.
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
     * Gets request parameters.
     *
     * @param Request $request
     * @param string[] $params
     *
     * @return array
     */
    public function params(Request $request, array $params)
    {
        $data = [];
        foreach ($params as $param) {
            $data[$param] = $request->getParam($param);
        }

        return $data;
    }

    /**
     * Redirects to a route.
     *
     * @param Response $response
     * @param string $route
     * @param array $params
     *
     * @return Response
     */
    public function redirect(Response $response, $route, array $params = [])
    {
        return $response->withRedirect($this->router->pathFor($route, $params));
    }

    /**
     * Redirects to url.
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
     * Writes JSON in the response body.
     *
     * @param Response $response
     * @param mixed $data
     * @param int $status
     *
     * @return Response
     */
    public function json(Response $response, $data, $status = 200)
    {
        return $response->withJson($data, $status);
    }

    /**
     * Writes text in the response body.
     *
     * @param Response $response
     * @param string $data
     * @param int $status
     *
     * @return int
     */
    public function write(Response $response, $data, $status = 200)
    {
        return $response->withStatus($status)->getBody()->write($data);
    }

    /**
     * Adds a flash message.
     *
     * @param string $name
     * @param string $message
     */
    public function flash($name, $message)
    {
        $this->flash->addMessage($name, $message);
    }

    /**
     * Creates a new NotFoundException.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return NotFoundException
     */
    public function notFoundException(Request $request, Response $response)
    {
        return new NotFoundException($request, $response);
    }

    /**
     * Gets a service from the container.
     *
     * @param $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->container->get($property);
    }
}
