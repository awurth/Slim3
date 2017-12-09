<?php

use Monolog\Logger;
use Symfony\Component\Yaml\Yaml;

return [

    'parameters' => Yaml::parse(file_get_contents(__DIR__.'/parameters.yml'))['parameters'],

    'sentinel' => require __DIR__.'/sentinel.php',

    'twig' => [
        'path' => [
            $app->getRootDir().'/templates'
        ],
        'options' => [
            'cache' => $app->getCacheDir().'/twig',
        ]
    ],

    'monolog' => [
        'name'  => 'app',
        'path'  => $app->getLogDir().'/'.$app->getEnvironment().'.log',
        'level' => Logger::ERROR
    ]

];
