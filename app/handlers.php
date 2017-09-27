<?php

use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Controller functions signature must be like:
 *
 * public function controllerAction($request, $response, $arg1, $arg2, $arg3, ...)
 *
 * https://www.slimframework.com/docs/objects/router.html#route-strategies
 */
$container['foundHandler'] = function () {
    return new RequestResponseArgs();
};

if ($container['env'] === 'prod') {
    $container['notFoundHandler'] = function ($container) {
        return function (Request $request, Response $response) use ($container) {
            return $response->withStatus(404)->write($container['view']->fetch('Error/404.twig'));
        };
    };

    $container['notAllowedHandler'] = function ($container) {
        return function (Request $request, Response $response, array $methods) use ($container) {
            return $response->withStatus(405)->write($container['view']->fetch('Error/4xx.twig'));
        };
    };

    $container['errorHandler'] = function ($container) {
        return function (Request $request, Response $response, Exception $exception) use ($container) {
            return $response->withStatus(500)->write($container['view']->fetch('Error/500.twig'));
        };
    };

    $container['phpErrorHandler'] = function ($container) {
        return function (Request $request, Response $response, Throwable $error) use ($container) {
            return $response->withStatus(500)->write($container['view']->fetch('Error/500.twig'));
        };
    };
}
