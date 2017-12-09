<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new App\Application('prod');

$app->run();
