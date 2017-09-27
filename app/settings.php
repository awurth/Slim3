<?php

return [
    'env' => 'prod',
    'settings' => [

        'displayErrorDetails' => false,

        'view' => [
            'template_path' => dirname(__DIR__) . '/src/App/Resources/views',
            'twig' => [
                'cache' => dirname(__DIR__) . '/cache/twig',
                'debug' => true,
                'auto_reload' => true
            ]
        ]

    ]
];
