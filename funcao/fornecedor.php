<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 12/03/2018
 * Time: 09:25
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$acao = $_POST['acao'];
$fornecedor   = 0;
$sigla        = 0;
$ativo        = 0;


if( isset( $_POST['fornecedor'] ) ){
    $fornecedor = $_POST['fornecedor'];
}

if( isset( $_POST['sigla'] ) ){
    $sigla = $_POST['sigla'];
}

if( isset( $_POST['ativo'] ) ){
    $ativo = $_POST['ativo'];
}

switch ( $acao ){
    case 'A':
          salvar( $fornecedor, $sigla, $ativo );
        break;
    case 'B':
        getCodigo();
        break;
    case 'C':
        alterar( $fornecedor, $sigla, $ativo );
        break;
    case 'D':
        getListFornecedor(  );
        break;
    case 'E':
        getItem( $fornecedor );
        break;
    case 'F':
        getFornecedor(  );
        break;
    case 'G':
        delete( $fornecedor );
        break;
    case 'H':
        getFornecedorAtivo(  );
        break;

}

function salvar( $fornecedor, $sigla, $ativo ){

    require_once '../controller/class.fornecedor_controller.php';

    $bemController = new fornecedor_controller();

    $bem = array( $fornecedor, $sigla, $ativo );

    $retorno = $bemController->inserir( $bem );

    echo json_encode( array( 'retorno' => $retorno ) );

}


function alterar( $fornecedor, $sigla, $ativo ){

    require_once '../controller/class.fornecedor_controller.php';

    $bemController = new fornecedor_controller();

    $bem = array( $fornecedor, $sigla, $ativo );

    $retorno = $bemController->alterar( $bem );

    echo json_encode( array( 'retorno' => $retorno ) );

}

function getListFornecedor(  ){
   require_once '../controller/class.fornecedor_controller.php';
   $bemController = new fornecedor_controller();

   $bem = $bemController->getListaFornecedor(  );

   echo json_encode( $bem );
}

function getFornecedor(  ){
    require_once '../controller/class.fornecedor_controller.php';
    $bemController = new fornecedor_controller();

    $bem = $bemController->getFornecedor(  );

    echo json_encode( $bem );
}

function getFornecedorAtivo(  ){
    require_once '../controller/class.fornecedor_controller.php';
    $bemController = new fornecedor_controller();

    $bem = $bemController->getFornecedorAtivo(  );

    echo json_encode( $bem );
}

function getItem( $codigo ){
    require_once '../controller/class.fornecedor_controller.php';
    $bemController = new fornecedor_controller();

    $bem = $bemController->getItem( $codigo );

    echo json_encode( $bem );
}

function delete( $codigo ){
    require_once '../controller/class.fornecedor_controller.php';
    $bemController = new fornecedor_controller();

    $bem = $bemController->excluir( $codigo );

    echo json_encode( $bem );
}