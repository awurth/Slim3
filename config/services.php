<?php
//register your services here
$container['my.custom.service'] = function($container) {
    $object = new StdClass();
    $object->message = "my custom service";

    return $object;
};