<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 09/03/2018
 * Time: 09:35
 */

class localidade_controller
{
   public function getListaLocalidade( $setor ){
       require_once '../dao/class.localidade_dao.php';
       $ld = new localidade_dao();
       $retorno = $ld->getListaLocalidade( $setor );
       return $retorno;
   }
}