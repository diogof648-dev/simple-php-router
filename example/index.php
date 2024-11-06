<?php

require __DIR__ . '/../vendor/autoload.php';
require 'Controller.php';

use Diogof648\SimplePhpRouter\Router;

Router::get('/', function () {
    echo "Home";
});

Router::get('/home', function () {
   header('Location: /');
});

Router::get('/panel', [Controller::class, 'panel']);

# EXAMPLE
# If method is a static method
# Router::get('/ROUTE', [CLASS::class, 'CLASS METHOD']);  -> get/post/patch/delete/put/any
# If method is a public method
# Router::get('/ROUTE', [new Class(), 'CLASS METHOD']);  -> get/post/patch/delete/put/any