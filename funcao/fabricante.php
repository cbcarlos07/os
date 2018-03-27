<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 12/03/2018
 * Time: 09:25
 */

$acao = $_POST['acao'];
$codigo       = 0;
$item         = "";

if( isset( $_POST['codigo'] ) ){
    $codigo = $_POST['codigo'];
}

if( isset( $_POST['item'] ) ){
    $item = $_POST['item'];
}

switch ( $acao ){
    case 'A':
          salvar( $item );
        break;
    case 'B':
        getCodigo();
        break;
    case 'C':
        alterar( $codigo, $item );
        break;
    case 'D':
        getListFabricante(  $item  );
        break;
    case 'E':
        getFabricante( $codigo );
        break;
    case 'F':
        getFabricanteList(  );
        break;
    case 'G':
        delete( $codigo );
        break;

}

function salvar( $item ){

    require_once '../controller/class.fabricante_controller.php';

    $fabricanteController = new fabricante_controller();

    $bem = array( $item );
    //echo "Item: ".$item;
    $retorno = $fabricanteController->inserir( $bem );

    echo json_encode( array( 'retorno' => $retorno ) );

}



function alterar( $codigo, $item ){

    require_once '../controller/class.fabricante_controller.php';

    $fabricanteController = new fabricante_controller();

    $bem = array( $codigo, $item );

    $retorno = $fabricanteController->alterar( $bem );

    echo json_encode( array( 'retorno' => $retorno ) );

}

function getListFabricante( $item ){
   require_once '../controller/class.fabricante_controller.php';
   $fabricanteController = new fabricante_controller();

   $bem = $fabricanteController->getListaFabricante( $item );

   echo json_encode( $bem );
}

function getFabricanteList(  ){
    require_once '../controller/class.fabricante_controller.php';
    $fabricanteController = new fabricante_controller();

    $bem = $fabricanteController->getFabricanteList(  );

    echo json_encode( $bem );
}

function getFabricante( $codigo ){
    require_once '../controller/class.fabricante_controller.php';
    $fabricanteController = new fabricante_controller();

    $bem = $fabricanteController->getFabricante( $codigo );

    echo json_encode( $bem );
}

function delete( $codigo ){
    require_once '../controller/class.fabricante_controller.php';
    $fabricanteController = new fabricante_controller();

    $bem = $fabricanteController->excluir( $codigo );

    echo json_encode( $bem );
}