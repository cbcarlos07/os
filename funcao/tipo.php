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
        getListTipo(  $item  );
        break;
    case 'E':
        getTipo( $codigo );
        break;
    case 'F':
        getTipoList(  );
        break;
    case 'G':
        delete( $codigo );
        break;

}

function salvar( $item ){

    require_once '../controller/class.tipo_controller.php';

    $tipoController = new tipo_controller();

    $bem = array( $item );

    $retorno = $tipoController->inserir( $bem );

    echo json_encode( array( 'retorno' => $retorno ) );

}



function alterar( $codigo, $item ){

    require_once '../controller/class.tipo_controller.php';

    $tipoController = new tipo_controller();

    $bem = array( $codigo, $item );

    $retorno = $tipoController->alterar( $bem );

    echo json_encode( array( 'retorno' => $retorno ) );

}

function getListTipo( $item ){
   require_once '../controller/class.tipo_controller.php';
   $tipoController = new tipo_controller();

   $bem = $tipoController->getListaTipo( $item );

   echo json_encode( $bem );
}

function getTipoList(  ){
    require_once '../controller/class.tipo_controller.php';
    $tipoController = new tipo_controller();

    $bem = $tipoController->getTipoList(  );

    echo json_encode( $bem );
}

function getTipo( $codigo ){
    require_once '../controller/class.tipo_controller.php';
    $tipoController = new tipo_controller();

    $bem = $tipoController->getTipo( $codigo );

    echo json_encode( $bem );
}

function delete( $codigo ){
    require_once '../controller/class.tipo_controller.php';
    $tipoController = new tipo_controller();

    $bem = $tipoController->excluir( $codigo );

    echo json_encode( $bem );
}