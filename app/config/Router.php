<?php

use App\Core\Router;
use App\Core\Response;

Router::get('/', 'Home@getHome');

Router::group('admin', function () {

    Router::get('/login',   'Admin\Login@getLogin');
    Router::post('/login',  'Admin\Login@verificaLogin');
    Router::get('/logout', 'Admin\Login@logout');

    Router::get('/',       'Admin\Home@getIndex', ['middlewares' => ['LoginAdmin']]);
});