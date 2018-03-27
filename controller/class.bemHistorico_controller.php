<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 15:54
 */
class bemHistorico_controller
{
    public function getListaHistorico( $bem ){
        require_once '../dao/class.bemHistorico_dao.php';
        $bemHistorico_dao = new bemHistorico_dao();
        $retorno = $bemHistorico_dao->getListaHistorico( $bem );
        return $retorno;
    }



    public function inserir( $bem ){
        require_once '../dao/class.bemHistorico_dao.php';
        $bemHistorico_dao = new bemHistorico_dao();
        $retorno = $bemHistorico_dao->cadastro( $bem );
        return $retorno;
    }



    public function excluir( $bem ){
        require_once '../dao/class.bemHistorico_dao.php';
        $bemHistorico_dao = new bemHistorico_dao();
        $retorno = $bemHistorico_dao->excluir( $bem );
        return $retorno;
    }


}