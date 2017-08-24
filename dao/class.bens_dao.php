<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:41
 */
class bens_dao
{
  public function getListaBens( $setor){
      require_once 'class.connection_factory.php';
      require_once 'beans/class.bens.php';
      require_once 'services/class.bens_list.php';
      $retorno = false;
      $con = new connection_factory();
      $conn = $con->getConnection();

      $query = "SELECT * FROM DBAMV.V_HAM_BENS_PATRIMONIAIS V WHERE V.COD_SETOR = :setor";
      $bensList = new bens_list();
      try{

          $stmt = oci_parse( $conn, $query );
          oci_bind_by_name( $stmt, ":setor", $setor);
          oci_execute($stmt);
          while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
              $marca = isset($row['MARCA']  ) ? $row['MARCA'] : "";
              $bens = new bens();
              $bens->setSequencia( $row['SEQ'] );
              $bens->setCodBem( $row['COD_BEM'] );
              $bens->setPlaqueta( $row['PLAQUETA'] );
              $bens->setNrSerie( $row['NR_SERIE'] );
              $bens->setDescBem( $row['DESC_BEM'] );
              $bens->setChecado( $row['CHECADO'] );
              $bens->setMarca( $marca );

              $bensList->addBens( $bens );

          }


      }catch ( PDOException $e ){
          echo "Erro: ".$e->getMessage();
      }

      return $bensList;
  }
}