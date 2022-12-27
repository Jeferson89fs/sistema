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

        return View::render('admin/login', [], true, 'admin');
    }

    public function verificaLogin()
    {

        $email = $_REQUEST['email'] ?? '';
        $senha = $_REQUEST['senha'] ?? '';

        $usuario = new Usuario;
        $usuario = $usuario->where('email', '=', $email)->get('id_usuario, nome, senha, email');

        $hash = password_hash($senha, PASSWORD_DEFAULT);

        if (!password_verify($senha, $usuario['senha'])) {
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
