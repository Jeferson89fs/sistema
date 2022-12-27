<?php

namespace App\Model;

use App\Core\ConfigEnv;
use PDO;

class Conexao
{

    private static $connection;

    private $driver;

    private $host;

    private $port;

    private $database;

    private $username;

    private $password;


    public function __construct()
    {

        $this->driver = ConfigEnv::getAttribute('DB_CONNECTION');
        $this->host = ConfigEnv::getAttribute('DB_HOST');
        $this->port = ConfigEnv::getAttribute('DB_PORT');
        $this->database = ConfigEnv::getAttribute('DB_DATABASE');
        $this->username = ConfigEnv::getAttribute('DB_USERNAME');
        $this->password = ConfigEnv::getAttribute('DB_PASSWORD');

        $this->setConnection();
    }

    private function setConnection()
    {

        try {

            if (!isset(self::$connection)) {

                $con =  new PDO("$this->driver:host=$this->host;dbname=$this->database;port:$this->port", $this->username, $this->password);

                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection = $con;
            }

            return self::$connection;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getConnection(){
        return self::$connection;
    }
}
