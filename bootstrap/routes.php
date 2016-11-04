<?php

$routes = __DIR__ . '/../src/App/Resources/routes/';

$files = [
    'app',
    'auth'
];

foreach ($files as $file) {
    require $routes . $file . '.php';
}
