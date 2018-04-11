<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 12/03/2018
 * Time: 09:25
 */
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

$acao = $_POST['acao'];
$codigo       = 0;
$item         = 0;
$serie        = 0;
$tipo         = 0;
$fabricante   = 0;
$proprietario = 0;
$patrimonio   = "";
$setor        = 0;
$localidade   = 0;
$data         = "";
$usuario      = "";


if( isset( $_POST['codigo'] ) ){
    $codigo = $_POST['codigo'];
}

if( isset( $_POST['item'] ) ){
    $item = $_POST['item'];
}

if( isset( $_POST['serie'] ) ){
    $serie = $_POST['serie'];
}

if( isset( $_POST['tipo'] ) ){
    $tipo = $_POST['tipo'];
}

if( isset( $_POST['fabricante'] ) ){
    $fabricante = $_POST['fabricante'];
}


if( isset( $_POST['proprietario'] ) ){
    $proprietario = $_POST['proprietario'];
}

if( isset( $_POST['patrimonio'] ) ){
    $patrimonio = $_POST['patrimonio'];
}

if( isset( $_POST['setor'] ) ){
    $setor = $_POST['setor'];
}
if( isset( $_POST['localidade'] ) ){
    $localidade = $_POST['localidade'];
}
if( isset( $_POST['data'] ) ){
    $data = $_POST['data'];
}

if( isset( $_POST['usuario'] ) ){
    $usuario = $_POST['usuario'];
}

switch ( $acao ){
    case 'A':
          salvar( $codigo, $item, $serie, $tipo, $fabricante, $proprietario, $patrimonio, $setor, $localidade, $data, $usuario );
        break;
    case 'B':
        getCodigo();
        break;
    case 'C':
        alterar( $codigo, $item, $serie, $tipo, $fabricante, $proprietario, $patrimonio, $setor, $localidade, $data, $usuario  );
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
    case 'G':
        getItemCodigo( $codigo );
        break;

}

function salvar( $codigo, $item, $serie, $tipo, $fabricante, $proprietario, $patrimonio, $setor, $localidade, $data, $usuario ){

    /*echo "Codigo: $codigo \n";
    echo "Item: $item \n";
    echo "Tipo: $tipo \n";
    echo "Fabricante: $fabricante \n";
    echo "Proprietario: $proprietario \n";
    echo "Patrimonio: $patrimonio \n";*/





    require_once '../controller/class.bemHistorico_controller.php';
    require_once '../controller/class.bens_controller.php';

    $bemController = new bens_controller();
    $bemHistController = new bemHistorico_controller();

    $bem = array( $codigo, $item, $proprietario, $serie, $patrimonio, $tipo, $fabricante );

    $retorno = $bemController->inserir( $bem );

    if( $retorno ){

        foreach ( $setor as $s => $set ){

            $h = array( $codigo, $set, $localidade[$s], $data[$s], $usuario[$s] );
            $return = $bemHistController->inserir( $h );
            /*echo "Setor: ".$set." - ".$s."\n";
            echo "Localidade: ".$localidade[$s]."\n";
            echo "Data: ".$data[$s]."\n";
            echo "Usuario: ".$usuario[$s]."\n";*/
        }
    }



    echo json_encode( array( 'retorno' => $retorno ) );

}

function getCodigo(){
    require_once '../controller/class.bens_controller.php';
    $bemController = new bens_controller();
    $retorno = $bemController->getProximoCodigo();
    echo json_encode( $retorno );
}

function alterar( $codigo, $item, $serie, $tipo, $fabricante, $proprietario, $patrimonio, $setor, $localidade, $data, $usuario ){

    require_once '../controller/class.bemHistorico_controller.php';
    require_once '../controller/class.bens_controller.php';

    $bemController = new bens_controller();
    $bemHistController = new bemHistorico_controller();

    $bem = array( $codigo, $item, $proprietario, $serie, $patrimonio, $tipo, $fabricante );

    $retorno = $bemController->alterar( $bem );
    $excluir = $bemHistController->excluir( $codigo );
    if( $retorno ){

        foreach ( $setor as $s => $set ){

            $h = array( $codigo, $set, $localidade[$s], $data[$s], $usuario[$s] );
            $return = $bemHistController->inserir( $h );
        }
    }

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
    require_once '../controller/class.bemHistorico_controller.php';
    $histController = new bemHistorico_controller();
    $bemController = new bens_controller();

    $bem = $bemController->getItem( $codigo );
    $h   = $histController->getListaHistorico( $codigo );

    $dados = array(
        "bens"      => $bem,
        "historico" => $h
    );

    echo json_encode( $dados );
}
function getItemCodigo( $codigo ){
    require_once '../controller/class.bens_controller.php';
    require_once '../controller/class.bemHistorico_controller.php';
    $histController = new bemHistorico_controller();
    $bemController = new bens_controller();

    $bem = $bemController->getItemCodigo( $codigo );



    echo json_encode( $bem );
}

function delete( $codigo ){
    require_once '../controller/class.bens_controller.php';
    $bemController = new bens_controller();

    $bem = $bemController->excluir( $codigo );

    echo json_encode( $bem );
}