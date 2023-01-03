<?php

use App\Core\Router;
use App\Core\Response;

Router::get('/', 'Home@getHome');

Router::group('admin', function () {
  
    /**
     * Login
     */
    Router::get('/login',   'Admin\Login@getLogin');
    Router::post('/login',  'Admin\Login@verificaLogin');
    Router::get('/logout', 'Admin\Login@logout');

    /**
     * Depoimentos
     */
    Router::get('/depoimento', 'Admin\Depoimento@index');  //index
    Router::post('/depoimento', 'Admin\Depoimento@index'); //consulta


    Router::get('/',       'Admin\Home@getIndex', ['middlewares' => ['LoginAdmin']]);
});
