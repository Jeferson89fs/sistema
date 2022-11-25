<?php


namespace App\Core;

class Request
{


    /**
     * Método HTTP da requisição
     * @var [string]
     */
    private $httpMethod;

    /**
     * URI da Página     
     * @var [string]
     */
    private $uri;

    /**
     * parametros da url
     * @var [array]
     */
    private $queryParams = [];

    /**
     * variaveis recebidas no POST
     * @var [array]
     */
    private $postVars = [];


    /**
     * Cabeçalho da requisição
     * @var [array]
     */
    private $headers = [];



    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    /**
     * Retorna o método da requisição     
     * @return void
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Retorna a URI
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Retorna o headers
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * retorna o Post
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

    /**
     * Retorna os parametros     
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }
}
