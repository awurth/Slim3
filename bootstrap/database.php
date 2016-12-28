<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager;

$config = require __DIR__ . '/db.php';

$capsule = new Manager();
$capsule->addConnection($config);
$capsule->setAsGlobal();
$capsule->bootEloquent();

require __DIR__ . '/database/auth.php';
