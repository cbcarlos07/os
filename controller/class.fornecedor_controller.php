<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 15:54
 */
class fornecedor_controller
{
    public function getListaFornecedor(  ){
        require_once '../dao/class.fornecedor_dao.php';
        $fornecedor_dao = new fornecedor_dao();
        $retorno = $fornecedor_dao->getListaFornecedor(  );
        return $retorno;
    }

    public function getFornecedor(  ){
        require_once '../dao/class.fornecedor_dao.php';
        $fornecedor_dao = new fornecedor_dao();
        $retorno = $fornecedor_dao->getFornecedor( );
        return $retorno;
    }

    public function inserir( $bem ){
        require_once '../dao/class.fornecedor_dao.php';
        $fornecedor_dao = new fornecedor_dao();
        $retorno = $fornecedor_dao->cadastro( $bem );
        return $retorno;
    }

    public function alterar( $bem ){
        require_once '../dao/class.fornecedor_dao.php';
        $fornecedor_dao = new fornecedor_dao();
        $retorno = $fornecedor_dao->altera( $bem );
        return $retorno;
    }

    public function excluir( $bem ){
        require_once '../dao/class.fornecedor_dao.php';
        $fornecedor_dao = new fornecedor_dao();
        $retorno = $fornecedor_dao->excluir( $bem );
        return $retorno;
    }


    public function getItem( $codigo ){
        require_once '../dao/class.fornecedor_dao.php';
        $fornecedor_dao = new fornecedor_dao();
        $retorno = $fornecedor_dao->getItem( $codigo );
        return $retorno;
    }

}