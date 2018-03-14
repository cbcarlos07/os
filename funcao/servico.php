<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 18/07/2017
 * Time: 15:45
 */

$acao = $_POST['acao'];

$horaFinal   = "";
$horaInicial = "";
$tempoHora   = "";
$funcionario = 0;
$manuServ    = 0;
$cdOs        = 0;
$descricao   = "";
$tempoMinuto = 0;
$feito       = "";
$codigo      = 0;

if( isset( $_POST['horaFinal'] ) )
    $horaFinal = $_POST['horaFinal'];

if( isset( $_POST['horaInicio'] ) )
    $horaInicial = $_POST['horaInicio'];

if( isset( $_POST['tempoHora'] ) )
    $tempoHora = $_POST['tempoHora'];

if( isset( $_POST['cdOs'] ) )
    $cdOs = $_POST['cdOs'];

if( isset( $_POST['funcionario'] ) )
    $funcionario = $_POST['funcionario'];

if( isset( $_POST['servico'] ) )
    $manuServ = $_POST['servico'];

if( isset( $_POST['descricao'] ) )
    $descricao = $_POST['descricao'];

if( isset( $_POST['tempoMinuto'] ) )
    $tempoMinuto = $_POST['tempoMinuto'];

if( isset( $_POST['feito'] ) )
    $feito = $_POST['feito'];

if( isset( $_POST['codigo'] ) )
    $codigo = $_POST['codigo'];

switch ($acao){
    case 'M':
        getListManuServ();
        break;
    case 'S':
        salvarItemServico( $horaFinal, $horaInicial, $tempoHora,  $cdOs, $funcionario, $manuServ, $descricao, $tempoMinuto, $feito );
        break;
    case 'U':
        updateItemOs( $codigo, $horaFinal, $horaInicial, $tempoHora,  $cdOs, $funcionario, $manuServ, $descricao, $tempoMinuto, $feito  );
        break;
    case 'E':
        excluirItemOs( $codigo );
        break;
    case 'L':
        getListServicos( $cdOs );
        break;
    case 'I':
        getItemOs( $codigo );
        break;
}


  function getListManuServ(  ){
      require_once "../controller/class.itemSolicitacaoServico_Controller.php";
      require_once "../beans/class.manuServ.php";
      require_once "../services/class.manuServ_list_iterator.php";

      $itemController = new itemSolicitacaoServico_Controller();
      $lista = $itemController->getListServico("");
      $servicoList = new manuServ_list_iterator( $lista );

      $servicos = array();
      while ( $servicoList->hasNextManuServ() ){
          $servico = $servicoList->getNextManuServ();
          $servicos[] = array(
              "codigo"  => $servico->getCdServico(  ),
              "servico" => $servico->getStrNmServico(  )
          );
      }
      echo json_encode(array("servicos" => $servicos));
  }

  function salvarItemServico( $horaFinal, $horaInicial, $tempoHora, $cdOs, $funcionario, $manuServ, $descricao, $tempoMinuto, $feito ){
      require_once "../controller/class.itemSolicitacaoServico_Controller.php";
      require_once "../beans/class.itemSolicitacaoServico.php";
      require_once "../beans/class.funcionario.php";
      require_once "../beans/class.manuServ.php";

      $itemController = new itemSolicitacaoServico_Controller();
      $item = new itemSolicitacaoServico();
      $item->setHoraFinal( $horaFinal );
      $item->setHoraInicial( $horaInicial );
      $item->setTempoHora( $tempoHora );
      $item->setCdOs( $cdOs );
      $item->setFuncionario( new funcionario() );
      $item->getFuncionario()->setCdFuncionario( $funcionario );
      $item->setManuServ( new manuServ() );
      $item->getManuServ()->setCdServico( $manuServ );
      $item->setDescricao( nl2br( $descricao ) );
      $item->setTempoMinuto( $tempoMinuto );
      $item->setSnFeito( $feito );

      $teste = $itemController->salvarItemOs( $item );

      if($teste > 0){
          echo json_encode( array("retorno" => $teste) );
      }
      else{
          echo json_encode( array("retorno" => 0) );
      }
  }

  function updateItemOs ( $codigo, $horaFinal, $horaInicial, $tempoHora, $cdOs, $funcionario, $manuServ, $descricao, $tempoMinuto, $feito ){
      require_once "../controller/class.itemSolicitacaoServico_Controller.php";
      require_once "../beans/class.itemSolicitacaoServico.php";
      require_once "../beans/class.funcionario.php";
      require_once "../beans/class.manuServ.php";

      $itemController = new itemSolicitacaoServico_Controller();
      $item = new itemSolicitacaoServico();

      $item->setHoraFinal( $horaFinal );
      $item->setHoraInicial( $horaInicial );
      $item->setTempoHora( $tempoHora );
      $item->setCdOs( $cdOs );
      $item->setFuncionario( new funcionario() );
      $item->getFuncionario()->setCdFuncionario( $funcionario );
      $item->setManuServ( new manuServ() );
      $item->getManuServ()->setCdServico( $manuServ );
      $item->setDescricao( nl2br( $descricao ));
      $item->setTempoMinuto( $tempoMinuto );
      $item->setSnFeito( $feito );
      $item->setCdItem( $codigo );

      $teste = $itemController->updateItemOs( $item );

      if($teste){
          echo json_encode( array( "retorno" => $codigo ) );
      }else{
          echo json_encode( array( "retorno" => 0 ) );
      }
  }

  function excluirItemOs ( $codigo ){
      require_once "../controller/class.itemSolicitacaoServico_Controller.php";

      $itemController = new itemSolicitacaoServico_Controller();
      $teste = $itemController->excluir( $codigo );

      if($teste){
          echo json_encode( array( "retorno" => 1 ) );
      }else{
          echo json_encode( array( "retorno" => 0 ) );
      }
  }

  function getListServicos( $cdOs ){
      require_once "../controller/class.itemSolicitacaoServico_Controller.php";
      require_once "../services/class.itemSolicitacaoServico_list_iterator.php";
      require_once "../beans/class.itemSolicitacaoServico.php";
      $itemController = new itemSolicitacaoServico_Controller();
      $lista = $itemController->getListItens( $cdOs );
      $itensList = new itemSolicitacaoServico_list_iterator( $lista );
      $itens = array();
      while ( $itensList->hasNextItemSolicitacaoServico() ){
          $item = $itensList->getNextItemSolicitacaoServico();

          if( $item->getTempoHora() < 10 ){
              $hora = "0". $item->getTempoHora();
          }else{
              $hora = $item->getTempoHora();
          }

          if( $item->getTempoMinuto() < 10 ){
              $minuto = "0" .$item->getTempoMinuto();
          }else{
              $minuto = $item->getTempoMinuto();
          }

          if( $item->getHoraFinal() == "" )
            $tempo = "";
          else
              $tempo = $hora.":".$minuto;


          $itens[] = array(
               "codigo"      => $item->getCdItem(),
               "servico"     => $item->getManuServ()->getStrNmServico(),
               "funcionario" => $item->getFuncionario()->getNmFuncionario(),
               "descricao"   => $item->getDescricao(),
               "inicio"      => $item->getHoraInicial(),
               "final"       => $item->getHoraFinal(),
               "tempo"       => $tempo
          );
      }
      echo json_encode( array("itens" => $itens) );

  }

  function getItemOs( $codigo ){
      require_once "../controller/class.itemSolicitacaoServico_Controller.php";
      require_once "../beans/class.itemSolicitacaoServico.php";
      require_once "../services/class.itemSolicitacaoServico_list_iterator.php";

      $itemController = new itemSolicitacaoServico_Controller();
      $item = $itemController->getItem( $codigo );

      if( $item->getTempoHora() < 10 ){
          $hora = "0". $item->getTempoHora();
      }else{
          $hora = $item->getTempoHora();
      }

      if( $item->getTempoMinuto() < 10 ){
          $minuto = "0" .$item->getTempoMinuto();
      }else{
          $minuto = $item->getTempoMinuto();
      }

      if( $item->getDataFinal() == "" )
          $tempo = "";
      else
          $tempo = $hora.":".$minuto;


      $retorno['funcionario'] = $item->getFuncionario()->getCdFuncionario();
      $retorno['servico']     = $item->getManuServ()->getCdServico();
      $retorno['descricao']   = $item->getDescricao();
      $retorno['feito']       = $item->getSnFeito();
      $retorno['inicio']      = $item->getDataInicial();
      $retorno['final']       = $item->getDataFinal();
      $retorno['tempo']       = $tempo;
      $retorno['tempoHora']   = $item->getTempoHora();
      $retorno['tempoMinuto'] = $item->getTempoMinuto();

      echo json_encode($retorno);
  }
