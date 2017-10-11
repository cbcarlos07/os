<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 12/07/2017
 * Time: 16:01
 */
class itemSolicitacaoServico_dao
{

    public function getListServico( $texto ){
        require_once "class.connection_factory.php";
        require_once "../services/class.manuServ_list.php";
        require_once "../beans/class.manuServ.php";
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql = "SELECT * FROM DBAMV.VIEW_HAM_LISTA_SERVICO V WHERE V.NM_SERVICO LIKE :nome OR CD_SERVICO = :codigo ";
        $itens = new manuServ_list();
        if( trim( $texto ) == "" ){

            $sql = "SELECT * FROM DBAMV.VIEW_HAM_LISTA_SERVICO V ";

        }

        try{
            $stmt = ociparse( $conn, $sql );
            if( trim( $texto ) != "" ){

                $nome = "%$texto%";
                $codigo = 0;
                if( is_numeric( $texto ) )
                    $codigo = $texto;

                ocibindbyname( $stmt, ":nome", $nome );
                ocibindbyname( $stmt, ":codigo", $codigo );

            }

            ociexecute( $stmt );

            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC) ){
                $item = new manuServ();
                $item->setCdServico( $row['CD_SERVICO'] );
                $item->setStrNmServico( $row['NM_SERVICO'] );
                $itens->addManuServ( $item );
            }

        }catch ( PDOException $e ){
            echo "Erro: ".$e->getMessage();
        }
        return $itens;
    }

    public function getListUsuarioEspecie ( $especialidade ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.funcionario.php";
        require_once "../services/class.funcionario_list.php";

        $con = new connection_factory();
        $conn = $con->getConnection();

        $sql = "SELECT * FROM DBAMV.VIEW_HAM_LISTA_FUNC_ESPECIE E WHERE E.CD_ESPEC = :especialidade";
        $funcionarioList = new funcionario_list();
        try{
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":especialidade", $especialidade );
            ociexecute( $stmt );

            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){

                $funcionario = new funcionario();
                $funcionario->setCdFuncionario( $row['CD_FUNC'] );
                $funcionario->setNmFuncionario( $row['NM_FUNC'] );

                $funcionarioList->addFuncionario( $funcionario );

            }
            $con->closeConnection( $conn );
        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }

        return $funcionarioList;
    }

    public function getListItens( $cdOs ){
         require_once "class.connection_factory.php";
         require_once "../beans/class.itemSolicitacaoServico.php";
         require_once "../beans/class.manuServ.php";
         require_once "../beans/class.funcionario.php";
         require_once "../services/class.itemSolicitacaoServico_list.php";
         $con = new connection_factory();
         $conn = $con->getConnection();
         $sql = "SELECT * FROM DBAMV.VIEW_HAM_LISTA_ITOS V WHERE V.CD_OS = :os";

         $lista = new itemSolicitacaoServico_list();
         try{
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":os", $cdOs );
            ociexecute( $stmt );
            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $fim = "";
                if( isset( $row['FIM'] ) ){
                    $fim = $row['FIM'];
                }

                $hora = "";
                if( isset( $row['HORA'] ) ){
                    $hora = $row['HORA'];
                }
                $minuto = "";

                if( isset( $row['MINUTO'] ) ){
                    $minuto = $row['MINUTO'];
                }

                $servico = "";
                if( isset( $row['DS_SERVICO'] ) )
                    $servico = $row['DS_SERVICO'];

                $item = new itemSolicitacaoServico();
                $item->setCdItem( $row['CD_ITSOLICITACAO_OS'] );
                $item->setManuServ( new manuServ() );
                $item->getManuServ()->setCdServico( $row['CD_SERVICO'] );
                $item->getManuServ()->setStrNmServico( $row['NM_SERVICO'] );
                $item->setFuncionario( new funcionario() );
                $item->getFuncionario()->setCdFuncionario( $row['CD_FUNC'] );
                $item->getFuncionario()->setNmFuncionario( $row['NM_FUNC'] );
                $item->setSnFeito( $row['FEITO'] );
                $item->setHoraInicial( $row['INICIO'] );
                $item->setHoraFinal( $fim );
                $item->setTempo( $row['TEMPO'] );
                $item->setTempoHora( $hora );
                $item->setTempoMinuto( $minuto );
                $item->setDescricao( $servico );
                $lista->addItemSolicitacaoServico( $item );

            }
            $con->closeConnection( $conn );
         }catch (PDOException $e){
             echo "Erro: ".$e->getMessage();
         }

        return $lista;
    }


    public function getListItensInfAdd( $cdOs ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.itemSolicitacaoServico.php";
        require_once "../beans/class.manuServ.php";
        require_once "../beans/class.funcionario.php";
        require_once "../services/class.itemSolicitacaoServico_list.php";
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql = "SELECT * FROM DBAMV.VIEW_HAM_LISTA_ITOS_INF V WHERE V.CD_OS = :os";

        $lista = new itemSolicitacaoServico_list();
        try{
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":os", $cdOs );
            ociexecute( $stmt );
            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $fim = "";
                if( isset( $row['FIM'] ) ){
                    $fim = $row['FIM'];
                }

                $hora = "";
                if( isset( $row['HORA'] ) ){
                    $hora = $row['HORA'];
                }
                $minuto = "";

                if( isset( $row['MINUTO'] ) ){
                    $minuto = $row['MINUTO'];
                }

                $servico = "";
                if( isset( $row['DS_SERVICO'] ) )
                    $servico = $row['DS_SERVICO'];

                $item = new itemSolicitacaoServico();
                $item->setCdItem( $row['CD_ITSOLICITACAO_OS'] );
                $item->setManuServ( new manuServ() );
                $item->getManuServ()->setCdServico( $row['CD_SERVICO'] );
                $item->getManuServ()->setStrNmServico( $row['NM_SERVICO'] );
                $item->setFuncionario( new funcionario() );
                $item->getFuncionario()->setCdFuncionario( $row['CD_FUNC'] );
                $item->getFuncionario()->setNmFuncionario( $row['NM_FUNC'] );
                $item->setSnFeito( $row['FEITO'] );
                $item->setHoraInicial( $row['INICIO'] );
                $item->setHoraFinal( $fim );
                $item->setTempo( $row['TEMPO'] );
                $item->setTempoHora( $hora );
                $item->setTempoMinuto( $minuto );
                $item->setDescricao( $servico );
                $lista->addItemSolicitacaoServico( $item );

            }
            $con->closeConnection( $conn );
        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }

        return $lista;
    }


    public function salvarItemOs( itemSolicitacaoServico $item ){
        require_once "class.connection_factory.php";
        $teste = 0;
        $codigo = $this->getItOs();
        $con = new connection_factory();
        $conn = $con->getConnection();

        if( $item->getHoraFinal() == "" ){
            echo "";
            $sql =  "INSERT INTO DBAMV.ITSOLICITACAO_OS 
                 (CD_ITSOLICITACAO_OS, HR_INICIO, VL_TEMPO_GASTO, CD_OS,
                 CD_FUNC, CD_SERVICO, DS_SERVICO, VL_TEMPO_GASTO_MIN, SN_CHECK_LIST,
                 VL_HORA, VL_HORA_EXTRA )
                 VALUES
                 (:codigo, TO_DATE(:hinicio, 'DD/MM/YYYY HH24:MI:SS'), :tempo, :cdos,  
                 :funcionario, :servico, :descricao, :minuto, :feito,
                 0,0 ) ";
                $stmt = ociparse( $conn, $sql );
                $hinicio  = $item->getHoraInicial();
                $tempo    = $item->getTempoHora();
                $cdOs     = $item->getCdOs();
                $func     = $item->getFuncionario()->getCdFuncionario();
                $servico  = $item->getManuServ()->getCdServico();
                $descricao = $item->getDescricao();
                $minuto   = $item->getTempoMinuto();
                $feito    = $item->getSnFeito();
                ocibindbyname( $stmt, ":codigo", $codigo );
                ocibindbyname( $stmt, ":hinicio", $hinicio );
                ocibindbyname( $stmt, ":tempo", $tempo );
                ocibindbyname( $stmt, ":cdos", $cdOs );
                ocibindbyname( $stmt, ":funcionario", $func );
                ocibindbyname( $stmt, ":servico", $servico );
                ocibindbyname( $stmt, ":descricao", $descricao );
                ocibindbyname( $stmt, ":minuto", $minuto );
                ocibindbyname( $stmt, ":feito", $feito );
        }else{
            $sql =  "INSERT INTO DBAMV.ITSOLICITACAO_OS 
                 (CD_ITSOLICITACAO_OS,HR_FINAL, HR_INICIO,  VL_TEMPO_GASTO, CD_OS,
                 CD_FUNC, CD_SERVICO, DS_SERVICO, VL_TEMPO_GASTO_MIN, SN_CHECK_LIST,
                 VL_HORA, VL_HORA_EXTRA )
                 VALUES
                 (:codigo, TO_DATE(:hfinal, 'DD/MM/YYYY HH24:MI:SS'),TO_DATE(:hinicio, 'DD/MM/YYYY HH24:MI:SS'), :tempo, :cdos,  
                 :funcionario, :servico, :descricao, :minuto, :feito,
                 0,0 ) ";
                $stmt = ociparse( $conn, $sql );

                $hfinal   = $item->getHoraFinal();
                $hinicio  = $item->getHoraInicial();
                $tempo    = $item->getTempoHora();
                $cdOs     = $item->getCdOs();
                $func     = $item->getFuncionario()->getCdFuncionario();
                $servico  = $item->getManuServ()->getCdServico();
                $descricao = $item->getDescricao();
                $minuto   = $item->getTempoMinuto();
                $feito    = $item->getSnFeito();

                 /*echo "Hora Final: $hfinal \n";
                 echo "Hora inicial: $hinicio \n";
                 echo "Tempo: $tempo \n";
                 echo "Cd OS: $cdOs \n";
                 echo "Funcionario: $func \n";*/



                ocibindbyname( $stmt, ":codigo", $codigo );
                ocibindbyname( $stmt, ":hfinal", $hfinal  );
                ocibindbyname( $stmt, ":hinicio", $hinicio );
                ocibindbyname( $stmt, ":tempo", $tempo );
                ocibindbyname( $stmt, ":cdos", $cdOs );
                ocibindbyname( $stmt, ":funcionario", $func );
                ocibindbyname( $stmt, ":servico", $servico );
                ocibindbyname( $stmt, ":descricao", $descricao );
                ocibindbyname( $stmt, ":minuto", $minuto );
                ocibindbyname( $stmt, ":feito", $feito );
        }


        try{

            ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );
            $teste = $codigo;

        }catch ( PDOException $e ){
            echo "Erro: ".$e->getMessage();
        }
        return $teste;
    }

    public function updateItemOs( itemSolicitacaoServico $item ){
        require_once "class.connection_factory.php";
        $teste = false;
        $con = new connection_factory();
        $conn = $con->getConnection();

        if( $item->getHoraFinal() == "" ){
            $sql =  "UPDATE DBAMV.ITSOLICITACAO_OS SET 
                  HR_INICIO          = TO_DATE(:hinicio, 'DD/MM/YYYY HH24:MI:SS')
                 ,VL_TEMPO_GASTO     = :hora
                 ,CD_OS              = :cdos
                 ,CD_FUNC            = :funcionario
                 ,CD_SERVICO         = :servico
                 ,DS_SERVICO         = :descricao
                 ,VL_TEMPO_GASTO_MIN = :minuto
                 ,SN_CHECK_LIST      = :feito
                 WHERE CD_ITSOLICITACAO_OS = :codigo";
            $stmt = ociparse( $conn, $sql );
            $hinicio  = $item->getHoraInicial();
            $tempo    = $item->getTempoHora();
            $cdOs     = $item->getCdOs();
            $func     = $item->getFuncionario()->getCdFuncionario();
            $servico  = $item->getManuServ()->getCdServico();
            $descricao = $item->getDescricao();
            $minuto   = $item->getTempoMinuto();
            $feito    = $item->getSnFeito();
            $codigo   = $item->getCdItem();
            ocibindbyname( $stmt, ":codigo", $codigo );
            ocibindbyname( $stmt, ":hinicio", $hinicio );
            ocibindbyname( $stmt, ":hora", $tempo );
            ocibindbyname( $stmt, ":cdos", $cdOs );
            ocibindbyname( $stmt, ":funcionario", $func );
            ocibindbyname( $stmt, ":servico", $servico );
            ocibindbyname( $stmt, ":descricao", $descricao );
            ocibindbyname( $stmt, ":minuto", $minuto );
            ocibindbyname( $stmt, ":feito", $feito );
        }else{
            $sql =  "UPDATE DBAMV.ITSOLICITACAO_OS SET 
                  HR_FINAL           = NVL(NULL,TO_DATE(:hfinal, 'DD/MM/YYYY HH24:MI:SS'))
                 ,HR_INICIO          = TO_DATE(:hinicio, 'DD/MM/YYYY HH24:MI:SS')
                 ,VL_TEMPO_GASTO     = :hora
                 ,CD_OS              = :cdos
                 ,CD_FUNC            = :funcionario
                 ,CD_SERVICO         = :servico
                 ,DS_SERVICO         = :descricao
                 ,VL_TEMPO_GASTO_MIN = :minuto
                 ,SN_CHECK_LIST      = :feito
                 WHERE CD_ITSOLICITACAO_OS = :codigo";
                    $stmt = ociparse( $conn, $sql );
                    $hfinal   = $item->getHoraFinal();
                    $hinicio  = $item->getHoraInicial();
                    $tempo    = $item->getTempoHora();
                    $cdOs     = $item->getCdOs();
                    $func     = $item->getFuncionario()->getCdFuncionario();
                    $servico  = $item->getManuServ()->getCdServico();
                    $descricao = $item->getDescricao();
                    $minuto   = $item->getTempoMinuto();
                    $feito    = $item->getSnFeito();
                    $codigo   = $item->getCdItem();
                    ocibindbyname( $stmt, ":codigo", $codigo );
                    ocibindbyname( $stmt, ":hfinal", $hfinal );
                    ocibindbyname( $stmt, ":hinicio", $hinicio );
                    ocibindbyname( $stmt, ":hora", $tempo );
                    ocibindbyname( $stmt, ":cdos", $cdOs );
                    ocibindbyname( $stmt, ":funcionario", $func );
                    ocibindbyname( $stmt, ":servico", $servico );
                    ocibindbyname( $stmt, ":descricao", $descricao );
                    ocibindbyname( $stmt, ":minuto", $minuto );
                    ocibindbyname( $stmt, ":feito", $feito );
        }

        try{

            ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );
            $teste = true;

        }catch ( PDOException $e ){
            echo "Erro: ".$e->getMessage();
        }
        return $teste;
    }


    public function getItem( $os ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.funcionario.php";
        require_once "../beans/class.manuServ.php";
        $con = new connection_factory();
        $conn = $con->getConnection();
        $item = null;
        $sql = " SELECT * FROM DBAMV.ITEM_ORDEM_SERVICO I WHERE I.CODIGO = :codigo ";
        try{
            $stmt = ociparse( $conn, $sql);
            ocibindbyname( $stmt, ":codigo", $os );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $item = new itemSolicitacaoServico();
                $horaFinal = "";
                if( isset(  $row['HR_FINAL'] ) ){
                    $horaFinal =  $row['HR_FINAL'];
                }

                $vlTempoGasto = "";
                if( isset( $row['VL_TEMPO_GASTO'] ) )
                    $vlTempoGasto = $row['VL_TEMPO_GASTO'];

                $vlTimeGastoMin = "";
                if( isset( $row['VL_TEMPO_GASTO_MIN'] ) )
                    $vlTimeGastoMin = $row['VL_TEMPO_GASTO_MIN'];

                $descricao = "";
                if( isset( $row['DS_SERVICO'] ) ){
                    $descricao = $row['DS_SERVICO'];
                }

                $item->setCdItem( $row['CODIGO'] );
                $item->setDataFinal( $horaFinal );
                $item->setDataInicial( $row['HR_INICIO'] );
                $item->setSnFeito( $row['SN_CHECK_LIST'] );
                $item->setTempoHora( $vlTempoGasto );
                $item->setTempoMinuto( $vlTimeGastoMin );
                $item->setDescricao( $descricao );
                $item->setFuncionario( new funcionario() );
                $item->getFuncionario()->setCdFuncionario( $row['CD_FUNC'] );
                $item->getFuncionario()->setNmFuncionario( $row['NM_FUNC'] );
                $item->setManuServ( new manuServ() );
                $item->getManuServ()->setCdServico( $row['CD_SERVICO']);
                $item->getManuServ()->setStrNmServico( $row['NM_SERVICO'] );

            }

        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $item;
    }

    public function getItOs(){
        require_once "class.connection_factory.php";
        $con = new connection_factory();
        $conn = $con->getConnection();
        $codigo = 0;
        $sql = "SELECT SEQ_ITOS.NEXTVAL CODIGO FROM DUAL";
        try{
            $stmt = ociparse( $conn, $sql );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $codigo = $row['CODIGO'];
            }
        }catch ( PDOException $e ){
            echo "Erro: ".$e->getMessage();
        }
        return $codigo;
    }

    public function excluir( $codigo ){
        require_once "class.connection_factory.php";
        $con = new connection_factory();
        $conn = $con->getConnection();
        $teste = false;

        $sql = "DELETE FROM DBAMV.ITSOLICITACAO_OS WHERE CD_ITSOLICITACAO_OS = :codigo";
        try{
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":codigo", $codigo );
            ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );
            $teste = true;
        }catch ( PDOException $ex ){
            echo "Erro: ".$ex->getMessage();
        }
        return $teste;
    }

    public function getTotalMeusServicos( $usuario ){
        require_once "class.connection_factory.php";


        $con = new connection_factory();
        $conn = $con->getConnection();
        $total = 0;
        try {
            $sql = "SELECT count(*) TOTAL FROM DBAMV.V_CHAMADOS_SERVICOS V
                    WHERE V.CD_FUNC = :usuario";
            $stmt = oci_parse( $conn, $sql );
            oci_bind_by_name( $stmt, "usuario", $usuario );

            ociexecute( $stmt );
            if ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $total = $row['TOTAL'];
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $total;
    }

}