<?php

use Monolog\Logger;
use Symfony\Component\Yaml\Yaml;

return [

    'parameters' => Yaml::parse(file_get_contents(__DIR__ . '/parameters.yml'))['parameters'],

    'sentinel' => require __DIR__ . '/sentinel.php',

    'twig' => [
        'path' => [
            $container['root_dir'] . '/templates'
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
