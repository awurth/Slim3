<?php

$controllers = [
    'admin.controller' => 'Admin\Controller\AdminController',
    'app.controller'   => 'App\Controller\AppController',
    'auth.controller'  => 'Security\Controller\AuthController'
];

foreach ($controllers as $key => $class) {
    $container[$key] = function ($container) use ($class) {
        return new $class($container);
    };
}
