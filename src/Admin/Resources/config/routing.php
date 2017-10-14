<?php

$app->group('/admin', function () {
    $this->get('', 'admin.controller:home')
        ->setName('admin.home');
})->add($container['auth.middleware']('admin'));
