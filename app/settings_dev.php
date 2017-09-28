<?php

return [
    'env' => 'dev',
    'settings' => [

        'displayErrorDetails' => true,

        'assets' => [
            'base_path' => '../'
        ],

        'view' => [
            'twig' => [
                'debug' => true,
                'auto_reload' => true
            ]
        ],

        'monolog' => [
            'path' => dirname(__DIR__) . '/var/logs/dev.log'
        ]

    ]
];
