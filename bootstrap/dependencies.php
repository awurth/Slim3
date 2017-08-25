<?php

use App\TwigExtension\AssetExtension;
use Awurth\SlimValidation\Validator;
use Awurth\SlimValidation\ValidatorExtension;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Illuminate\Database\Capsule\Manager;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Symfony\Component\Yaml\Yaml;

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
    $view->addExtension(new AssetExtension(
        $container['request'],
        isset($container['settings']['assets']['base_path']) ? $container['settings']['assets']['base_path'] : ''
    ));
    $view->addExtension(new ValidatorExtension($container['validator']));

    $view->getEnvironment()->addGlobal('flash', $container['flash']);
    $view->getEnvironment()->addGlobal('auth', $container['auth']);

    return $view;
};
