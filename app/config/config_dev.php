<?php

$config = require __DIR__ . '/config.php';

$config['assets']['base_path'] = '../';

$config['view']['twig']['debug'] = true;
$config['view']['twig']['auto_reload'] = true;

return $config;
