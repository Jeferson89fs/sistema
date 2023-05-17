<?php

error_reporting(0);

//$senha = '1234';
//echo $hash = password_hash($senha, PASSWORD_DEFAULT);;
//exit;

require  "../vendor/autoload.php";
require "../app/config/Config.php";
include_once("../app/config/Middleware.php");
require "../app/functions/functions.php";

use App\Controller\Pages\Home;
use App\Core\Response;
use App\Core\Router;
use App\Core\ConfigEnv;

$prefixo =  ConfigEnv::getAttribute('PREFIXO');
$objRoute = new Router(BASE_HTTP, $prefixo); //adiciona as rotas
$objRoute->run()->sendResponse();
