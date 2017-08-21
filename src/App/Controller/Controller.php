<?php

namespace App\Controller;

use Awurth\SlimValidation\Validator;
use Cartalyst\Sentinel\Sentinel;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\NotFoundException;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
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
     * Redirects to a url.
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
     * @param ResponseInterface $response
     * @param string $data
     * @param int $status
     *
     * @return int
     */
    public function write(ResponseInterface $response, $data, $status = 200)
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
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return NotFoundException
     */
    public function notFoundException(ServerRequestInterface $request, ResponseInterface $response)
    {
        return new NotFoundException($request, $response);
    }

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
