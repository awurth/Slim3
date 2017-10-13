<?php

$config = require __DIR__ . '/config.php';

$config['assets']['base_path'] = '../';

$config['twig']['options']['debug'] = true;
$config['twig']['options']['auto_reload'] = true;

return $config;
