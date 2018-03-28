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

      $con = new connection_factory();
      $conn = $con->getConnection();

      $query = "SELECT D.CD_BEM 
                      ,D.DS_ITEM
                      ,MAX(B.CD_HISTORICO)
                      ,MAX(B.CD_SETOR) KEEP (DENSE_RANK LAST ORDER BY B.CD_HISTORICO)
                      ,MAX(S.NM_SETOR) KEEP (DENSE_RANK LAST ORDER BY B.CD_HISTORICO)      NM_SETOR
                      ,MAX(B.CD_LOCALIDADE) KEEP (DENSE_RANK LAST ORDER BY B.CD_HISTORICO) 
                      ,MAX(L.DS_LOCALIDADE) KEEP (DENSE_RANK LAST ORDER BY B.CD_HISTORICO) DS_LOCALIDADE
                      ,MAX(B.DT_ENTRADA) KEEP (DENSE_RANK LAST ORDER BY B.CD_HISTORICO)
                      ,D.PROPRIETARIO
                      ,F.NM_FANTASIA NM_FORNECEDOR
                    FROM DTI_BEM_PATRIMONIAL D
                      ,DTI_BEM_HISTORICO   B
                      ,DBAMV.SETOR         S
                      ,DBAMV.LOCALIDADE    L
                      ,DBAMV.FORNECEDOR    F
                    WHERE B.CD_BEM         =    D.CD_BEM 
                    AND   S.CD_SETOR       =    B.CD_SETOR
                    AND   L.CD_LOCALIDADE  =    B.CD_LOCALIDADE
                    AND   F.CD_FORNECEDOR  =    D.PROPRIETARIO
                    AND   D.CD_BEM        LIKE  :item
                    AND   D.PROPRIETARIO  LIKE  :proprietario
                    AND   B.CD_SETOR      LIKE  :setor
                    AND   B.CD_LOCALIDADE LIKE  :localidade
                    
                    GROUP BY D.CD_BEM 
                      ,D.DS_ITEM
                      ,D.PROPRIETARIO
                      ,F.NM_FANTASIA";
      $vetor = array();
      try{
          //echo "Item pesq: ".$item;
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
              //echo "Item: ".$row['NM_SETOR'];
              $vetor[] = array(
                  "cd_bem"          => $row['CD_BEM'],
                  "ds_item"         => $row['DS_ITEM'],
                  "nm_setor"        => $row['NM_SETOR'],
                  "ds_localiade"    => $row['DS_LOCALIDADE'],
                  "proprietario"    => $row['NM_FORNECEDOR']
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

        $query = "SELECT * FROM DTI_BEM_PATRIMONIAL ";
        $vetor = array();
        try{

            $stmt = oci_parse( $conn, $query );

            oci_execute($stmt);
            //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
            {

                //echo "DS_ITEM: ".$row['DS_ITEM']."\n";
                $vetor[] = array(
                    "cd_bem"          => $row['CD_BEM'],
                    "ds_item"         => $row['DS_ITEM']
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
                 (CD_BEM, DS_ITEM, PROPRIETARIO, NR_SERIE, NR_PATRIMONIO, CD_TIPO_EQUIPAMENTO, CD_FABRICANTE) 
                 VALUES
                 (:codigo, :item, :proprietario, :serie, :patrimonio, :tipo, :fabricante )";
      try{
          $stmt = ociparse( $conn, $query );
          oci_bind_by_name( $stmt, ":codigo", $bem[0] );
          oci_bind_by_name( $stmt, ":item", $bem[1] );
          oci_bind_by_name( $stmt, ":proprietario", $bem[2] );
          oci_bind_by_name( $stmt, ":serie", $bem[3] );
          oci_bind_by_name( $stmt, ":patrimonio", $bem[4] );
          oci_bind_by_name( $stmt, ":tipo", $bem[5] );
          oci_bind_by_name( $stmt, ":fabricante", $bem[6] );

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
                   DS_ITEM             = :item
                  ,PROPRIETARIO        = :proprietario 
                  ,NR_SERIE            = :serie
                  ,NR_PATRIMONIO       = :patrimonio                  
                  ,CD_TIPO_EQUIPAMENTO = :tipo
                  ,CD_FABRICANTE       = :fabricante  
                  WHERE CD_BEM         = :codigo";
        try{
            $stmt = ociparse( $conn, $query );
            oci_bind_by_name( $stmt, ":codigo", $bem[0] );
            oci_bind_by_name( $stmt, ":item", $bem[1] );
            oci_bind_by_name( $stmt, ":proprietario", $bem[2] );
            oci_bind_by_name( $stmt, ":serie", $bem[3] );
            oci_bind_by_name( $stmt, ":patrimonio", $bem[4] );
            oci_bind_by_name( $stmt, ":tipo", $bem[5] );
            oci_bind_by_name( $stmt, ":fabricante", $bem[6] );

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
                  "cd_bem"               => $row['CD_BEM'],
                  "ds_item"              => $row['DS_ITEM'],
                  "proprietario"         => $row['PROPRIETARIO'],
                  "nr_patrimonio"        => $row['NR_PATRIMONIO'],
                  "nr_serie"             => $row['NR_SERIE'],
                  "cd_tipo_equipamento"  => $row['CD_TIPO_EQUIPAMENTO'],
                  "cd_fabricante"        => $row['CD_FABRICANTE']
              );
          }
      }catch ( PDOException  $exception ){
          echo "Erro: ".$exception->getMessage();
      }

      return $vetor;
    }


}