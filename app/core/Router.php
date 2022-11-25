<?php

namespace App\Core;

use \Closure;
use \Exception;


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


   static public function get(string $route, array|Closure $params )
    {
        self::addRoute('GET', $route, $params);
    }

    static public function post(string $route, array $params = [])
    {
        self::addRoute('POST', $route, $params);
    }

    static public function put(string $route, array $params = [])
    {
        self::addRoute('PUT', $route, $params);
    }

    static public function delete(string $route, array $params = [])
    {
        self::addRoute('DELETE', $route, $params);
    }

    /**
     * Adicona a rota 
     * @param string $method
     * @param string $route
     * @param array $params
     * @return void
     */
    static public function addRoute(string $method, string $route, array|Closure $params)
    {

        // dd($params, false);
        //valida os parametros
        foreach ($params as $k => $v) {
            if ($v instanceof Closure) {

                $params['controller'] = $v;
                unset($params[$k]);
                continue;
            }
        }

        //padrao de validacao da url
        $paternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        self::$routes[$paternRoute][$method] = $params;
    }

    /**
     * Retorna a URI sem prefixo     
     * @return string
     */
    private function getUri()
    {
        //usado para tirar a / do $_server[URI]
        $uri =  substr($this->request->getUri(), 0, 1) == '/' ? substr($this->request->getUri(), 1) : $this->request->getUri();
        $xUri = strlen($this->prefixo) ? explode($this->prefixo, $uri) : [$uri];
        return end($xUri);
    }

    /**
     * Retorna os dados da rota atual     
     * @return array
     */
    private function getRoute()
    {

        $uri = $this->getUri();

        $httpMethod = $this->request->getHttpMethod();

        echo 'rotas : '."<br>";
        dd(self::$routes);
        //valida das rotas
        foreach (self::$routes as $patternRoute => $methods) {

            if (preg_match($patternRoute, $uri)) {
                return $methods[$httpMethod];
            }

            throw new Exception('Método não permitido', 405);
        }

        throw new Exception('URL Não encontrada', 404);
    }

    /**
     * Executa a rota atual     
     * @return Response
     */
    public function run()
    {
        try {
            $route = $this->getRoute();

            if(!isset($route['controller'])){
                throw new Exception('A URL não pode ser processada!', 500);
            }

            $args = [];

            return call_user_func_array($route['controller'], $args);


            return new Response(200, 'zz');
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
