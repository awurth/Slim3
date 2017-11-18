<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

session_start();

require __DIR__ . '/../../vendor/autoload.php';

$app = new Slim\App([
    'env' => 'dev',
    'root_dir' => dirname(__DIR__, 2),
    'settings' => [
        'displayErrorDetails' => true
    ]
]);
$container = $app->getContainer();

$container['config'] = require __DIR__ . '/../../app/config/config.dev.php';

require __DIR__ . '/../../app/container.php';

require __DIR__ . '/../../app/handlers.php';

require __DIR__ . '/../../app/middleware.php';

require __DIR__ . '/../../app/controllers.php';

require __DIR__ . '/../../app/routes.php';

$app->run();
