<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 09/03/2018
 * Time: 09:37
 */

$acao = $_POST['acao'];

$setor = 0;

if( isset( $_POST['setor'] ) ){
    $setor = $_POST['setor'];
}

switch ( $acao ){
    case 'A':
        getListaLocalidade( $setor );
        break;
}

function getListaLocalidade( $setor ){
    require_once '../controller/class.localidade_controller.php';
    $lc = new localidade_controller();
    //echo "Setor: ".$setor;
    $retorno = $lc->getListaLocalidade( $setor );

    echo  json_encode( $retorno );
}