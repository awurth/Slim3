<?php

return [

    'view' => [
        'templates_path' => [
            $container['root_dir'] . '/src/App/Resources/views',
            $container['root_dir'] . '/src/Security/Resources/views'
        ],
        'twig' => [
            'cache' => $container['root_dir'] . '/var/cache/' . $container['env'] . '/twig',
        ]
    ],

    'monolog' => [
        'name' => 'app',
        'path' => $container['root_dir'] . '/var/logs/' . $container['env'] . '.log'
    ]

];
