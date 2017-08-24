<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 25/07/2017
 * Time: 11:21
 */

        $acao     = $_POST['acao'];
        $usuario  = "";
        $inicio   = 0;
        $fim      = 0;
        $codigo   = 0;
        $setor    = 0;
        $servico  = "";
        $observacao = "";
        $titulo    = "";

        if( isset( $_POST[ 'usuario' ] ) ){
            $usuario = $_POST[ 'usuario' ];
        }

        if( isset( $_POST[ 'inicio' ] ) ){
            $inicio = $_POST[ 'inicio' ];
        }

        if( isset( $_POST[ 'fim' ] ) ){
            $fim = $_POST[ 'fim' ];
        }

        if( isset( $_POST[ 'codigo' ] ) ){
            $codigo = $_POST[ 'codigo' ];
        }

        if( isset( $_POST[ 'setor' ] ) ){
            $setor = $_POST[ 'setor' ];
        }

        if( isset( $_POST[ 'servico' ] ) ){
            $servico = $_POST[ 'servico' ];
        }

        if( isset( $_POST[ 'observacao' ] ) ){
            $observacao = $_POST[ 'observacao' ];
        }

        if( isset( $_POST[ 'titulo' ] ) ){
            $titulo = $_POST[ 'titulo' ];
        }

        switch ( $acao ){

            case 'L':
                getListTemplate( $usuario, $inicio, $fim );
                break;
            case 'T':
                getTemplate( $codigo );
                break;
            case 'I':
                insert_template( $usuario, $setor, $servico, $observacao, $titulo );
                break;
            case 'U':
                update_template( $codigo, $usuario, $setor, $servico, $observacao, $titulo );
                break;
            case 'E':
                delete_template( $codigo );
                break;

        }

        function getListTemplate( $usuario, $inicio, $fim ){
            require_once "../controller/class.template_controller.php";
            require_once "../beans/class.template.php";
            require_once "../services/class.template_list_iterator.php";

            $templateController = new template_controller();
            $lista = $templateController->get_list_template( $usuario, $inicio, $fim );
            $tempList = new template_list_iterator( $lista );
            $templates =  array();
            while ( $tempList->hasNextTemplate() ){
                $template = $tempList->getNextTemplate();
                $templates[] = array(
                    "codigo"     => $template->getCdTemplate(),
                    "setor"      => $template->getCdTemplate(),
                    "descricao"  => $template->getDsServico(),
                    "observacao" => $template->getDsObservacao(),
                    "titulo"     => $template->getDsTitulo()
                );
            }
            echo json_encode( array( "templates" => $templates ) );
        }

        function getTemplate( $codigo ){
            require_once "../controller/class.template_controller.php";

            $templateController = new template_controller();
            $template = $templateController->get_template( $codigo );
            $templates = array(
                    "codigo"      => $template->getCdTemplate(),
                    "titulo"      => $template->getDsTitulo(),
                    "setor"      => $template->getCdSetor(),
                    "descricao"  => $template->getDsServico(),
                    "observacao" => $template->getDsObservacao()
                );

            echo json_encode( $templates );
        }

        function insert_template( $usuario, $setor, $servico, $observacao, $titulo ){
            require_once "../controller/class.template_controller.php";
            require_once "../beans/class.template.php";

            $templateController = new template_controller();
            $template = new template();
            $template->setDsTitulo( $titulo );
            $template->setCdSetor( $setor );
            $template->setDsServico( $servico );
            $template->setDsObservacao( $observacao );
            $template->setNmUsuario( $usuario );

            $retorno = $templateController->insert_template( $template );
            if( $retorno ){
                echo json_encode( array( "retorno" =>  1) );
            }else{
                echo json_encode( array( "retorno" =>  0) );
            }


        }

        function update_template( $codigo, $usuario, $setor, $servico, $observacao, $titulo ){
            require_once "../controller/class.template_controller.php";
            require_once "../beans/class.template.php";

            $templateController = new template_controller();
            $template = new template();
            $template->setDsTitulo( $titulo );
            $template->setCdSetor( $setor );
            $template->setDsServico( $servico );
            $template->setDsObservacao( $observacao );
            $template->setNmUsuario( $usuario );
            $template->setCdTemplate( $codigo );

            $retorno = $templateController->update_template( $template );
            if( $retorno ){
                echo json_encode( array( "retorno" =>  1) );
            }else{
                echo json_encode( array( "retorno" =>  0) );
            }
        }

        function delete_template( $codigo ){
            require_once "../controller/class.template_controller.php";
            require_once "../beans/class.template.php";

            $templateController = new template_controller();

            $retorno = $templateController->delete_template( $codigo );
            if( $retorno ){
                echo json_encode( array( "retorno" =>  1) );
            }else{
                echo json_encode( array( "retorno" =>  0) );
            }
        }
