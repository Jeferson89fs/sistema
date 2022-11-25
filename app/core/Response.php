<?php

namespace App\Core;

class Response
{

    /**
     * Codigo do status de retorno HTTP     
     * @var integer
     */
    private $httpCode = 200;

    /**
     * Headers/ Cabeçalho do Response     
     * @var array
     */
    private $headers = [];

    /**
     * tipo de resposta/ tipo de conteudo     
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Conteudo do response     
     * @var mixed
     */
    private $content;

    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Altera o Contentype do response     
     * @param string $contentType
     * @return void
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Adiciona atriubutos ao  Headcer
     * @param [type] $chave
     * @param [type] $valor
     * @return void
     */
    public function addHeader($chave, $valor)
    {
        $this->headers[$chave] = $valor;
    }

    /**
     * Envia os headers          
     */
    private function sendHeaders()
    {
        http_response_code($this->httpCode);
        foreach ($this->headers as $c => $v) {
            header($c . ':' . $v);
        }
    }

    /**
     * Envia a resposta pro usuário          
     */
    public function sendResponse()
    {
        $this->sendHeaders();

        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
                break;

            default:
                # code...
                break;
        }
    }
}
