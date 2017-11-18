<?php

use Monolog\Logger;

return [

    'twig' => [
        'path' => [
            $container['root_dir'] . '/src/Admin/Resources/templates',
            $container['root_dir'] . '/src/Core/Resources/templates',
            $container['root_dir'] . '/src/Security/Resources/templates'
        ],
        'options' => [
            'cache' => $container['root_dir'] . '/var/cache/' . $container['env'] . '/twig',
        ]
    ],

    'monolog' => [
        'name' => 'app',
        'path' => $container['root_dir'] . '/var/logs/' . $container['env'] . '.log',
        'level' => Logger::ERROR
    ]

];
