<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 25/07/2017
 * Time: 10:57
 */
class template_dao
{


    public function get_list_template( ){
        require_once 'class.connection_factory.php';
        require_once '../services/class.template_list.php';
        $con = new connection_factory();
        $conn = $con->getConnection();

        $template_list = new template_list();

        $query = "  SELECT * FROM DBAADV.HAM_OS_TEMPLATE";
        try{
            $stmt = oci_parse($conn, $query);
        /*    oci_bind_by_name($stmt, ":solicitante", $usuario, -1);
            oci_bind_by_name($stmt, ":inicio", $inicio, -1);
            oci_bind_by_name($stmt, ":fim", $fim, -1);*/
            oci_execute($stmt);
            while ( $row = oci_fetch_array($stmt, OCI_ASSOC) ){
                $template =  new template();
                $observacao = "";
                if( isset( $row['DS_OBSERVACAO'] ) ){
                    $observacao = $row['DS_OBSERVACAO'];
                }


                $template->setCdTemplate( $row['CD_TEMPLATE'] );
                $template->setDsTitulo( $row['DS_TITULO'] );
                $template->setDsObservacao( $observacao );;

                $template_list->addTemplate( $template );


            }

        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $template_list;

    }

    public function get_template($codigo){
        require_once 'class.connection_factory.php';
        require_once '../beans/class.template.php';
        $con = new connection_factory();
        $conn = $con->getConnection();

        $template = new template();

        $query = "  SELECT * 
                      FROM VIEW_OS_TEMPLATE V
                     WHERE V.CD_TEMPLATE = :codigo";
        try{
            $stmt = oci_parse($conn, $query);
            oci_bind_by_name($stmt, ":codigo", $codigo, -1);
            oci_execute($stmt);
            if ( $row = oci_fetch_array($stmt, OCI_ASSOC) ){
                $template =  new template();
                $observacao = "";
                if( isset( $row['DS_OBSERVACAO'] ) ){
                    $observacao = $row['DS_OBSERVACAO'];
                }


                $template->setCdTemplate( $row['CD_TEMPLATE'] );
                $template->setDsTitulo( $row['DS_TITULO'] );
                $template->setDsServico( $row['DS_SERVICO'] );
                $template->setDsObservacao( $observacao );;



            }

        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $template;

    }

    public function insert_template( template $template ){
        require_once 'class.connection_factory.php';
        $con = new connection_factory();
        $conn = $con->getConnection();
        $retorno = false;
        $query = "INSERT INTO HAM_OS_TEMPLATE 
                  ( CD_TEMPLATE, NM_SOLICITANTE, CD_SETOR, DS_SERVICO, DS_OBSERVACAO, NM_USUARIO, DS_TITULO )
                  VALUES
                  ( SEQ_TEMPLATE.NEXTVAL, :solicitante, :setor, :servico, :observacao, :usuario, :titulo )";
        try{
            $stmt = oci_parse($conn, $query);
            $usuario = $template->getNmUsuario();
            $setor   = $template->getCdSetor();
            $observacao = $template->getDsObservacao();
            $servico = $template->getDsServico();
            $titulo  = $template->getDsTitulo();

            oci_bind_by_name($stmt, ":solicitante", $usuario);
            oci_bind_by_name($stmt, ":setor", $setor);
            oci_bind_by_name($stmt, ":servico", $servico);
            oci_bind_by_name($stmt, ":observacao", $observacao);
            oci_bind_by_name($stmt, ":usuario", $usuario);
            oci_bind_by_name($stmt, ":titulo", $titulo);
            oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
            $retorno = true;


        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $retorno;

    }

    public function update_template( template $template ){
        require_once 'class.connection_factory.php';
        $con = new connection_factory();
        $conn = $con->getConnection();
        $retorno = false;
        $query = "UPDATE HAM_OS_TEMPLATE SET 
                  NM_SOLICITANTE = :solicitante
                 ,CD_SETOR = :setor
                 ,DS_SERVICO = :servico
                 ,DS_OBSERVACAO = :observacao
                 ,NM_USUARIO = :usuario
                 ,DS_TITULO = :titulo 
                  WHERE CD_TEMPLATE = :codigo";
        try{
            $stmt = oci_parse($conn, $query);
            $usuario = $template->getNmUsuario();
            $setor   = $template->getCdSetor();
            $observacao = $template->getDsObservacao();
            $servico = $template->getDsServico();
            $titulo  = $template->getDsTitulo();
            $codigo  = $template->getCdTemplate();

            oci_bind_by_name($stmt, ":solicitante", $usuario);
            oci_bind_by_name($stmt, ":setor", $setor);
            oci_bind_by_name($stmt, ":servico", $servico);
            oci_bind_by_name($stmt, ":observacao", $observacao);
            oci_bind_by_name($stmt, ":usuario", $usuario);
            oci_bind_by_name($stmt, ":titulo", $titulo);
            oci_bind_by_name($stmt, ":codigo", $codigo);
            oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
            $retorno = true;


        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $retorno;

    }

    public function delete_template( $template ){
        require_once 'class.connection_factory.php';
        $con = new connection_factory();
        $conn = $con->getConnection();
        $retorno = false;
        $query = "DELETE FROM HAM_OS_TEMPLATE 
                  WHERE CD_TEMPLATE = :codigo";
        try{
            $stmt = oci_parse($conn, $query);
            oci_bind_by_name($stmt, ":codigo", $template);
            oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
            $retorno = true;


        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $retorno;

    }


}