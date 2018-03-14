<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:41
 */
class bens_dao
{
  public function getListaBens( $localidade, $setor, $proprietario, $item ){
      require_once 'class.connection_factory.php';
      $row = array();
      $con = new connection_factory();
      $conn = $con->getConnection();

      $query = "SELECT B.CD_BEM
                      ,B.DS_ITEM
                      ,S.NM_SETOR
                    ,L.DS_LOCALIDADE
                    ,B.PROPRIETARIO
                    ,B.NR_PATRIMONIO 
                FROM DTI_BEM_PATRIMONIAL B
                    ,SETOR S
                    ,LOCALIDADE L
                 WHERE S.CD_SETOR = B.CD_SETOR
                  AND  L.CD_LOCALIDADE = B.CD_LOCALIDADE   
                  AND  L.CD_LOCALIDADE LIKE :localidade
                  AND  S.CD_SETOR      LIKE :setor
                  AND  B.PROPRIETARIO  LIKE :proprietario
                  AND  B.CD_BEM        LIKE :item ";
      $vetor = array();
      try{

          $stmt = oci_parse( $conn, $query );
          $localidade   = "%$localidade%";
          $setor        = "%$setor%";
          $proprietario = "%$proprietario%";
          $item         = "%$item%";
          oci_bind_by_name( $stmt, ':localidade', $localidade );
          oci_bind_by_name( $stmt, ':setor', $setor );
          oci_bind_by_name( $stmt, ':proprietario', $proprietario );
          oci_bind_by_name( $stmt, ':item', $item );
          oci_execute($stmt);
          //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
         while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
          {

              $vetor[] = array(
                  "cd_bem"          => $row['CD_BEM'],
                  "ds_item"         => $row['DS_ITEM'],
                  "nm_setor"        => $row['NM_SETOR'],
                  "ds_localiade"    => $row['DS_LOCALIDADE'],
                  "proprietario"    => $row['PROPRIETARIO'],
                  "nr_patrimonio"   => $row['NR_PATRIMONIO']
              );
          }



      }catch ( PDOException $e ){
          echo "Erro: ".$e->getMessage();
      }

      return $vetor;
  }

    public function getBens(  ){
        require_once 'class.connection_factory.php';
        $row = array();
        $con = new connection_factory();
        $conn = $con->getConnection();

        $query = "SELECT B.CD_BEM
                      ,B.DS_ITEM
                      ,S.NM_SETOR
                    ,L.DS_LOCALIDADE
                    ,B.PROPRIETARIO
                    ,B.NR_PATRIMONIO 
                FROM DTI_BEM_PATRIMONIAL B
                    ,SETOR S
                    ,LOCALIDADE L
                 WHERE S.CD_SETOR = B.CD_SETOR
                  AND  L.CD_LOCALIDADE = B.CD_LOCALIDADE   ";
        $vetor = array();
        try{

            $stmt = oci_parse( $conn, $query );

            oci_execute($stmt);
            //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
            {

                $vetor[] = array(
                    "cd_bem"          => $row['CD_BEM'],
                    "ds_item"         => $row['DS_ITEM'],
                    "nm_setor"        => $row['NM_SETOR'],
                    "ds_localiade"    => $row['DS_LOCALIDADE'],
                    "proprietario"    => $row['PROPRIETARIO'],
                    "nr_patrimonio"   => $row['NR_PATRIMONIO']
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
      $query = " INSERT INTO DTI_BEM_PATRIMONIAL 
                 (CD_BEM, DS_ITEM, CD_SETOR, CD_LOCALIDADE, PROPRIETARIO, NR_PATRIMONIO) 
                 VALUES
                 (:codigo, :item, :setor, :localidade, :proprietario, :patrimonio )";
      try{
          $stmt = ociparse( $conn, $query );
          oci_bind_by_name( $stmt, ":codigo", $bem[0] );
          oci_bind_by_name( $stmt, ":item", $bem[1] );
          oci_bind_by_name( $stmt, ":setor", $bem[2] );
          oci_bind_by_name( $stmt, ":localidade", $bem[3] );
          oci_bind_by_name( $stmt, ":proprietario", $bem[4] );
          oci_bind_by_name( $stmt, ":patrimonio", $bem[5] );

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
        $query = " UPDATE DTI_BEM_PATRIMONIAL SET 
                   DS_ITEM       = :item
                  ,CD_SETOR      = :setor
                  ,CD_LOCALIDADE = :localidade
                  ,PROPRIETARIO  = :proprietario
                  ,NR_PATRIMONIO = :patrimonio  
                  WHERE CD_BEM = :codigo";
        try{
            $stmt = ociparse( $conn, $query );
            oci_bind_by_name( $stmt, ":codigo", $bem[0] );
            oci_bind_by_name( $stmt, ":item", $bem[1] );
            oci_bind_by_name( $stmt, ":setor", $bem[2] );
            oci_bind_by_name( $stmt, ":localidade", $bem[3] );
            oci_bind_by_name( $stmt, ":proprietario", $bem[4] );
            oci_bind_by_name( $stmt, ":patrimonio", $bem[5] );

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
        $query = " DELETE FROM  DTI_BEM_PATRIMONIAL WHERE CD_BEM = :codigo";
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
      $query = "SELECT seq_dti_bem_patrimonial.nextval codigo, LPAD( seq_dti_bem_patrimonial.nextval, 6, 0 ) patrimonio FROM DUAL";
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

    public function getItem( $codigo ){
      require_once 'class.connection_factory.php';
      $con = new connection_factory();
      $conn = $con->getConnection();
      $query = "SELECT * FROM dti_bem_patrimonial D WHERE D.CD_BEM = :codigo";
        $vetor = array();
      try{
          $stmt = ociparse( $conn, $query );
          oci_bind_by_name( $stmt, ":codigo", $codigo );

          $teste = ociexecute( $stmt );
          if ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
              $vetor[] = array(
                  "cd_bem"          => $row['CD_BEM'],
                  "ds_item"         => $row['DS_ITEM'],
                  "cd_setor"        => $row['CD_SETOR'],
                  "cd_localidade"    => $row['CD_LOCALIDADE'],
                  "proprietario"    => $row['PROPRIETARIO'],
                  "nr_patrimonio"   => $row['NR_PATRIMONIO']
              );
          }
      }catch ( PDOException  $exception ){
          echo "Erro: ".$exception->getMessage();
      }

      return $vetor;
    }


}