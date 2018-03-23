<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 12/03/2018
 * Time: 09:25
 */

$acao = $_POST['acao'];
$codigo       = 0;
$item         = 0;
$setor        = 0;
$localidade   = 0;
$proprietario = 0;
$patrimonio   = "";

if( isset( $_POST['codigo'] ) ){
    $codigo = $_POST['codigo'];
}

if( isset( $_POST['item'] ) ){
    $item = $_POST['item'];
}

if( isset( $_POST['setor'] ) ){
    $setor = $_POST['setor'];
}

if( isset( $_POST['localidade'] ) ){
    $localidade = $_POST['localidade'];
}

if( isset( $_POST['proprietario'] ) ){
    $proprietario = $_POST['proprietario'];
}

if( isset( $_POST['patrimonio'] ) ){
    $patrimonio = $_POST['patrimonio'];
}

switch ( $acao ){
    case 'A':
          salvar( $codigo, $item, $setor, $localidade, $proprietario, $patrimonio );
        break;
    case 'B':
        getCodigo();
        break;
    case 'C':
        alterar( $codigo, $item, $setor, $localidade, $proprietario, $patrimonio );
        break;
    case 'D':
        getListBens(  $localidade, $setor, $proprietario, $item  );
        break;
    case 'E':
        getItem( $codigo );
        break;
    case 'F':
        getBens(  );
        break;

}

function salvar( $codigo, $item, $setor, $localidade, $proprietario, $patrimonio ){

    require_once '../controller/class.bens_controller.php';

    $bemController = new bens_controller();

    $bem = array( $codigo, $item, $setor, $localidade, $proprietario, $patrimonio );

    $retorno = $bemController->inserir( $bem );

    echo json_encode( array( 'retorno' => $retorno ) );

}

function getCodigo(){
    require_once '../controller/class.bens_controller.php';
    $bemController = new bens_controller();
    $retorno = $bemController->getProximoCodigo();
    echo json_encode( $retorno );
}

function alterar( $codigo, $item, $setor, $localidade, $proprietario, $patrimonio ){

    require_once '../controller/class.bens_controller.php';

    $bemController = new bens_controller();

    $bem = array( $codigo, $item, $setor, $localidade, $proprietario, $patrimonio );

    $retorno = $bemController->alterar( $bem );

    echo json_encode( array( 'retorno' => $retorno ) );

}

function getListBens( $localidade, $setor, $proprietario, $item ){
   require_once '../controller/class.bens_controller.php';
   $bemController = new bens_controller();

   $bem = $bemController->getListaBens( $localidade, $setor, $proprietario, $item );

   echo json_encode( $bem );
}

function getBens(  ){
    require_once '../controller/class.bens_controller.php';
    $bemController = new bens_controller();

    $bem = $bemController->getBens(  );

    echo json_encode( $bem );
}

function getItem( $codigo ){
    require_once '../controller/class.bens_controller.php';
    $bemController = new bens_controller();

    $bem = $bemController->getItem( $codigo );

    echo json_encode( $bem );
}

function delete( $codigo ){
    require_once '../controller/class.bens_controller.php';
    $bemController = new bens_controller();

    $bem = $bemController->de( $codigo );

    echo json_encode( $bem );
}