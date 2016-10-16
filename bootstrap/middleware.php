<?php

$app->add(new \App\Middleware\CsrfMiddleware($container));
$app->add($container['csrf']);
