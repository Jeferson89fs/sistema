<?php

namespace App\Core\Middleware;

use App\Interface\MiddlewareInterface;
use App\Session\Admin\Login as LoginSession;
use FFI\Exception;
use App\Core\ConfigEnv;
use App\Core\Router;

class LoginAdmin implements MiddlewareInterface
{
    /**
     * Executa o middleware
     * @param request $request
     * @param [type] $next
     * @return Response
     */
    public function handle($request, $next)
    {
        if(!LoginSession::isLogged()){
            $prefixo =  ConfigEnv::getAttribute('PREFIXO');
            $objRoute = new Router(BASE_HTTP, $prefixo); //adiciona as rotas
            $objRoute->redirect('admin/login');
            exit;
        }

        return $next($request);
    }

    
}
