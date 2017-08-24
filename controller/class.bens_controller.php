<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 15:54
 */
class bens_controller
{
    public function getListaBens( $setor){
        require_once 'dao/class.bens_dao.php';
        $bens_dao = new bens_dao();
        $retorno = $bens_dao->getListaBens( $setor );
        return $retorno;
    }
}