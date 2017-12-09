<?php

use Monolog\Logger;
use Symfony\Component\Yaml\Yaml;

return [

    'parameters' => Yaml::parse(file_get_contents($app->getConfigurationDir().'/parameters.yml'))['parameters'],

    'sentinel' => require $app->getConfigurationDir().'/sentinel.php',

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
