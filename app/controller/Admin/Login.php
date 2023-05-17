<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Core\DB;
use App\Utils\View;
use App\Model\Usuario;
use App\Core\Request;
use App\Session\Admin\Login as SessionLogin;
use App\Core\ConfigEnv;
use App\Core\Router;

class Login extends Page
{


    public function getLogin()
    {
        SessionLogin::logout();

        return View::render('admin/login/login', [], true, 'admin/login');
    }

    public function verificaLogin()
    {

        $email = $_REQUEST['email'] ?? '';
        $senha = $_REQUEST['senha'] ?? '';

        $usuario = new Usuario;
        $usuario = $usuario->where('email', '=', $email)->get('id_usuario, nome, senha, email');

        $hash = password_hash(trim($senha), PASSWORD_DEFAULT);

        //echo $usuario['senha'];
        //echo "<br>";
        //echo $hash;
        
        if (!password_verify(trim($senha), trim($usuario['senha']))) {
            $_REQUEST['senha'] = '';
            return $this->getLogin();
        }

        SessionLogin::login($usuario);

        Router::redirect('admin');

        //return View::render('admin/login', [], true, 'admin');
    }

    public function logout()
    {
        SessionLogin::logout();

        Router::redirect('admin/login');
    }
}
