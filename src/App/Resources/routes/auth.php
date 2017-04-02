<?php

use App\Middleware\GuestMiddleware;
use App\Middleware\AuthMiddleware;

$app->group('', function () {
    $this->map(['GET', 'POST'], '/login', 'AuthController:login')->setName('login');
    $this->map(['GET', 'POST'], '/register', 'AuthController:register')->setName('register');
})->add(new GuestMiddleware($container));

$app->group('', function () {
    $this->get('/logout', 'AuthController:logout')->setName('logout');
})->add(new AuthMiddleware($container));
