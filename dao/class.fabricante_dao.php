<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:41
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class fabricante_dao
{
  public function getListaFabricante( $fabricante ){
      require_once 'class.connection_factory.php';
      $row = array();
      $con = new connection_factory();
      $conn = $con->getConnection();

      $query = "SELECT * FROM DTI_FABRICANTE T WHERE T.NM_FABRICANTE LIKE :fabricante ";
      $vetor = array();
      try{

          $stmt = oci_parse( $conn, $query );
          $fabricante   = "%$fabricante%";
          oci_bind_by_name( $stmt, ':fabricante', $fabricante );
          oci_execute($stmt);
          //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
         while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
          {

              $vetor[] = array(
                  "cd_fabricante"   => $row['CD_FABRICANTE'],
                  "nm_fabricante"   => $row['NM_FABRICANTE'],
              );
          }



      }catch ( PDOException $e ){
          echo "Erro: ".$e->getMessage();
      }

      return $vetor;
  }

    public function getFabricanteList(  ){
        require_once 'class.connection_factory.php';
        $row = array();
        $con = new connection_factory();
        $conn = $con->getConnection();

        $query = "SELECT * FROM DTI_FABRICANTE ORDER BY 2    ";
        $vetor = array();
        try{

            $stmt = oci_parse( $conn, $query );

            oci_execute($stmt);
            //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
            {

                $vetor[] = array(
                    "cd_fabricante"   => $row['CD_FABRICANTE'],
                    "nm_fabricante"   => $row['NM_FABRICANTE'],
                );
            }



        }catch ( PDOException $e ){
            echo "Erro: ".$e->getMessage();
        }

        return $vetor;
    }

  public function cadastro( $fabricante ){
      require_once 'class.connection_factory.php';
      $teste = false;
      $con = new connection_factory();
      $conn = $con->getConnection();
      $query = " INSERT INTO DTI_FABRICANTE 
                 ( CD_FABRICANTE, NM_FABRICANTE ) 
                 VALUES
                 ( NULL, :item )";
      //echo "Item: " . $fabricante[0];
      try{
          $stmt = ociparse( $conn, $query );

          oci_bind_by_name( $stmt, ":item", $fabricante[0] );


          $teste =  ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );

      }catch ( PDOException $exception ){
          echo "Erro: ".$exception->getMessage();
      }
      return $teste;
  }

    public function altera( $fabricante ){
        require_once 'class.connection_factory.php';
        $teste = 0;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $query = " UPDATE DTI_FABRICANTE SET 
                   NM_FABRICANTE       = :item            
                  WHERE CD_FABRICANTE = :codigo";
        try{
            $stmt = ociparse( $conn, $query );
            oci_bind_by_name( $stmt, ":codigo", $fabricante[0] );
            oci_bind_by_name( $stmt, ":item", $fabricante[1] );
            $teste = ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );

        }catch ( PDOException $exception ){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function excluir( $codigo ){
        require_once 'class.connection_factory.php';
        $teste = 0;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $query = " DELETE FROM  DTI_FABRICANTE WHERE CD_FABRICANTE = :codigo";
        try{
            $stmt = ociparse( $conn, $query );
            oci_bind_by_name( $stmt, ":codigo", $codigo );

            $teste = ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );

        }catch ( PDOException $exception ){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;

    }

    public function getProximoCodigo(){
      require_once 'class.connection_factory.php';
      $con = new connection_factory();
      $conn = $con->getConnection();
      $query = "SELECT seq_DTI_FABRICANTE.nextval codigo, LPAD( seq_DTI_FABRICANTE.nextval, 6, 0 ) patrimonio FROM DUAL";
      $row = array();
      try{
          $stmt = ociparse( $conn, $query );
          oci_execute($stmt);
          $row = oci_fetch_array( $stmt, OCI_ASSOC );

      }catch ( PDOException $exception ){
          echo "Erro: ".$exception->getMessage();
      }
      return $row;
    }

    public function getFabricante( $codigo ){
      require_once 'class.connection_factory.php';
      $con = new connection_factory();
      $conn = $con->getConnection();
      $query = "SELECT * FROM DTI_FABRICANTE D WHERE D.CD_FABRICANTE = :codigo";
        $vetor = array();
      try{
          $stmt = ociparse( $conn, $query );
          oci_bind_by_name( $stmt, ":codigo", $codigo );

          $teste = ociexecute( $stmt );
          if ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
              $vetor[] = array(
                  "cd_fabricante"   => $row['CD_FABRICANTE'],
                  "nm_fabricante"   => $row['NM_FABRICANTE'],
              );
          }
      }catch ( PDOException  $exception ){
          echo "Erro: ".$exception->getMessage();
      }

      return $vetor;
    }


}