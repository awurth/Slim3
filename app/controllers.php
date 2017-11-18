<?php

$controllers = [
    'core.controller'  => 'App\Core\Controller\CoreController',
    'admin.controller' => 'App\Admin\Controller\AdminController',
    'auth.controller'  => 'App\Security\Controller\AuthController'
];

foreach ($controllers as $key => $class) {
    $container[$key] = function ($container) use ($class) {
        return new $class($container);
    };
}
