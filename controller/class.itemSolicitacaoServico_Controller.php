<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 13/07/2017
 * Time: 10:37
 */
class itemSolicitacaoServico_Controller
{

    public function getListServico( $texto ){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->getListServico( $texto );
        return $retorno;
    }

    public function getListUsuarioEspecie ( $especialidade ){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->getListUsuarioEspecie( $especialidade );
        return $retorno;
    }

    public function getListItens( $cdOs ){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->getListItens( $cdOs );
        return $retorno;
    }

    public function salvarItemOs( itemSolicitacaoServico $item ){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->salvarItemOs( $item );
        return $retorno;
    }

    public function updateItemOs( itemSolicitacaoServico $item ){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->updateItemOs( $item );
        return $retorno;
    }

    public function getItem( $os ){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->getItem( $os );
        return $retorno;
    }

    public function getItOs(){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->getItOs( );
        return $retorno;

    }

    public function excluir( $codigo ){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->excluir( $codigo );
        return $retorno;
    }

    public function getTotalMeusServicos( $usuario ){
        require_once "dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->getTotalMeusServicos( $usuario );
        return $retorno;
    }

    public function getTotalMeusServico( $usuario ){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->getTotalMeusServicos( $usuario );
        return $retorno;
    }

    public function getListItensInfAdd( $cdOs ){
        require_once "../dao/class.itemSolicitacaoServico_dao.php";
        $item_dao = new itemSolicitacaoServico_dao();
        $retorno = $item_dao->getListItensInfAdd(  $cdOs  );
        return $retorno;
    }

}