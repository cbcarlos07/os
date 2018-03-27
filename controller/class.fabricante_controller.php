<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 15:54
 */
class fabricante_controller
{
    public function getListaFabricante( $fabricante ){
        require_once '../dao/class.fabricante_dao.php';
        $fabricante_dao = new Fabricante_dao();
        $retorno = $fabricante_dao->getListaFabricante( $fabricante );
        return $retorno;
    }

    public function getFabricanteList(  ){
        require_once '../dao/class.fabricante_dao.php';
        $fabricante_dao = new Fabricante_dao();
        $retorno = $fabricante_dao->getFabricanteList( );
        return $retorno;
    }

    public function inserir( $fabricante ){
        require_once '../dao/class.fabricante_dao.php';
        $fabricante_dao = new Fabricante_dao();
        $retorno = $fabricante_dao->cadastro( $fabricante );
        return $retorno;
    }

    public function alterar( $fabricante ){
        require_once '../dao/class.fabricante_dao.php';
        $fabricante_dao = new Fabricante_dao();
        $retorno = $fabricante_dao->altera( $fabricante );
        return $retorno;
    }

    public function excluir( $fabricante ){
        require_once '../dao/class.fabricante_dao.php';
        $fabricante_dao = new Fabricante_dao();
        $retorno = $fabricante_dao->excluir( $fabricante );
        return $retorno;
    }


    public function getFabricante( $codigo ){
        require_once '../dao/class.fabricante_dao.php';
        $fabricante_dao = new Fabricante_dao();
        $retorno = $fabricante_dao->getFabricante( $codigo );
        return $retorno;
    }

}