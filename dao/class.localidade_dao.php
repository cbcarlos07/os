<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:41
 */
class localidade_dao
{
  public function getListaLocalidade( $setor ){
      require_once 'class.connection_factory.php';
      $retorno = false;
      $con = new connection_factory();
      $conn = $con->getConnection();

      $query = "SELECT L.CD_LOCALIDADE
                      ,L.DS_LOCALIDADE
                      ,L.CD_SETOR
                      ,L.NM_RESPONSAVEL
                      ,REGEXP_REPLACE( L.NM_RESPONSAVEL,'[^A-Z ]','' ) RESPONSAVEL
                FROM  LOCALIDADE L WHERE  L.CD_SETOR LIKE :setor";
      //$localidadeList = new localidade_list();
      $localidadeList = array();
      try{

          $stmt = oci_parse( $conn, $query );
          $setor = "%".$setor."%";
          oci_bind_by_name( $stmt, ":setor",$setor );
          oci_execute($stmt);

          while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){

              $localidadeList[] =  array(
                  "cd_localidade"   => $row['CD_LOCALIDADE'],
                  "ds_localidade"   => $row['DS_LOCALIDADE'],
                  "nm_responsavel"  => $row['RESPONSAVEL']
              );

          }


      }catch ( PDOException $e ){
          echo "Erro: ".$e->getMessage();
      }

      return $localidadeList;
  }


}