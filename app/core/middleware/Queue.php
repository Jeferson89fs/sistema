<?php

namespace App\Core\Middleware;

use App\Core\Request;
use Closure;
use App\Core\Response;
use Exception;

class Queue
{

    /**
     * Mapeamento de middlwares
     * @var array
     */

    private static $map = [];
    /**
     * Mapeamento de middlwares default
     * @var array
     */
    private static $mapDefault = [];

    /**
     * Fila de middlewares a serem executados
     * @var array
     */
    private $middlewares = [];

    /**
     * Função de execuçãodo controlador     
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos do controller
     *  @var array
     */
    private $controllerArgs = [];


    /**
     * Undocumented function
     *
     * @param array $middlewares
     * @param array $controller
     * @param array $controllerArgs
     */
    public function __construct(array $middlewares, array $controller, array $controllerArgs)
    {
        $this->middlewares = array_merge(self::$mapDefault, $middlewares);
        $this->controller  = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * Método responsavel por definir o mapeamento  
     * @param [type] $map
     * @return void
     */
    public static function setMap($map)
    {
        self::$map = $map;
    }

    /**
     * Método responsavel por definir o mapeamento default
     * @param [type] $map
     * @return void
     */
    public static function setMapDefault($map)
    {
        self::$mapDefault = $map;
    }

    /**
     * Método responsável por executar o proximo nivel de middlewares     
     * @param Request $request
     * @return Response
     */
    public function next(Request $request)
    {


        //verificar se a fila esta vazia
        if (empty($this->middlewares)) return new Response(200, call_user_func_array($this->controller, array_values($this->controllerArgs)));


        $middleware = array_shift($this->middlewares);

        //verifica o mapeamento
        if (!isset(self::$map[$middleware])) {
            throw new Exception('Problemas ao processar o Middleware!', 500);
        }

        $queue = $this;

        $next = function ($request) use ($queue) {
            return $queue->next($request);
        };

        return (new self::$map[$middleware])->handle($request, $next);
    }
}
