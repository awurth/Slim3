<?php

use Security\Middleware\AuthMiddleware;
use Security\Middleware\GuestMiddleware;

$container['guest.middleware'] = function ($container) {
    return new GuestMiddleware($container['router'], $container['auth']);
};

$container['auth.middleware'] = function ($container) {
    return function ($role = null) use ($container) {
        return new AuthMiddleware($container['router'], $container['flash'], $container['auth'], $role);
    };
};

$app->add($container['csrf']);
