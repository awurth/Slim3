<?php

use Awurth\Slim\Helper\Twig\AssetExtension;
use Awurth\Slim\Helper\Twig\CsrfExtension;
use Awurth\SlimValidation\Validator;
use Awurth\SlimValidation\ValidatorExtension;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Illuminate\Database\Capsule\Manager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Extension\DebugExtension;

$capsule = new Manager();
$capsule->addConnection($container['settings']['eloquent']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['auth'] = function ($container) {
    $sentinel = new Sentinel(new SentinelBootstrapper($container['settings']['sentinel']));
    return $sentinel->getSentinel();
};

$container['flash'] = function () {
    return new Messages();
};

$container['csrf'] = function ($container) {
    $guard = new Guard();
    $guard->setFailureCallable($container['csrfFailureHandler']);

    return $guard;
};

// https://github.com/awurth/SlimValidation
$container['validator'] = function () {
    return new Validator();
};

$container['twig'] = function ($container) {
    $config = $container['settings']['twig'];

    $twig = new Twig($config['path'], $config['options']);

    $twig->addExtension(new TwigExtension($container['router'], $container['request']->getUri()));
    $twig->addExtension(new DebugExtension());
    $twig->addExtension(new AssetExtension($container['request']));
    $twig->addExtension(new CsrfExtension($container['csrf']));
    $twig->addExtension(new ValidatorExtension($container['validator']));

    $twig->getEnvironment()->addGlobal('flash', $container['flash']);
    $twig->getEnvironment()->addGlobal('auth', $container['auth']);

    return $twig;
};

$container['monolog'] = function ($container) {
    $config = $container['settings']['monolog'];

    $logger = new Logger($config['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler($config['path'], $config['level']));

    return $logger;
};
