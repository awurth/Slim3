<?php

$controllers = [
    'app.controller'  => 'App\Controller\AppController',
    'admin.controller' => 'App\Controller\AdminController',
    'auth.controller'  => 'App\Controller\AuthController'
];

foreach ($controllers as $key => $class) {
    $container[$key] = function ($container) use ($class) {
        return new $class($container);
    };
}
