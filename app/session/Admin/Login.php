<?php

namespace App\Session\Admin;

class Login
{

    private static function init(){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    public static function login(array $Usuario)
    {
        self::init();

        $_SESSION['admin']['usuario'] = [
            'id' =>  $Usuario['id_usuario'],
            'nome' => $Usuario['nome'],
            'email' => $Usuario['email'],            
        ];
        
        return true;

    }

    public static function logout()
    {
        self::init();

        unset($_SESSION['admin']['usuario']);
        
        return true;

    }

    

    public static function isLogged(){         
        self::init();

        return isset($_SESSION['admin']['usuario']['id']);
    }
}
