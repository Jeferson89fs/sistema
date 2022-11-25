<?php

use App\Core\Router;
use App\Core\Response;

Router::get('teste' ,  function(){
                            return new  Response('200' , App\Controller\Pages\Home::getHome());
                        }
              
        );

Router::get('/' ,  function(){
            return new  Response('200' , App\Controller\Pages\Home::getHome());
        }

);

