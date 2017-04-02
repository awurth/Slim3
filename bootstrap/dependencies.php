<?php

use Symfony\Component\Yaml\Yaml;
use Illuminate\Database\Capsule\Manager;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Slim\Flash\Messages;
use Awurth\SlimValidation\Validator;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use App\TwigExtension\AssetExtension;
use Awurth\SlimValidation\ValidatorExtension;

$container = $app->getContainer();

$parameters = Yaml::parse(file_get_contents(__DIR__ . '/parameters.yml'))['parameters'];

$capsule = new Manager();
$capsule->addConnection($parameters);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function () use ($capsule) {
    return $capsule;
};

$container['auth'] = function () {
    $sentinel = new Sentinel(new SentinelBootstrapper(__DIR__ . '/sentinel.php'));

    return $sentinel->getSentinel();
};

$container['flash'] = function () {
    return new Messages();
};

$container['validator'] = function () {
    return new Validator();
};

$container['view'] = function ($container) {
    $view = new Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig']
    );

    $view->addExtension(new TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    $view->addExtension(new Twig_Extension_Debug());
    $view->addExtension(new AssetExtension($container['request']));
    $view->addExtension(new ValidatorExtension($container['validator']));

    $view->getEnvironment()->addGlobal('flash', $container['flash']);
    $view->getEnvironment()->addGlobal('auth', $container['auth']);

    return $view;
};
