<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 18/07/2017
 * Time: 11:05
 */
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$acao = $_POST['acao'];

$_tipoOs = 0;

if( isset( $_POST['tipoos'] ) )
     $_tipoOs = $_POST['tipoos'];

switch ($acao){
    case 'M':
        getListMotServ( $_tipoOs );
        break;
    case 'T':
        getListTipoOs();
        break;
}


  function getListMotServ( $tpOs ){
      require_once "../controller/class.os_controller.php";
      require_once "../beans/class.motServ.php";
      require_once "../services/class.motServ_list_iterator.php";

      $os_controller = new os_controller();
      $lista = $os_controller->getListMotServ( $tpOs );
      $motivoList = new motServ_list_iterator( $lista );
      $motivos = array();
      while ( $motivoList->hasNextMotServ() ){
          $motivo = $motivoList->getNextMotServ();
          $motivos[] = array(
              "codigo"    => $motivo->getCdMotServ(),
              "descricao" => $motivo->getDsMotServ()
          );
      }

      echo json_encode(array("motivos" => $motivos));

  }

    function getListTipoOs(  ){
        require_once "../controller/class.os_controller.php";
        require_once "../beans/class.tipo_os.php";
        require_once "../services/class.tipo_os_list_iterator.php";

        $os_controller = new os_controller();
        $lista = $os_controller->getListIpoOs(  );

        echo json_encode( $lista );

    }