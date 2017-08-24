<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 17:07
 */
class setor_controller
{
    public function getListaSetor( ){
        require_once 'dao/class.setor_dao.php';
        $setorDAO = new setor_dao();
        $retorno = $setorDAO->getListaSetor();
        return $retorno;
    }

    public function getListaSetor1( ){
        require_once '../dao/class.setor_dao.php';
        $setorDAO = new setor_dao();
        $retorno = $setorDAO->getListaSetor1();
        return $retorno;
    }

    public function getPrimeiroSetor(){
        require_once 'dao/class.setor_dao.php';
        $setorDAO = new setor_dao();
        $retorno = $setorDAO->getPrimeiroSetor();
        return $retorno;
    }
}