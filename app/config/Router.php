<?php

use App\Core\Router;
use App\Core\Response;

// Router::get('teste' ,  function(){
//                             return new  Response('200' , App\Controller\Pages\Home::getHome());
//                         }
              
//         );

//Router::get('/' , 'Home@getHome');

Router::get('/' , 'Home@getHome');

Router::group('admin' , function(){
    
    Router::get('/login' ,  'Admin\Login@getLogin'); //, ['middlewares' => ['LoginAdmin']]
    Router::post('/login' , 'Admin\Login@verificaLogin'); //, ['middlewares' => ['LoginAdmin']]


    Router::get('/' ,       'Admin\Home@getIndex',['middlewares' => ['LoginAdmin']]); //, ['middlewares' => ['LoginAdmin']]

});


// Router::get('/' , function(){
//     return new  Response('200' , App\Controller\Pages\Home::getHome());
// });

