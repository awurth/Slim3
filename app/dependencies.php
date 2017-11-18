<?php

use App\Core\TwigExtension\AssetExtension;
use App\Security\TwigExtension\CsrfExtension;
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
use Symfony\Component\Yaml\Yaml;
use Twig\Extension\DebugExtension;

$parameters = Yaml::parse(file_get_contents(__DIR__ . '/config/parameters.yml'))['parameters'];

$capsule = new Manager();
$capsule->addConnection($parameters);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function () use ($capsule) {
    return $capsule;
};

$container['auth'] = function () {
    $sentinel = new Sentinel(new SentinelBootstrapper(__DIR__ . '/config/sentinel.php'));
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

$container['view'] = function ($container) {
    $config = $container['config'];

    $view = new Twig($config['twig']['path'], $config['twig']['options']);

    $view->addExtension(new TwigExtension($container['router'], $container['request']->getUri()));
    $view->addExtension(new DebugExtension());
    $view->addExtension(new CsrfExtension($container['csrf']));
    $view->addExtension(new ValidatorExtension($container['validator']));
    $view->addExtension(new AssetExtension(
        $container['request'],
        $config['assets']['base_path'] ?? null
    ));

    $view->getEnvironment()->addGlobal('flash', $container['flash']);
    $view->getEnvironment()->addGlobal('auth', $container['auth']);

    return $view;
};

$container['monolog'] = function ($container) {
    $config = $container['config']['monolog'];

    $logger = new Logger($config['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler($config['path'], $config['level']));

    return $logger;
};
