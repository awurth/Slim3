<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new Slim\App([
    'env'      => 'prod',
    'root_dir' => dirname(__DIR__)
]);

$container = $app->getContainer();

$container['config'] = require __DIR__ . '/../app/config/config.php';

require __DIR__ . '/../app/bootstrap.php';

$app->run();
