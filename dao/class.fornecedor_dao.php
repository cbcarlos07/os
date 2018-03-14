<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:41
 */
class fornecedor_dao
{
  public function getListaFornecedor(  ){
      require_once 'class.connection_factory.php';
      $row = array();
      $con = new connection_factory();
      $conn = $con->getConnection();

      $query = "SELECT * FROM DBAMV.FORNECEDOR";
      $vetor = array();
      try{

          $stmt = oci_parse( $conn, $query );

          oci_execute($stmt);
          //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
         while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
          {

              $vetor[] = array(
                  "cd_fornecedor"   => $row['CD_FORNECEDOR'],
                  "nm_fornecedor"   => $row['NM_FORNECEDOR'],
                  "nm_fantasia"     => $row['NM_FANTASIA']
              );
          }



      }catch ( PDOException $e ){
          echo "Erro: ".$e->getMessage();
      }

      return $vetor;
  }

    public function getFornecedor(  ){
        require_once 'class.connection_factory.php';
        $row = array();
        $con = new connection_factory();
        $conn = $con->getConnection();

        $query = "SELECT O.CD_FORNECEDOR
                        ,F.NM_FANTASIA
                        ,O.DS_SIGLA 
                        ,O.SN_ATIVO
                   FROM OS_FORNECEDOR    O
                       ,DBAMV.FORNECEDOR F
                  WHERE F.CD_FORNECEDOR = O.CD_FORNECEDOR";
        $vetor = array();
        try{

            $stmt = oci_parse( $conn, $query );

            oci_execute($stmt);
            //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
            {

                $vetor[] = array(
                    "cd_fornecedor"   => $row['CD_FORNECEDOR'],
                    "nm_fantasia"     => $row['NM_FANTASIA'],
                    "ds_sigla"        => $row['DS_SIGLA'],
                    "sn_ativo"        => $row['SN_ATIVO']
                );
            }



        }catch ( PDOException $e ){
            echo "Erro: ".$e->getMessage();
        }

        return $vetor;
    }

  public function cadastro( $bem ){
      require_once 'class.connection_factory.php';
      $teste = 0;
      $con = new connection_factory();
      $conn = $con->getConnection();
      $query = " INSERT INTO OS_FORNECEDOR 
                 (CD_FORNECEDOR, DS_SIGLA, SN_ATIVO) 
                 VALUES
                 (:fornecedor, :sigla, :ativo )";
      try{
          $stmt = ociparse( $conn, $query );
          oci_bind_by_name( $stmt, ":fornecedor", $bem[0] );
          oci_bind_by_name( $stmt, ":sigla", $bem[1] );
          oci_bind_by_name( $stmt, ":ativo", $bem[2] );

          $teste =  ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );

      }catch ( PDOException $exception ){
          echo "Erro: ".$exception->getMessage();
      }
      return $teste;
  }

    public function altera( $bem ){
        require_once 'class.connection_factory.php';
        $teste = 0;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $query = " UPDATE OS_FORNECEDOR SET 
                  ,DS_SIGLA      = :sigla
                  ,SN_ATIVO      = :ativo
                  WHERE CD_FORNECEDOR = :fornecedor";
        try{
            $stmt = ociparse( $conn, $query );
            oci_bind_by_name( $stmt, ":fornecedor", $bem[0] );
            oci_bind_by_name( $stmt, ":sigla", $bem[1] );
            oci_bind_by_name( $stmt, ":ativo", $bem[2] );

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
        $query = " DELETE FROM  OS_FORNECEDOR WHERE CD_FORNECEDOR = :fornecedor";
        try{
            $stmt = ociparse( $conn, $query );
            oci_bind_by_name( $stmt, ":fornecedor", $codigo );

            $teste = ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );

        }catch ( PDOException $exception ){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;

    }


    public function getItem( $codigo ){
      require_once 'class.connection_factory.php';
      $con = new connection_factory();
      $conn = $con->getConnection();
      $query = "SELECT * FROM OS_FORNECEDOR D WHERE D.CD_FORNECEDOR = :codigo";
        $vetor = array();
      try{
          $stmt = ociparse( $conn, $query );
          oci_bind_by_name( $stmt, ":codigo", $codigo );

          $teste = ociexecute( $stmt );
          if ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){

                  $vetor[] = array(
                      "cd_fornecedor"   => $row['CD_FORNECEDOR'],
                      "ds_sigla"        => $row['DS_SIGLA'],
                      "sn_ativo"        => $row['SN_ATIVO']
                  );

          }
      }catch ( PDOException  $exception ){
          echo "Erro: ".$exception->getMessage();
      }

      return $vetor;
    }


}