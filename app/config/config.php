<?php

use Monolog\Logger;
use Symfony\Component\Yaml\Yaml;

return [

    'parameters' => Yaml::parse(file_get_contents(__DIR__ . '/parameters.yml'))['parameters'],

    'sentinel' => require __DIR__ . '/sentinel.php',

    'twig' => [
        'path' => [
            'Core'     => $container['root_dir'] . '/src/Core/Resources/templates',
            'Admin'    => $container['root_dir'] . '/src/Admin/Resources/templates',
            'Security' => $container['root_dir'] . '/src/Security/Resources/templates'
        ],
        'options' => [
            'cache' => $container['root_dir'] . '/var/cache/' . $container['env'] . '/twig',
        ]
    ],

    'monolog' => [
        'name'  => 'app',
        'path'  => $container['root_dir'] . '/var/logs/' . $container['env'] . '.log',
        'level' => Logger::ERROR
    ]

];
