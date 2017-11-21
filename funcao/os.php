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
    $anexo      = "";
    $file       = "";
    $plaqueta   = "";
    $bem        = "";
    $localidade = "";

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

    if( isset( $_POST['anexo'] ) )
        $anexo = $_POST['anexo'];

    if( isset( $_POST['file'] ) )
        $file = $_POST['file'];

    if( isset( $_POST['plaqueta'] ) )
        $plaqueta = $_POST['plaqueta'];

    if( isset( $_POST['bem'] ) )
        $bem = $_POST['bem'];

    if( isset( $_POST['localidade'] ) )
        $localidade = $_POST['localidade'];



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
            insert_chamado( $pedido, $previsao, $solicitante, $setor, $descricao, $observacao, $responsavel, $status, $resolucao, $oficina, $tipoos, $motivo, $usuario, $ramal, $bem, $localidade );
            break;
        case 'J':
            getListServicoInf( $cdos );
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
        case 'P':
            getTotalAReceber(  );
            break;
        case 'Q':
            getListaMeusChamadosData( $cdos, $oficina, $solicitante, $responsavel, $setor, $inicio, $fim );
            break;
        case 'S':
            getUltimaSolicitacao( $usuario );
            break;
        case 'U':
            update_solicitacao( $cdos, $solicitante, $setor, $descricao, $observacao, $ramal );
            break;
        case 'V':
             inserirAnexo( $cdos, $anexo );
             break;
        case 'X':
            getSetorByPlaqueta( $plaqueta );
            break;
        case 'Z':
            getFileList( $cdos );
            break;
        case '0':
            getDataFile( $cdos );
            break;
}

    function getTotalAReceber(  ){
        require_once "../controller/class.os_controller.php";
        $osController = new os_controller();

        $totalReceber = $osController->get_total_chamados_aguardando1();


        echo json_encode( array( "aguardando" => $totalReceber ) );
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
            if( $ordem->getResponsavel()->getCdUsuario() != "" ){
                $situacao = "Em atendimento";
            }



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
                "status"   => $ordem->getSituacao()

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
             $chamado['ramal']      = $ordem->getDsRamal();
             $chamado['status']     = returnStatusAcento($ordem->getSituacao());
             $chamado['situacao']   = $ordem->getSituacao();
             $chamado['servicos']   = getListServico( $codOs );
             $chamado['informacoes']= getListServicoInf( $codOs );
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
            case 'D':
                $retorno = "Cancelada";
                break;
            case 'E':
                $retorno = "Conserto Externo";
                break;
            case 'N':
                $retorno = "Não Atendida";
                break;
            case 'M':
                $retorno = "Aguardando Material";
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
                    "descricao"   => $item->getDescricao(),
                    "data"      => $item->getHoraInicial(),

                );
            }

        }

       return $servicos;

    }

    function getListServicoInf( $cdOs ){
        require_once "../controller/class.itemSolicitacaoServico_Controller.php";
        require_once "../beans/class.itemSolicitacaoServico.php";
        require_once "../services/class.itemSolicitacaoServico_list_iterator.php";

        $item_controller = new itemSolicitacaoServico_Controller();

        $lista = $item_controller->getListItensInfAdd( $cdOs );

        $itemLista = new itemSolicitacaoServico_list_iterator( $lista );

        $servicos = array();
        while ( $itemLista->hasNextItemSolicitacaoServico() ){
            $item = $itemLista->getNextItemSolicitacaoServico();
            $hide = "#HIDE#";
            $texto = $item->getDescricao();
            $post = strripos( $texto, $hide );
            if( $post == false ){
                $servicos[] = array(
                    "codigo"    => $item->getCdItem(),
                    "usuario"   => $item->getFuncionario()->getNmFuncionario(),
                    "servico"   => $item->getManuServ()->getStrNmServico(),
                    "descricao" => $item->getDescricao(),
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


function insert_chamado ( $pedido, $previsao, $solicitante, $setor, $descricao, $observacao, $responsavel, $status, $resolucao, $oficina, $tipoos, $motivo, $usuario, $ramal, $bem, $localidade ){
    require_once "../controller/class.os_controller.php";
    require_once "../beans/class.os.php";
    require_once "../beans/class.usuario.php";
    require_once "../beans/class.setor.php";
    require_once "../beans/class.oficina.php";
    require_once "../beans/class.manuEspec.php";
    require_once "../beans/class.tipo_os.php";
    require_once "../beans/class.motServ.php";
    require_once "../beans/class.bens.php";

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
    //echo "CdTipo os: $tipoos";
    $ordem->getTipoOs()->setCdTipoOs( $tipoos );
    $ordem->setMotServ( new motServ() );
    $ordem->getMotServ()->setCdMotServ( $motivo );
    $ordem->setUsuario( new usuario() );
    $ordem->getUsuario()->setCdUsuario( $usuario );
    $ordem->setPrioridade( 'E' );
    $ordem->setDsRamal( $ramal );
    $ordem->setBem( new bens() );
    $ordem->getBem()->setCodBem( $bem );
    $ordem->setLocalidade( $localidade );



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

        /*echo "Solicitante: $solicitante \n";
        echo "Usuario: $usuario \n";*/

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
                "solicitante" => $ordem->getSolicitante()->getCdUsuario(),
                "criacao"     => $ordem->getObservacao()

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

        function getListaMeusChamadosData( $codigo, $oficina, $solicitante, $responsavel, $setor, $inicio, $fim ){
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
            $dados['inicio']      = $inicio;
            $dados['fim']         = $fim;

            //echo "2. Solicitante: ".$dados['solicitante']."<br>";

            $teste = $osController->getListaMeusChamadosData( $dados );
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
                    "espera"      => $os->getPrevisao(),
                    "situacao"    => $os->getSituacao()
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

            $teste = $osController->getTotalMeusServico( $responsavel );


            echo json_encode( array( "meuservicos" => $teste ) );

        }

        function getTotalMeusChamados( $responsavel ){
            require_once "../controller/class.os_controller.php";
            $osController = new os_controller();


            //echo "2. Solicitante: ".$dados['solicitante']."<br>";

            $teste = $osController->getTotalMeusChamado( $responsavel );


            echo json_encode( array( "meuschamados" => $teste ) );

        }

         function inserirAnexo( $cdOs, $dsAnexo){
             require_once "../controller/class.os_controller.php";
             $osController = new os_controller();


             //echo "2. Solicitante: ".$dados['solicitante']."<br>";

             $arr = json_decode( $dsAnexo );
             $teste = false;
           //  $i = 0;
            // var_dump( $arr );
             $insert = array();
             foreach ( $arr as $item => $iten ){

                 $values[0] = $cdOs;
                 $values[1] = $iten->name;
                 $values[2] = $iten->file->content ;


                $imagem = base64_to_jpeg( $iten->file->content,  'saida.'.getB64Type( $iten->file->content ));

                // $tamanhoImg = filesize($imagem);
                 //$mysqlImg = addslashes(fread(fopen($imagem, "r"), $tamanhoImg));



                 $file = file_get_contents( $imagem );
                 /*
                  * Enviando dados pra array para fazer inserção no banco de uma unica vez
                  */
                 $insert[] = array(
                     "os"       => $cdOs,
                     "name"     => $iten->name,
                     "arquivo"  => $file
                 );


                  unlink($imagem);
                // echo "Imagem: ".$iten->name." \n";
             }

           //  var_dump( $insert );
             $teste = $osController->inserirAnexo( $insert );


             if( $teste ){
                 echo json_encode( array( "anexo" => $teste ) );
             }else{
                 echo json_encode( array( "anexo" => 0 ) );
             }

         }


            function base64_to_jpeg($base64_string, $output_file) {
                // open the output file for writing
                $ifp = fopen( $output_file, 'wb' );

                // split the string on commas
                // $data[ 0 ] == "data:image/png;base64"
                // $data[ 1 ] == <actual base64 string>
                $data = explode( ',', $base64_string );

                // we could add validation here with ensuring count( $data ) > 1
                fwrite( $ifp, base64_decode( $data[ 1 ] ) );

                // clean up the file resource
                fclose( $ifp );

                return $output_file;
            }

            function getB64Type($str) {
                return substr($str, 11, strpos($str, ';') - 11);
            }

            function getSetorByPlaqueta( $plaqueta ){
                 require_once '../controller/class.os_controller.php';
                 require_once '../beans/class.bens.php';

                 $osc = new os_controller();
                // echo "Plaqueta";
                 $bem = $osc->getByPlaqueta( $plaqueta );

                 $bens = array(
                     "codigo"     => $bem->getCodBem(),
                     "setor"      => $bem->getSetor()->getCdSetor(),
                     "descricao"  => $bem->getDescBem(),
                     "localidade" => $bem->getLocalidade()
                 );


                 echo json_encode( $bens );

            }

            function getFileList( $cdOs ){
               // echo "Cod da os file: $cdOs \n";
                require_once '../controller/class.os_controller.php';

                $osc = new os_controller();

                $anexos = $osc->getAnexo( $cdOs );
             //   var_dump( $anexos );
                echo json_encode( $anexos );

            }

            function getDataFile( $id ){
                require_once '../controller/class.os_controller.php';

                $osc = new os_controller();

                $osc->getDataFile( $id );


            }





