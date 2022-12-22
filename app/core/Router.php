<?php

namespace App\Core;

use \Closure;
use \Exception;
use ReflectionFiber;
use \ReflectionFunction;
use App\Core\Middleware\Queue as MiddlewareQueue;

class Router
{

    /**
     * URL COMPLETA     
     * @var string
     */
    private $url = '';

    /**
     * Prefixo     
     * @var string
     */
    private $prefixo;

    /**
     * Indice de rotas     
     * @var array
     */
    static private $routes = [];

    /**
     * Instancia de Request     
     * @var Request
     */
    private $request;

    /**
     * Grupo     
     * @var string
     */
    static public $group = '/';

    /**
     * Início
     */
    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();

        require("../app/config/Router.php");
    }

    /**
     * Metodo responsavel por definir o prefixo das rotas          
     */
    private function setPrefix()
    {
        $parseUrl = parse_url($this->url);

        $this->prefix = $parseUrl['path'] ?? '';
    }


    static public function get(string $route, array|Closure|String $Controller, $args = [])
    {
        self::addRoute('GET', $route, $Controller, $args);
    }

    static public function post(string $route, array|Closure|String $Controller, $args = [])
    {
        self::addRoute('POST', $route, $Controller, $args);
    }

    static public function put(string $route, array|Closure|String $Controller, $args = [])
    {
        self::addRoute('PUT', $route, $Controller, $args);
    }

    static public function delete(string $route, array|Closure|String $Controller, $args = [])
    {
        self::addRoute('DELETE', $route, $Controller, $args);
    }

    /**
     * Adicona a rota 
     * @param string $method
     * @param string $route
     * @param array $params
     * @return void
     */
    static public function addRoute(string $method, string $route, array|Closure|String $Controller, array $args = [] )
    {

        $params['variables'] = [];
        $patnerVariable = '/{(.*?)}/';

        if (preg_match_all($patnerVariable, $route, $matches)) {
            $route = preg_replace($patnerVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }


        $ControllerX = array();
        if (is_array($Controller)) {
            //valida os parametros
            foreach ($Controller as $k => $v) {
                if ($v instanceof Closure) {
                    $ControllerX['controller'] = $v;
                    unset($Controller[$k]);
                    continue;
                }
            }
        } else if (is_string($Controller)) {
            $controllerMethod  = explode('@', $Controller);
            $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

            // monta um array para chamar o methodo correto
            $ControllerX['controller'] = [
                'method' => $method,
                'classe' => $controllerMethod[0],
                'metodo' => $controllerMethod[1],
                'params' => $params,
                //'middlewares' => $params['middlewares'] ?? []
            ];
        } else {

            $ControllerX['controller'] = $Controller;
        }

        $ControllerX['middlewares'] = $args['middlewares'] ?? [];

        //padrao de validacao da url
        $paternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        self::$routes[self::$group][$paternRoute][$method] = $ControllerX;
    }

    /**
     * Retorna a URI sem prefixo     
     * @return string
     */
    private function getUri()
    {
        //usado para tirar a / do $_server[URI]
        //substr($this->request->getUri(), 0, 1) == '/' ? substr($this->request->getUri(), 1) :
        $uri  =  $this->request->getUri();

        $xUri = strlen($this->prefixo) ? explode($this->prefixo, $uri) : [$uri];

        //adicionar para remover o grupo
        $ex = explode('/', $uri);
        unset($ex[0]);

        $grupo = $ex[1] ?? '/';


        if (isset(self::$routes[$grupo])) {
            $xUri = strlen($grupo) ? explode($grupo, $uri) : [$uri];
        } else {
            $grupo = '/';
        }

        $pos = strpos(end($xUri), '?');

        if ($pos !== '-1') {

            $ur = explode('?', end($xUri));
            return [$grupo, trim(reset($ur)) != '' ? reset($ur) : '/'];
        }

        return  [$grupo, end($xUri) ?? '/'];
    }

    /**
     * Retorna os dados da rota atual     
     * @return array
     */
    private function getRoute()
    {
        list($grupo, $uri) = $this->getUri();

        $httpMethod = $this->request->getHttpMethod();

        //valida das rotas        
        foreach (self::$routes as $group => $routes) {

            if ($grupo != $group) continue;

            foreach ($routes as $patternRoute => $methods) {

                if (preg_match($patternRoute, $uri, $matches)) {

                    if ($methods[$httpMethod]) {
                        //remove a primeira posição
                        unset($matches[0]);

                        /**
                         * Tranforma a expressao regilar da url em parametros
                         */
                        //chaves 
                        $keys = ($methods[$httpMethod]['controller']['params']['variables']);

                        $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                        $methods[$httpMethod]['request'] = $this->request;

                        return $methods[$httpMethod];
                    }

                    throw new Exception('Método não permitido', 405);
                }
            }
        }

        throw new Exception('URL Não encontrada', 404);
    }
    /**
     * Adiciona um grupo
     * @param [type] $grupo
     * @param [type] $call
     * @return void
     */
    public function group($grupo, $call)
    {
        self::$group =  $grupo ?? '/';
        if ($call instanceof Closure) {
            $call();
            return;
        }

        self::$group = '/';
    }


    /**
     * Executa a rota atual     
     * @return Response
     */
    public function run()
    {
        try {
            $route = $this->getRoute();

            $args = [];

            if (!isset($route['controller'])) {
                throw new Exception('A URL não pode ser processada!', 500);
            }


            if (is_array($route['controller'])) {

                $controller = "\\App\\Controller\\" . $route['controller']['classe'];
                $instance = new $controller;
                $metodo = $route['controller']['metodo'];
                $route['controller'] = array($instance, $metodo);
            }

            $args = $route['variables'];            
            //retorna execução da funcao
            
            return (new MiddlewareQueue($route['middlewares'], $route['controller'] ,array_values($args)))->next($this->request);

            
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Redirecionar a URL     
     * @param string $route     
     */
    public function redirect($route){
        $url = $this->url.'/'.$route;
        //dd($url.$route);
        header('location:'.$url);
        exit;

    }
}
