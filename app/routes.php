<?php

use App\Middleware\GuestMiddleware;
use App\Middleware\AuthMiddleware;

$app->group('', function () {
    $this->map(['GET', 'POST'], '/login', 'auth.controller:login')->setName('login');
    $this->map(['GET', 'POST'], '/register', 'auth.controller:register')->setName('register');
})->add(new GuestMiddleware($container));

$app->get('/logout', 'auth.controller:logout')
    ->add(new AuthMiddleware($container))
    ->setName('logout');

$app->get('/', 'app.controller:home')->setName('home');
