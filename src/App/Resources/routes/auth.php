<?php

$app->group('', function () {
    $this->map(['GET', 'POST'], '/login', 'AuthController:login')->setName('login');
    $this->map(['GET', 'POST'], '/register', 'AuthController:register')->setName('register');
})->add(new App\Middleware\GuestMiddleware($container));

$app->group('', function () {
    $this->get('/logout', 'AuthController:logout')->setName('logout');
})->add(new App\Middleware\AuthMiddleware($container));
