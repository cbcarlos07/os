<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 15:54
 */
class bens_controller
{
    public function getListaBens( $localidade, $setor, $proprietario, $item ){
        require_once '../dao/class.bens_dao.php';
        $bens_dao = new bens_dao();
        $retorno = $bens_dao->getListaBens( $localidade, $setor, $proprietario, $item );
        return $retorno;
    }

    public function getBens(  ){
        require_once '../dao/class.bens_dao.php';
        $bens_dao = new bens_dao();
        $retorno = $bens_dao->getBens( );
        return $retorno;
    }

    public function inserir( $bem ){
        require_once '../dao/class.bens_dao.php';
        $bens_dao = new bens_dao();
        $retorno = $bens_dao->cadastro( $bem );
        return $retorno;
    }

    public function alterar( $bem ){
        require_once '../dao/class.bens_dao.php';
        $bens_dao = new bens_dao();
        $retorno = $bens_dao->altera( $bem );
        return $retorno;
    }

    public function excluir( $bem ){
        require_once '../dao/class.bens_dao.php';
        $bens_dao = new bens_dao();
        $retorno = $bens_dao->excluir( $bem );
        return $retorno;
    }

    public function getProximoCodigo(  ){
        require_once '../dao/class.bens_dao.php';
        $bens_dao = new bens_dao();
        $retorno = $bens_dao->getProximoCodigo(  );
        return $retorno;
    }

    public function getItem( $codigo ){
        require_once '../dao/class.bens_dao.php';
        $bens_dao = new bens_dao();
        $retorno = $bens_dao->getItem( $codigo );
        return $retorno;
    }

}