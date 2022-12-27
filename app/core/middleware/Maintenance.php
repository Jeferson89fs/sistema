<?php

namespace App\Core\Middleware;
use App\Interface\MiddlewareInterface;
use App\Core\ConfigEnv;
use Exception;

class Maintenance implements MiddlewareInterface
{
    /**
     * Executa o middleware
     * @param request $request
     * @param [type] $next
     * @return Response
     */
    public function handle($request, $next){

        if(ConfigEnv::getAttribute('MAINTENANCE') == true){
            throw new Exception('Sistema em Manutenção, tente novamente mais tarde!', 200);            
            exit;
        }

        return $next($request);
    }

}

