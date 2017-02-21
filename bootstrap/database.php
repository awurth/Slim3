<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
use Illuminate\Database\Capsule\Manager;

$parameters = Yaml::parse(file_get_contents(__DIR__ . '/parameters.yml'))['parameters'];

$capsule = new Manager();
$capsule->addConnection($parameters);
$capsule->setAsGlobal();
$capsule->bootEloquent();

require __DIR__ . '/database/auth.php';
