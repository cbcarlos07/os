<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:41
 */
class setor_dao
{
  public function getListaSetor( ){
      require_once 'class.connection_factory.php';
      require_once 'beans/class.setor.php';
      require_once 'services/class.setor_list.php';
      $retorno = false;
      $con = new connection_factory();
      $conn = $con->getConnection();

      $query = "SELECT * FROM DBAMV.SETOR S ORDER BY S.NM_SETOR";
      $setorList = new setor_list();
      try{

          $stmt = oci_parse( $conn, $query );
          oci_execute($stmt);
          while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){

              $marca = isset($row['MARCA']  ) ? $row['MARCA'] : "";
              $setor = new setor();
              $setor->setCdSetor( $row['CD_SETOR'] );
              $setor->setNmSetor( $row['NM_SETOR'] );
              $setorList->addSetor( $setor );

          }

          $con->closeConnection($conn);

      }catch ( PDOException $e ){
          echo "Erro: ".$e->getMessage();
      }

      return $setorList;
  }

    public function getListaSetor1( ){
        require_once 'class.connection_factory.php';
        require_once '../beans/class.setor.php';
        require_once '../services/class.setor_list.php';
        $retorno = false;
        $con = new connection_factory();
        $conn = $con->getConnection();

        $query = "SELECT * FROM DBAMV.SETOR S ORDER BY S.NM_SETOR";
        $setorList = new setor_list();
        try{

            $stmt = oci_parse( $conn, $query );
            oci_execute($stmt);
            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){

                $marca = isset($row['MARCA']  ) ? $row['MARCA'] : "";
                $setor = new setor();
                $setor->setCdSetor( $row['CD_SETOR'] );
                $setor->setNmSetor( $row['NM_SETOR'] );
                $setorList->addSetor( $setor );

            }

            $con->closeConnection($conn);

        }catch ( PDOException $e ){
            echo "Erro: ".$e->getMessage();
        }

        return $setorList;
    }

  public function getPrimeiroSetor(){
      require_once 'class.connection_factory.php';
      $codigo = 0;
      $con = new connection_factory();
      $conn = $con->getConnection();
      $query = "SELECT S.CD_SETOR CODIGO FROM DBAMV.SETOR S";
      try{
         $stmt = oci_parse($conn, $query);
         oci_execute($stmt);
         if ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
             $codigo = $row['CODIGO'];
         }

          $con->closeConnection($conn);
      }catch (PDOException $e){
          echo "Erro: ".$e->getMessage();
      }
      return $codigo;
  }



}