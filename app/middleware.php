<?php

$app->add(new Security\Middleware\CsrfMiddleware($container));
$app->add(new Slim\Csrf\Guard());
