<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 12/07/2017
 * Time: 11:30
 */

    $acao       = $_POST['acao'];
    $usuario    = "";
    $cdos       = 0;
    $solicitante = "";
    $setor      = 0;
    $descricao  = "";
    $observacao = "";
    $oficina    = 0;
    $pedido     = "";
    $previsao   = "";
    $responsavel = "";
    $status     = "";
    $resolucao  = "";
    $tipoos     = "";
    $motivo     = 0;
    $inicio     = 0;
    $fim        = 0;
    $ramal      = "";
    if( isset($_POST['usuario']) )
        $usuario = $_POST['usuario'];

    if( isset($_POST['ramal']) )
        $ramal = $_POST['ramal'];

    if( isset($_POST['cdos']) )
        $cdos = $_POST['cdos'];

    if( isset($_POST['solicitante']) )
        $solicitante = $_POST['solicitante'];

    if( isset($_POST['setor']) )
        $setor = $_POST['setor'];

    if( isset($_POST['descricao']) )
        $descricao = $_POST['descricao'];

    if( isset($_POST['observacao']) )
        $observacao = $_POST['observacao'];

    if( isset($_POST['oficina']) )
        $oficina = $_POST['oficina'];

    if( isset($_POST['pedido']) )
        $pedido = $_POST['pedido'];

    if( isset($_POST['previsao']) )
        $previsao = $_POST['previsao'];

    if( isset($_POST['responsavel']) )
        $responsavel = $_POST['responsavel'];

    if( isset($_POST['status']) )
        $status = $_POST['status'];

    if( isset($_POST['resolucao']) )
        $resolucao = $_POST['resolucao'];

    if( isset($_POST['tipoos']) )
        $tipoos = $_POST['tipoos'];

    if( isset($_POST['motivo']) )
        $motivo = $_POST['motivo'];

    if( isset( $_POST['inicio'] ) )
        $inicio = $_POST['inicio'];

    if( isset( $_POST['fim'] ) )
        $fim = $_POST['fim'];




switch ( $acao ){
        case 'A':
              chamados_abertos();
              break;
        case 'B':
              update_situacao( $status, $cdos );
              break;
        case 'C':
            update_chamado( $cdos, $pedido, $previsao, $solicitante, $setor, $descricao, $observacao, $responsavel, $status, $resolucao, $oficina, $tipoos, $motivo, $ramal );
            break;
        case 'D':
            getDadosUltimoSolicitante( $solicitante );
            break;
        case 'E':
            getListSolicitacao( $inicio, $fim );
            break;
        case 'F':
            getListaMeusServicos( $cdos, $oficina, $solicitante, $responsavel, $setor );
            break;
        case 'G':
            getTotalMeusServicos( $responsavel );
            break;
        case 'H':
            getTotalMeusChamados( $responsavel );
            break;
        case 'I':
            insert_chamado( $pedido, $previsao, $solicitante, $setor, $descricao, $observacao, $responsavel, $status, $resolucao, $oficina, $tipoos, $motivo, $usuario, $ramal );
            break;
        case 'L':
            listar_ultimas_os( $usuario, $inicio, $fim );
            break;
        case 'M':
            getListaMeusChamados( $cdos, $oficina, $solicitante, $responsavel, $setor );
            break;
        case 'N':
            nova_solicitacao( $descricao, $observacao, $solicitante, $setor, $usuario, $ramal );
            break;
        case 'O':
            getOs( $cdos );
            break;
        case 'S':
            getUltimaSolicitacao( $usuario );
            break;
        case 'U':
            update_solicitacao( $cdos, $solicitante, $setor, $descricao, $observacao, $ramal );
            break;











}


    function listar_ultimas_os( $usuario, $inicio, $fim ){
        require_once "../controller/class.os_controller.php";
        require_once "../beans/class.os.php";
        require_once "../services/class.os_list_iterator.php";

        $osController = new os_controller();
      //  echo "Usuario: ".$usuario;
        $listaOs = $osController->get_os_solicitadas("", $usuario, $inicio, $fim);

        $osList = new os_list_iterator( $listaOs );

        $tbody = array();
        while ( $osList->hasNextOs() ){
            $ordem = $osList->getNextOs();
            $situacao = "Aguardando";
            if( $ordem->getResponsavel()->getCdUsuario() != "" )
               $situacao = "Em atendimento";


            if( $ordem->getSituacao() == 'C' ){
                $situacao = "Conclu&iacute;da";
            }

             //  $situation = returnStatus($ordem->getSituacao()); //

            $tbody[] = array(
                "cdos"       => $ordem->getCdOs(),
                "setor"      => $ordem->getSetor()->getNmSetor(),
                "descricao"  => $ordem->getDescricao(),
                "pedido"     => $ordem->getDataPedido(),
                "situacao"   => $situacao,
                "observacao" => $ordem->getObservacao(),

            );


        }

         echo json_encode(array("chamados" => $tbody));

     }

     function getListSolicitacao($inicio, $fim){
         require_once "../controller/class.os_controller.php";
         require_once "../beans/class.os.php";
         require_once "../services/class.os_list_iterator.php";

         $osController = new os_controller();
         $listaOs = $osController->getListSolicitacao( $inicio, $fim );
         $osList = new os_list_iterator( $listaOs );

         $obj = array();
         while ( $osList->hasNextOs() ){
             $ordem = $osList->getNextOs();
             $obj[] = array(
                 "cdos"         => $ordem->getCdOs(),
                 "pedido"       => $ordem->getDataPedido(),
                 "situacao"     => returnStatusAcento($ordem->getSituacao()),
                 "responsavel"  => $ordem->getResponsavel()->getCdUsuario()
             );
         }
         echo json_encode( $obj );


     }

     function returnStatus( $status ){
        $retorno = "";

        switch ( $status ){
            case 'A':
                $retorno = "Aberta";
                break;
            case 'C':
                $retorno = "Conclu&iacute;da";
                break;
            case 'N':
                $retorno = "N&atild;o Atendida";
                break;
            case 'M':
                $retorno = "Aguardando Material";
                break;
            case 'E':
                $retorno = "Conserto Externo";
                break;
            case 'S':
                $retorno = "Solicita&ccedil;&atilde;o";
                break;
            case 'L':
                $retorno = "Aguardando Libera&ccedil;&atilde;o do Setor";
                break;
            case 'F':
                $retorno = "Agendar";
                break;
            case 'D':
                $retorno = "Cancelada";
                break;
        }
        return $retorno;


     }

     function getOs( $codOs ){
         require_once "../controller/class.os_controller.php";
         require_once "../beans/class.os.php";

         $osController = new os_controller();
         $teste = $osController->verificaSeTemSolicitacao( $codOs );


         if( $teste ){

             $ordem = $osController->getSolicitacao( $codOs );
             $chamado['erro']         = 0;
             $chamado['pedido']       = $ordem->getDataPedido();
             $chamado['previsao']     = $ordem->getPrevisao();
             $chamado['solicitante']  = $ordem->getSolicitante()->getCdUsuario();
             $chamado['setor']        = $ordem->getSetor()->getCdSetor();
             $chamado['tipoos']       = $ordem->getTipoOs()->getCdTipoOs();
             $chamado['motivo']       = $ordem->getMotServ()->getCdMotServ();
             $chamado['oficina']      = $ordem->getOficina()->getCdOficina();
             $chamado['descricao']  = $ordem->getDescricao();
             $chamado['observacao'] = $ordem->getObservacao();
             $chamado['atendente']  = $ordem->getResponsavel()->getCdUsuario();
             $chamado['ramal']    = $ordem->getDsRamal();
             $chamado['status']     = returnStatusAcento($ordem->getSituacao());
             $chamado['situacao']   = $ordem->getSituacao();
             $chamado['servicos']   = getListServico( $codOs );
             $chamado['resolucao']  = $ordem->getResolucao();
             $chamado['especialidade']  = $ordem->getEspecialidade()->getCdEspec();

         }else{
             $chamado['erro']      = 1;
         }





          echo json_encode($chamado);


     }

    function returnStatusAcento( $status ){
        $retorno = "";

        switch ( $status ){
            case 'A':
                $retorno = "Aberta";
                break;
            case 'C':
                $retorno = "Concluída";
                break;
            case 'N':
                $retorno = "Não Atendida";
                break;
            case 'M':
                $retorno = "Aguardando Material";
                break;
            case 'E':
                $retorno = "Conserto Externo";
                break;
            case 'S':
                $retorno = "Solicitação";
                break;
            case 'L':
                $retorno = "Aguardando Liberação do Setor";
                break;
            case 'F':
                $retorno = "Agendar";
                break;
            case 'D':
                $retorno = "Cancelada";
                break;
        }
        return $retorno;
    }

    function getListServico( $cdOs ){
        require_once "../controller/class.itemSolicitacaoServico_Controller.php";
        require_once "../beans/class.itemSolicitacaoServico.php";
        require_once "../services/class.itemSolicitacaoServico_list_iterator.php";

        $item_controller = new itemSolicitacaoServico_Controller();

        $lista = $item_controller->getListItens( $cdOs );

        $itemLista = new itemSolicitacaoServico_list_iterator( $lista );

        $servicos = array();
        while ( $itemLista->hasNextItemSolicitacaoServico() ){
            $item = $itemLista->getNextItemSolicitacaoServico();
            $hide = "#HIDE#";
            $texto = $item->getDescricao();
            $post = strripos( $texto, $hide );
            if( $post == false ){
                $servicos[] = array(
                    "usuario"   => $item->getFuncionario()->getNmFuncionario(),
                    "servico"   => $item->getManuServ()->getStrNmServico(),
                    "data"      => $item->getHoraInicial(),

                );
            }

        }

       return $servicos;

    }

function update_chamado ( $codigo, $pedido, $previsao, $solicitante, $setor, $descricao, $observacao, $responsavel, $status, $resolucao, $oficina, $tipoos, $motivo, $ramal ){
    require_once "../controller/class.os_controller.php";
    require_once "../beans/class.os.php";
    require_once "../beans/class.usuario.php";
    require_once "../beans/class.setor.php";
    require_once "../beans/class.oficina.php";
    require_once "../beans/class.manuEspec.php";
    require_once "../beans/class.tipo_os.php";
    require_once "../beans/class.motServ.php";

    $osController = new os_controller();
    $ordem = new os();
    $ordem->setCdOs( $codigo );
    $ordem->setDataPedido( $pedido );
    $ordem->setPrevisao( $previsao );
    $ordem->setSolicitante( new usuario() );
    $ordem->getSolicitante()->setCdUsuario( $solicitante );
    $ordem->setSetor( new setor() );
    $ordem->getSetor()->setCdSetor( $setor );
    $ordem->setDescricao( $descricao );
    $ordem->setObservacao( $observacao );
    $ordem->setResponsavel( new usuario() );
    $ordem->getResponsavel()->setCdUsuario( $responsavel );
    $ordem->setSituacao( $status );
    $ordem->setResolucao( $resolucao );
    $ordem->setOficina( new oficina() );
    $ordem->getOficina()->setCdOficina( $oficina );
    $ordem->setEspecialidade( new manuEspec() );
    $ordem->getEspecialidade()->setCdEspec( 31 );
    $ordem->setTipoOs( new tipo_os() );
    $ordem->getTipoOs()->setCdTipoOs( $tipoos );
    $ordem->setMotServ( new motServ() );
    $ordem->getMotServ()->setCdMotServ( $motivo );
    $ordem->setPrioridade( 'E' );
    $ordem->setDsRamal( $ramal );



    $teste = $osController->update_chamado( $ordem );

    $retorno = array();
    if( $teste ){
        $retorno['sucesso'] = 1;
        $retorno['chamado'] = $codigo;
    }
    else {
        $retorno['sucesso'] = 0;
    }

    echo json_encode( $retorno );

}


function insert_chamado ( $pedido, $previsao, $solicitante, $setor, $descricao, $observacao, $responsavel, $status, $resolucao, $oficina, $tipoos, $motivo, $usuario, $ramal ){
    require_once "../controller/class.os_controller.php";
    require_once "../beans/class.os.php";
    require_once "../beans/class.usuario.php";
    require_once "../beans/class.setor.php";
    require_once "../beans/class.oficina.php";
    require_once "../beans/class.manuEspec.php";
    require_once "../beans/class.tipo_os.php";
    require_once "../beans/class.motServ.php";

    $osController = new os_controller();
    $ordem = new os();
    $ordem->setDataPedido( $pedido );
    $ordem->setPrevisao( $previsao );
    $ordem->setSolicitante( new usuario() );
    $ordem->getSolicitante()->setCdUsuario( $solicitante );
    $ordem->setSetor( new setor() );
    $ordem->getSetor()->setCdSetor( $setor );
    $ordem->setDescricao( $descricao );
    $ordem->setObservacao( $observacao );
    $ordem->setResponsavel( new usuario() );
    $ordem->getResponsavel()->setCdUsuario( $responsavel );
    $ordem->setSituacao( $status );
    $ordem->setResolucao( $resolucao );
    $ordem->setOficina( new oficina() );
    $ordem->getOficina()->setCdOficina( $oficina );
    $ordem->setEspecialidade( new manuEspec() );
    $ordem->getEspecialidade()->setCdEspec( 31 );
    $ordem->setTipoOs( new tipo_os() );
    $ordem->getTipoOs()->setCdTipoOs( $tipoos );
    $ordem->setMotServ( new motServ() );
    $ordem->getMotServ()->setCdMotServ( $motivo );
    $ordem->setUsuario( new usuario() );
    $ordem->getUsuario()->setCdUsuario( $usuario );
    $ordem->setPrioridade( 'E' );
    $ordem->setDsRamal( $ramal );



    $teste = $osController->insert_chamado( $ordem );

    $retorno = array();
    if( $teste > 0 ){
        $retorno['sucesso'] = 1;
        $retorno['chamado']  = $teste;
    }
    else {
        $retorno['sucesso'] = 0;
    }

    echo json_encode( $retorno );

}



    function update_solicitacao ( $codigo, $solicitante, $setor, $descricao, $observacao, $ramal ){
        require_once "../controller/class.os_controller.php";
        require_once "../beans/class.os.php";
        require_once "../beans/class.usuario.php";
        require_once "../beans/class.setor.php";

        $osController = new os_controller();
        $ordem = new os();
        $ordem->setCdOs( $codigo );
        $ordem->setSolicitante( new usuario() );
        $ordem->getSolicitante()->setCdUsuario( $solicitante );
        $ordem->setSetor( new setor() );
        $ordem->getSetor()->setCdSetor( $setor );
        $ordem->setDescricao( $descricao );
        $ordem->setObservacao( $observacao );
        $ordem->setDsRamal( $ramal );

        $teste = $osController->update_solicitacao( $ordem );

        $retorno = array();
        if( $teste ){
            $retorno['sucesso'] = 1;
        }
        else {
            $retorno['sucesso'] = 0;
        }

        echo json_encode( $retorno );

    }


    function nova_solicitacao( $descricao, $observacao, $solicitante, $setor, $usuario, $ramal ){
        require_once "../controller/class.os_controller.php";
        require_once "../beans/class.os.php";
        require_once "../beans/class.usuario.php";
        require_once "../beans/class.setor.php";
        $osController = new os_controller();
        $ordem = new os();
        $ordem->setSolicitante( new usuario() );
        $ordem->getSolicitante()->setCdUsuario( $solicitante );
        $ordem->setSetor( new setor() );
        $ordem->getSetor()->setCdSetor( $setor );
        $ordem->setDescricao( $descricao );
        $ordem->setObservacao( $observacao );
        $ordem->setUsuario( new usuario() );
        $ordem->getUsuario()->setCdUsuario( $usuario );
        $ordem->setPrioridade( 'E' );
        $ordem->setDsRamal( $ramal );

        $teste = $osController->insert_nova_solicitacao( $ordem );

        $retorno = array();
        if( $teste > 0 ){
            $retorno['sucesso'] = 1;
            $retorno['chamado'] = $teste;
        }
        else {
            $retorno['sucesso'] = 0;
        }

        echo json_encode( $retorno );
    }





    function chamados_abertos(  ){
        require_once "../controller/class.os_controller.php";
        require_once "../services/class.os_list_iterator.php";
        require_once "../beans/class.os.php";
        require_once "../beans/class.usuario.php";
        require_once "../beans/class.setor.php";
        $osController = new os_controller();
        $ordem = new os();

        $listaOrdem = $osController->get_list_chamados_aguardando();
        $osList = new os_list_iterator( $listaOrdem );

        $ordens = array();
        while ( $osList->hasNextOs() ){
            $ordem = $osList->getNextOs();
            $ordens[] = array(
                "codigo"      => $ordem->getCdOs(),
                "data"        => $ordem->getDataPedido(),
                "descricao"   => $ordem->getDescricao(),
                "setor"       => $ordem->getSetor()->getNmSetor(),
                "solicitante" => $ordem->getSolicitante()->getCdUsuario()

            );
        }

        echo json_encode(array("chamados" => $ordens));

    }

    function getUltimaSolicitacao( $usuario ){
        require_once "../controller/class.os_controller.php";
        require_once "../beans/class.os.php";
        $osController = new os_controller();
        $os = $osController->getUltimaSolicitacao( $usuario );

        $ordem['tipoos']  = $os->getTipoOs()->getCdTipoOs();
        $ordem['motivo']  = $os->getMotServ()->getCdMotServ();
        $ordem['oficina'] = $os->getOficina()->getCdOficina();
        $ordem['responsavel'] = $os->getResponsavel()->getCdUsuario();

        echo json_encode( $ordem );
    }

    function getDadosUltimoSolicitante( $solicitante ){
        require_once "../controller/class.os_controller.php";
        require_once "../beans/class.setor.php";

        $osController = new os_controller();
        $teste = $osController->verificaUltimoSolicitante( $solicitante );

        if( $teste ){
            $setor = $osController->getDadosUltimoSolicitante( $solicitante );
            $obj['cdsetor'] = $setor->getCdSetor();

        }else{
            $obj['cdsetor'] = 0;
        }
        echo json_encode( $obj );
    }

    function update_situacao( $situacao, $cdos ){
        require_once "../controller/class.os_controller.php";
        $osController = new os_controller();
        $teste = $osController->update_situacao( $situacao, $cdos );

        if( $teste == 1){
            echo json_encode(array("retorno" => 1));
        }else{
            echo json_encode(array("retorno" => 0));
        }

    }

	    function getListaMeusChamados( $codigo, $oficina, $solicitante, $responsavel, $setor ){
			require_once "../controller/class.os_controller.php";
			require_once "../services/class.os_list_iterator.php";
			require_once "../beans/class.os.php";
			$osController = new os_controller();

		//	echo "1. Solicitante: ".$solicitante."<br>";
			$dados['solicitante'] = $solicitante;
			$dados['setor']       = $setor;
			$dados['oficina']     = $oficina;
			$dados['codigo']      = $codigo;
			$dados['responsavel'] = $responsavel;
			
			//echo "2. Solicitante: ".$dados['solicitante']."<br>";

			$teste = $osController->getListaMeusChamados( $dados );
			$os_list = new os_list_iterator( $teste );
			$osArray = array();
			while ( $os_list->hasNextOs() ){
				$os = $os_list->getNextOs();
				$osArray[] = array(
                    "codigo"      => $os->getCdOs(),
                    "prioridade"  => $os->getPrioridade(),
                    "setor"       => $os->getSetor()->getNmSetor(),
                    "servico"     => $os->getDescricao(),
                    "responsavel" => $os->getResponsavel()->getCdUsuario(),
                    "solicitacao" => $os->getDataPedido(),
                    "espera"      => $os->getPrevisao()
				);
			}

			echo json_encode( $osArray );

    }

        function getListaMeusServicos( $codigo, $oficina, $solicitante, $responsavel, $setor ){
            require_once "../controller/class.os_controller.php";
            require_once "../services/class.itemSolicitacaoServico_list_iterator.php";
            require_once "../beans/class.os.php";
            $osController = new os_controller();

            //	echo "1. Solicitante: ".$solicitante."<br>";
            $dados['solicitante'] = $solicitante;
            $dados['setor']       = $setor;
            $dados['oficina']     = $oficina;
            $dados['codigo']      = $codigo;
            $dados['responsavel'] = $responsavel;

            //echo "2. Solicitante: ".$dados['solicitante']."<br>";

            $teste = $osController->getListaMeusServicos( $dados );
            $os_list = new itemSolicitacaoServico_list_iterator( $teste );
            $osArray = array();
            while ( $os_list->hasNextItemSolicitacaoServico() ){
                $os = $os_list->getNextItemSolicitacaoServico();
                $osArray[] = array(
                    "codigo"      => $os->getCdOs(),
                    "chamado"   => $os->getChamado(),
                    "responsavel" => $os->getResponsavel(),
                    "servico"     => $os->getManuServ()->getStrNmServico(),
                    "descricao" => $os->getDescricao(),
                    "inicio" => $os->getDataInicial(),
                    "status"      => $os->getTempo()
                );
            }

            echo json_encode( $osArray );

        }

        function getTotalMeusServicos( $responsavel ){
            require_once "../controller/class.itemSolicitacaoServico_Controller.php";
            $osController = new itemSolicitacaoServico_Controller();


            //echo "2. Solicitante: ".$dados['solicitante']."<br>";

            $teste = $osController->getTotalMeusServicos( $responsavel );


            echo json_encode( array( "total" => $teste ) );

        }

        function getTotalMeusChamados( $responsavel ){
            require_once "../controller/class.os_controller.php";
            $osController = new os_controller();


            //echo "2. Solicitante: ".$dados['solicitante']."<br>";

            $teste = $osController->getTotalMeusChamados( $responsavel );


            echo json_encode( array( "total" => $teste ) );

        }



