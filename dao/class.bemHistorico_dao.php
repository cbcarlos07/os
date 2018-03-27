<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:41
 */
class bemHistorico_dao
{
  public function getListaHistorico( $bem ){
      require_once 'class.connection_factory.php';
      $row = array();
      $con = new connection_factory();
      $conn = $con->getConnection();

      $query = "SELECT  D.CD_HISTORICO
                       ,D.CD_BEM
                       ,D.CD_SETOR
                       ,S.NM_SETOR  
                       ,D.CD_LOCALIDADE
                       ,L.DS_LOCALIDADE
                       ,TO_CHAR(D.DT_ENTRADA, 'DD/MM/YYYY') ENTRADA
                       ,D.USUARIO
                  FROM dti_bem_historico D
                      ,DBAMV.SETOR       S
                      ,DBAMV.LOCALIDADE  L
                  WHERE D.CD_SETOR = S.CD_SETOR    
                  AND   L.CD_LOCALIDADE = D.CD_LOCALIDADE
                  AND   D.CD_BEM = :bem
  ";
      $vetor = array();
      try{

          $stmt = oci_parse( $conn, $query );
          oci_bind_by_name( $stmt, ':bem', $bem );
          oci_execute($stmt);
          //$vetor = oci_fetch_array( $stmt, OCI_ASSOC );
         while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ))
          {

              $vetor[] = array(
                  "cd_bem"          => $row['CD_BEM'],
                  "cd_setor"        => $row['DS_ITEM'],
                  "nm_setor"        => $row['NM_SETOR'],
                  "cd_localidade"   => $row['CD_LOCALIDADE'],
                  "ds_localidade"   => $row['DS_LOCALIDADE'],
                  "dt_entrada"      => $row['ENTRADA'],
                  "usuario"         => $row['USUARIO']
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
      $query = " INSERT INTO DTI_BEM_HISTORICO 
                 ( CD_BEM, CD_SETOR, CD_LOCALIDADE, DT_ENTRADA, USUARIO ) 
                 VALUES
                 (:codigo, :setor, :localidade, :entrada, :usuario )";
      try{
          $stmt = ociparse( $conn, $query );
          oci_bind_by_name( $stmt, ":codigo", $bem[0] );
          oci_bind_by_name( $stmt, ":setor", $bem[1] );
          oci_bind_by_name( $stmt, ":localidade", $bem[2] );
          oci_bind_by_name( $stmt, ":entrada", $bem[3] );
          oci_bind_by_name( $stmt, ":usuario", $bem[4] );

          $teste =  ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );

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
        $query = " DELETE FROM  DTI_BEM_HISTORICO WHERE CD_BEM = :codigo";
        try{
            $stmt = ociparse( $conn, $query );
            oci_bind_by_name( $stmt, ":codigo", $codigo );

            $teste = ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );

        }catch ( PDOException $exception ){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;

    }

}