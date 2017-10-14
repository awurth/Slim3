<?php

$app->group('/admin', function () use ($container) {
    $this->get('', 'admin.controller:home')
        ->setName('admin.home');
})->add($container['auth.middleware']('admin'));
