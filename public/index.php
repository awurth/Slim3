<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$settings = require __DIR__ . '/../bootstrap/settings.php';
$app = new Slim\App($settings);

require __DIR__ . '/../bootstrap/dependencies.php';

require __DIR__ . '/../bootstrap/middleware.php';

require __DIR__ . '/../bootstrap/controllers.php';

require __DIR__ . '/../bootstrap/routes.php';

$app->run();
