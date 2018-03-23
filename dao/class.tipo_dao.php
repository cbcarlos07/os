<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:41
 */
class Tipo_dao
{
  public function getListaTipo( $tipo ){
      require_once 'class.connection_factory.php';
      $row = array();
      $con = new connection_factory();
      $conn = $con->getConnection();

      $query = "SELECT * FROM DTI_TIPO_EQUIPAMENTO T WHERE T.DS_TIPO_EQUIPAMENTO LIKE :tipo ";
      $vetor = array();
      try{

          $stmt = oci_parse( $conn, $query );
          $tipo   = "%$tipo%";
          oci_bind_by_name( $stmt, ':tipo', $tipo );
          oci_execute($stmt);
          //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
         while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
          {

              $vetor[] = array(
                  "cd_tipo_equipamento"   => $row['CD_TIPO_EQUIPAMENTO'],
                  "ds_tipo_equipamento"   => $row['DS_TIPO_EQUIPAMENTO'],
              );
          }



      }catch ( PDOException $e ){
          echo "Erro: ".$e->getMessage();
      }

      return $vetor;
  }

    public function getTipoList(  ){
        require_once 'class.connection_factory.php';
        $row = array();
        $con = new connection_factory();
        $conn = $con->getConnection();

        $query = "SELECT * FROM DTI_TIPO_EQUIPAMENTO ORDER BY 2    ";
        $vetor = array();
        try{

            $stmt = oci_parse( $conn, $query );

            oci_execute($stmt);
            //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
            {

                $vetor[] = array(
                    "cd_tipo_equipamento"   => $row['CD_TIPO_EQUIPAMENTO'],
                    "ds_tipo_equipamento"   => $row['DS_TIPO_EQUIPAMENTO'],
                );
            }



        }catch ( PDOException $e ){
            echo "Erro: ".$e->getMessage();
        }

        return $vetor;
    }

  public function cadastro( $tipo ){
      require_once 'class.connection_factory.php';
      $teste = 0;
      $con = new connection_factory();
      $conn = $con->getConnection();
      $query = " INSERT INTO DTI_TIPO_EQUIPAMENTO 
                 ( CD_TIPO_EQUIPAMENTO, DS_TIPO_EQUIPAMENTO ) 
                 VALUES
                 ( NULL, :item )";
      try{
          $stmt = ociparse( $conn, $query );

          oci_bind_by_name( $stmt, ":item", $tipo[0] );


          $teste =  ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );

      }catch ( PDOException $exception ){
          echo "Erro: ".$exception->getMessage();
      }
      return $teste;
  }

    public function altera( $tipo ){
        require_once 'class.connection_factory.php';
        $teste = 0;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $query = " UPDATE DTI_TIPO_EQUIPAMENTO SET 
                   DS_TIPO_EQUIPAMENTO       = :item            
                  WHERE CD_TIPO_EQUIPAMENTO = :codigo";
        try{
            $stmt = ociparse( $conn, $query );
            oci_bind_by_name( $stmt, ":codigo", $tipo[0] );
            oci_bind_by_name( $stmt, ":item", $tipo[1] );
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
        $query = " DELETE FROM  DTI_TIPO_EQUIPAMENTO WHERE CD_TIPO_EQUIPAMENTO = :codigo";
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
      $query = "SELECT seq_DTI_TIPO_EQUIPAMENTO.nextval codigo, LPAD( seq_DTI_TIPO_EQUIPAMENTO.nextval, 6, 0 ) patrimonio FROM DUAL";
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

    public function getTipo( $codigo ){
      require_once 'class.connection_factory.php';
      $con = new connection_factory();
      $conn = $con->getConnection();
      $query = "SELECT * FROM DTI_TIPO_EQUIPAMENTO D WHERE D.CD_TIPO_EQUIPAMENTO = :codigo";
        $vetor = array();
      try{
          $stmt = ociparse( $conn, $query );
          oci_bind_by_name( $stmt, ":codigo", $codigo );

          $teste = ociexecute( $stmt );
          if ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
              $vetor[] = array(
                  "cd_tipo_equipamento"   => $row['CD_TIPO_EQUIPAMENTO'],
                  "ds_tipo_equipamento"   => $row['DS_TIPO_EQUIPAMENTO'],
              );
          }
      }catch ( PDOException  $exception ){
          echo "Erro: ".$exception->getMessage();
      }

      return $vetor;
    }


}