<?php

return [
    'settings' => [

        'displayErrorDetails' => true,

        'view' => [
            'template_path' => __DIR__ . '/../src/App/Resources/views',
            'twig' => [
                'cache' => __DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ]
        ]

    ]
];
