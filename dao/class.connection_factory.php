<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 14/06/2017
 * Time: 17:24
 */
include_once __DIR__.'/../vendor/autoload.php';
$dotenv = new \Dotenv\Dotenv(__DIR__."/../");
$dotenv->load();
define("DB_USER", getenv('DB_USER') );
define("DB_PWD", getenv('DB_PWD') );
define("DB_PRD", getenv('DB_PRD') );
define("DB_SML", getenv('DB_SML') );
define("DB_SRVC_PRD", getenv('DB_SRVC_PRD') );
define("DB_SRVC_SML", getenv('DB_SRVC_SML') );
define("DB_URL_SML", getenv('DB_URL_SML') );

class connection_factory
{


    private $ora_user = DB_USER;
    private $ora_senha = DB_PWD;
    private $ora_bd = DB_URL_SML;

    public function getConnection()
    {

        putenv("NLS_LANG=PORTUGUESE_BRAZIL.AL32UTF8") or die("Falha ao inserir a variavel de ambiente");
        $ora_conexao = oci_connect($this->ora_user, $this->ora_senha, $this->ora_bd);
        return $ora_conexao;

    }

    public function closeConnection($connection)
    {
        $ora_conexao = oci_close($connection);

    }
}
