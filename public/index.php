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

require __DIR__ . '/../vendor/autoload.php';

$settings = require __DIR__ . '/../bootstrap/settings.php';
$app = new Slim\App($settings);

require __DIR__ . '/../bootstrap/dependencies.php';

require __DIR__ . '/../bootstrap/handlers.php';

require __DIR__ . '/../bootstrap/middleware.php';

require __DIR__ . '/../bootstrap/controllers.php';

require __DIR__ . '/../bootstrap/routes.php';

$app->run();
