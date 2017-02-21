<?php

use Slim\Handlers\Strategies\RequestResponseArgs;

/**
 * Controller functions signature must be like:
 *
 * public function controllerAction($request, $response, $arg1, $arg2, $arg3, ...)
 *
 */
$container['foundHandler'] = function () {
    return new RequestResponseArgs();
};

/*
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $response;
    };
};
*/

/*
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        return $response;
    };
};
*/

/*
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        return $response;
    };
};
*/

/*
$container['phpErrorHandler'] = function ($container) use ($config) {
    return function ($request, $response, $error) use ($container, $config) {
        return $response;
    };
};
*/
