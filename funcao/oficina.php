<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 20/07/2017
 * Time: 10:55
 */
$_acao = $_POST['acao'];
$usuario = "";

if( isset( $_POST['usuario'] ) ){
    $usuario = $_POST['usuario'];
}

switch ($_acao){
    case 'O':
        getListOficina( $usuario );
        break;
    case 'L':
        getListOficinas(  );
        break;
}


   function getListOficina( $usuario ){
       require_once "../beans/class.oficina.php";
       require_once "../services/class.oficina_list_iterator.php";
       require_once "../controller/class.os_controller.php";

       $osController = new os_controller();
       $lista = $osController->getListOficina( $usuario );
       $oficinaList = new oficina_list_iterator( $lista );
       $oficinas = array();
       while ( $oficinaList->hasNextOficina() ){
           $oficina = $oficinaList->getNextOficina();
           $oficinas[] = array(
               "codigo"  => $oficina->getCdOficina(),
               "oficina" => $oficina->getDsOficina()
           );
       }

       echo json_encode( array("oficinas" => $oficinas) );


   }

function getListOficinas(  ){
    require_once "../beans/class.oficina.php";
    require_once "../services/class.oficina_list_iterator.php";
    require_once "../controller/class.os_controller.php";

    $osController = new os_controller();
    $lista = $osController->getListOficinas(  );
    $oficinaList = new oficina_list_iterator( $lista );
    $oficinas = array();
    while ( $oficinaList->hasNextOficina() ){
        $oficina = $oficinaList->getNextOficina();
        $oficinas[] = array(
            "codigo"  => $oficina->getCdOficina(),
            "oficina" => $oficina->getDsOficina()
        );
    }

    echo json_encode( array("oficinas" => $oficinas) );


}