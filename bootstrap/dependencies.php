<?php

$container = $app->getContainer();

$db = require_once __DIR__ . '/db.php';

$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($db);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function () use ($capsule) {
    return $capsule;
};

$container['auth'] = function () {
    $sentinel = new \Cartalyst\Sentinel\Native\Facades\Sentinel(
        new \Cartalyst\Sentinel\Native\SentinelBootstrapper(__DIR__ . '/sentinel.php')
    );

    return $sentinel->getSentinel();
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

$container['validator'] = function () {
    return new \Awurth\Slim\Validation\Validator();
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig']
    );

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    $view->addExtension(new \Twig_Extension_Debug());
    $view->addExtension(new \App\TwigExtension\Asset($container['request']));
    $view->addExtension(new \Awurth\Slim\Validation\ValidatorExtension($container['validator']));

    $view->getEnvironment()->addGlobal('flash', $container['flash']);
    $view->getEnvironment()->addGlobal('auth', $container['auth']);

    return $view;
};

$container['foundHandler'] = function() {
    return new \Slim\Handlers\Strategies\RequestResponseArgs();
};
