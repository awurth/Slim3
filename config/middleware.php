<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$container['middleware.guest'] = function ($container) {
    return new GuestMiddleware($container['router'], $container['auth']);
};

$container['middleware.auth'] = function ($container) {
    return function ($role = null) use ($container) {
        return new AuthMiddleware($container['router'], $container['flash'], $container['auth'], $role);
    };
};

$app->add($container['csrf']);
