<?php

use App\Middleware\GuestMiddleware;
use App\Middleware\AuthMiddleware;

$app->group('', function () {
    $this->map(['GET', 'POST'], '/login', 'auth.controller:login')->setName('login');
    $this->map(['GET', 'POST'], '/register', 'auth.controller:register')->setName('register');
})->add(new GuestMiddleware($container));

$app->group('', function () {
    $this->get('/logout', 'auth.controller:logout')->setName('logout');
})->add(new AuthMiddleware($container));
