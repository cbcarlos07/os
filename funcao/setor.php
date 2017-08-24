<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 07/07/2017
 * Time: 11:49
 */

$cdsetor = 0;
$acao = $_POST['acao'];

if( isset($_POST['cdsetor']) ){
    $cdsetor = $_POST['cdsetor'];
}

switch ( $acao ){

    case "S":
        getListSetor(  );
        break;
}

function getListSetor(  ){

    require_once "../controller/class.setor_controller.php";
    require_once "../beans/class.setor.php";
    require_once "../services/class.setor_list_iterator.php";

    $setor = new setor();

    $setorController = new setor_controller();

    $lista = $setorController->getListaSetor1();

    $setorList = new setor_list_iterator( $lista );

    $retorno = array();

    while ( $setorList->hasNextSetor() ){
        $setor = $setorList->getNextSetor();

        $retorno[] = array(
          "codsetor"  =>   $setor->getCdSetor(),
          "nmsetor"   =>   $setor->getNmSetor()
        );

    }

    echo json_encode(array("setor" => $retorno));

}