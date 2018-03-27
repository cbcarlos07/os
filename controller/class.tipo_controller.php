<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 15:54
 */
class tipo_controller
{
    public function getListaTipo( $tipo ){
        require_once '../dao/class.tipo_dao.php';
        $tipo_dao = new Tipo_dao();
        $retorno = $tipo_dao->getListaTipo( $tipo );
        return $retorno;
    }

    public function getTipoList(  ){
        require_once '../dao/class.tipo_dao.php';
        $tipo_dao = new Tipo_dao();
        $retorno = $tipo_dao->getTipoList( );
        return $retorno;
    }

    public function inserir( $tipo ){
        require_once '../dao/class.tipo_dao.php';
        $tipo_dao = new Tipo_dao();
        $retorno = $tipo_dao->cadastro( $tipo );
        return $retorno;
    }

    public function alterar( $tipo ){
        require_once '../dao/class.tipo_dao.php';
        $tipo_dao = new Tipo_dao();
        $retorno = $tipo_dao->altera( $tipo );
        return $retorno;
    }

    public function excluir( $tipo ){
        require_once '../dao/class.tipo_dao.php';
        $tipo_dao = new Tipo_dao();
        $retorno = $tipo_dao->excluir( $tipo );
        return $retorno;
    }


    public function getTipo( $codigo ){
        require_once '../dao/class.tipo_dao.php';
        $tipo_dao = new Tipo_dao();
        $retorno = $tipo_dao->getTipo( $codigo );
        return $retorno;
    }

}