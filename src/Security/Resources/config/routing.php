<?php

use Security\Middleware\GuestMiddleware;
use Security\Middleware\AuthMiddleware;

$app->group('', function () {
    $this->map(['GET', 'POST'], '/login', 'auth.controller:login')->setName('login');
    $this->map(['GET', 'POST'], '/register', 'auth.controller:register')->setName('register');
})->add(new GuestMiddleware($container));

$app->get('/logout', 'auth.controller:logout')
    ->add(new AuthMiddleware($container))
    ->setName('logout');
