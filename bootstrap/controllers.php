<?php

$container['AppController'] = function ($container) {
    return new App\Controller\AppController($container);
};
