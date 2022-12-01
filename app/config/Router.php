<?php

use App\Core\Router;
use App\Core\Response;

// Router::get('teste' ,  function(){
//                             return new  Response('200' , App\Controller\Pages\Home::getHome());
//                         }
              
//         );

//Router::get('/' , 'Home@getHome');

Router::get('/{x}' , 'Home@getHome');

Router::group('admin' , function(){
    Router::get('/{a}/{y}' , 'Home@getHome2', ['middlewares' => ['Maintenance']]);
});


// Router::get('/' , function(){
//     return new  Response('200' , App\Controller\Pages\Home::getHome());
// });

