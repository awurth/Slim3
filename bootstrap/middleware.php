<?php

$app->add(new \App\Middleware\CsrfMiddleware($container));
$app->add(new \Slim\Csrf\Guard());
