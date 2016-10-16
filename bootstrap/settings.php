<?php
return [
    'settings' => [

        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,

        'view' => [
            'template_path' => __DIR__ . '/../src/App/View',
            'twig' => [
                'cache' => __DIR__ . '/../cache',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

    ],
];