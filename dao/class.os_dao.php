<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 19/06/2017
 * Time: 16:02
 */
class os_dao
{
    public function get_os_solicitadas($pesquisa, $usuario, $inicio, $fim){
        require_once 'class.connection_factory.php';
        require_once '../services/class.os_list.php';
        require_once '../beans/class.oficina.php';
        require_once '../beans/class.setor.php';
        require_once '../beans/class.usuario.php';
        $con = new connection_factory();
        $conn = $con->getConnection();

        $os_list = new os_list();

        $query = "SELECT * FROM (
                      SELECT ROWNUM LINHA, OS_.* FROM (
                       SELECT OS.*, O.DS_OFICINA
                              ,TO_CHAR(OS.DT_PEDIDO, 'DD/MM/YYYY') DATA_PEDIDO
                              ,S.NM_SETOR 
                       FROM 
                             DBAMV.SOLICITACAO_OS OS
                            ,DBAMV.OFICINA O
                            ,DBAMV.SETOR   S 
                        WHERE OS.NM_SOLICITANTE = :solicitante
                          AND OS.CD_OFICINA = O.CD_OFICINA
                          AND S.CD_SETOR = OS.CD_SETOR
                        ORDER BY OS.DT_PEDIDO DESC 
                      ) OS_  
                    ) OS
                    WHERE OS.LINHA > :inicio AND LINHA < :fim";
        try{
            $stmt = oci_parse($conn, $query);
            oci_bind_by_name($stmt, ":solicitante", $usuario, -1);
            oci_bind_by_name($stmt, ":inicio", $inicio, -1);
            oci_bind_by_name($stmt, ":fim", $fim, -1);
            oci_execute($stmt);
            while ( $row = oci_fetch_array($stmt, OCI_ASSOC) ){
                $os =  new os();
                $observacao = "";
                if( isset( $row['DS_OBSERVACAO'] ) ){
                    $observacao = $row['DS_OBSERVACAO'];
                }

                $responsavel = "";
                if( isset( $row['CD_RESPONSAVEL'] ) )
                    $responsavel = $row['CD_RESPONSAVEL'];

                $os->setCdOs($row['CD_OS']);
                $os->setDataPedido($row['DATA_PEDIDO']);
                $os->setDescricao($row['DS_SERVICO']);
                $os->setSituacao($row['TP_SITUACAO']);
                $os->setSetor( new setor() );
                $os->getSetor()->setCdSetor( $row['CD_SETOR'] );
                $os->getSetor()->setNmSetor( $row['NM_SETOR'] );
                $os->setOficina(new oficina());
                $os->getOficina()->setCdOficina($row['CD_OFICINA']);
                $os->getOficina()->setDsOficina($row['DS_OFICINA']);
                $os->setResponsavel( new usuario() );
                $os->getResponsavel()->setCdUsuario( $responsavel );
                $os->setObservacao( $observacao );

                $os_list->addOs($os);


            }

        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $os_list;

    }




    public function get_chamados_aguardando(){
        require_once 'class.connection_factory.php';
        require_once '../services/class.os_list.php';
        require_once '../beans/class.oficina.php';
        require_once '../beans/class.setor.php';
        require_once '../beans/class.usuario.php';
        $con = new connection_factory();
        $conn = $con->getConnection();

        $os_list = new os_list();

        $query = "SELECT * FROM DBAMV.VIEW_HAM_LISTA_OS_OPEN";
        try{
            $stmt = oci_parse($conn, $query);
            ociexecute( $stmt );
            while ( $row = oci_fetch_array($stmt, OCI_ASSOC) ){
                $os =  new os();
                $os->setCdOs($row['CD_OS']);
                $os->setDataPedido($row['DATA']);
                $os->setDescricao($row['DS_SERVICO']);
                $os->setSetor( new setor() );
                $os->getSetor()->setNmSetor( $row['NM_SETOR'] );
                $os->setSolicitante( new usuario() );
                $os->getSolicitante()->setCdUsuario( $row['NM_SOLICITANTE'] );
            $os->setObservacao( $row['NM_USUARIO'] );;
                $os_list->addOs($os);
            }

        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $os_list;

    }

    public function get_total_chamados_aguardando(){
        require_once 'class.connection_factory.php';
        $con = new connection_factory();
        $conn = $con->getConnection();

        $os_list = 0;

        $query = "SELECT COUNT(*) TOTAL FROM DBAMV.VIEW_HAM_LISTA_OS_OPEN";
        try{
            $stmt = oci_parse($conn, $query);
            ociexecute( $stmt );
            while ( $row = oci_fetch_array($stmt, OCI_ASSOC) ){

                $os_list = $row['TOTAL'];
            }

        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $os_list;

    }




    public function getTotalChamados($usuario){
        require_once 'class.connection_factory.php';
        require_once 'services/class.os_list.php';
        $con = new connection_factory();
        $conn = $con->getConnection();

        $total = 0;

        $query = "SELECT COUNT(*) TOTAL FROM DBAMV.SOLICITACAO_OS OS 
                    WHERE OS.NM_SOLICITANTE = :solicitante";
        try{
            $stmt = oci_parse($conn, $query);
            oci_bind_by_name($stmt, ":solicitante", $usuario, -1);
            oci_execute($stmt);
            if ( $row = oci_fetch_array($stmt, OCI_ASSOC) ){
                $total = $row['TOTAL'];


            }

        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return $total;
    }

     public function verificaSolicitacao( $usuario ){
        $retorno = false;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql = "SELECT * FROM DBAMV.SOLICITACAO_OS OS WHERE OS.NM_USUARIO = :usuario";

        try {
          $stmt = oci_parse( $conn, $sql );
          oci_bind_by_name( $stmt, ":usuario", $usuario );

          oci_execute( $stmt );
          if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
               $retorno = true;
            }
        } catch (PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
         }

         return $retorno;
     }


     public function getUltimaSolicitacao( $usuario ){
            require_once "class.connection_factory.php";
            require_once "../beans/class.os.php";
            require_once "../beans/class.manuEspec.php";
            require_once "../beans/class.motServ.php";
            require_once "../beans/class.manuServ.php";
            require_once "../beans/class.tipo_os.php";
            require_once "../beans/class.oficina.php";
            require_once "../beans/class.usuario.php";

            $solicitacao = null;
            $con = new connection_factory();
            $conn = $con->getConnection();


            $sql =   "SELECT * FROM DBAMV.VIEW_HAM_OS_CHAMADOS V WHERE V.NM_USUARIO = :usuario ";

            try {
               $stmt = oci_parse( $conn, $sql );
               oci_bind_by_name( $stmt, ":usuario", $usuario );
               oci_execute( $stmt );
                if( $row = oci_fetch_array( $stmt, OCI_ASSOC )){
                    $solicitacao = new os();
                    $solicitacao->setEspecialidade( new manuEspec() );
                    $solicitacao->getEspecialidade()->setCdEspec( $row['CD_ESPEC'] );
                    $solicitacao->setTipoOs( new tipo_os() );
                    $solicitacao->getTipoOs()->setCdTipoOs( $row['CD_TIPO_OS'] );
                    $solicitacao->setMotServ( new motServ() );
                    $solicitacao->getMotServ()->setCdMotServ( $row['CD_MOT_SERV'] );
                    $solicitacao->setOficina( new oficina() );
                    $solicitacao->getOficina()->setCdOficina( $row['CD_OFICINA'] );
                    $solicitacao->setResponsavel( new usuario() );
                    $solicitacao->getResponsavel()->setCdUsuario( $row['CD_RESPONSAVEL'] );

                }
                $con->closeConnection( $conn );
            } catch ( PDOException $ex) {
                echo "Erro: ".$ex->getMessage();
            }

            return $solicitacao;
       }

     public function getListIpoOs(){
        require_once "class.connection_factory.php";
        require_once "../beans/class.tipo_os.php";
        require_once "../services/class.tipo_os_list.php";

        $tipo_os = null;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =   " SELECT * FROM DBAMV.TIPO_OS TP WHERE TP.CD_TIPO_OS NOT IN (5, 39, 1,2,3,4,37,41 )";

        $lista = new tipo_os_list();
        try {
            $stmt = oci_parse( $conn, $sql );
            oci_execute( $stmt );
            while ( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){

                $tipo_os = new tipo_os();
                $tipo_os->setCdTipoOs( $row['CD_TIPO_OS'] );
                $tipo_os->setDescricao( $row['DS_TIPO_OS'] );
                $lista->addTipo_Os( $tipo_os );
            }
            $con->closeConnection( $conn );

        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $lista;
   }

   public function getListEspecialidade(){
        require_once "class.connection_factory.php";
        require_once "../beans/class.manuServ.php";
        require_once "../services/class.manuEspec_list.php";
        $con = new connection_factory();
        $conn = $con->getConnection();

        $manuEspec = null;

        $sql =   "  SELECT * FROM DBAMV.MANU_ESPEC";
        $list = new manuEspec_list();
        try {
            $stmt = oci_parse( $conn, $sql );
            oci_execute( $stmt );

            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $manuEspec = new ManuEspec();
                $manuEspec->setCdEspec( $row["CD_ESPEC"]);
                $manuEspec->setDsEspec( $row["DS_ESPEC"]);
                $list->addManuEspec($manuEspec);
            }
        } catch ( PDOException $ex) {
           echo "Erro: ".$ex;
        }

        return $list;
    }

    public function getListMotServ($tipoOs){
       require_once "class.connection_factory.php";
       require_once "../services/class.motServ_list.php";
       require_once "../beans/class.motServ.php";

        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =   "SELECT * FROM DBAMV.MOT_SERV MS WHERE MS.CD_TIPO_OS = :tipo";
        $list = new motServ_list();
        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt,":tipo", $tipoOs );
            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $motServ = new motServ();
                $motServ->setCdMotServ( $row["CD_MOT_SERV"]);
                $motServ->setDsMotServ($row["DS_MOT_SERV"]);
                $list->addMotServ($motServ);
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $list;
    }

    public function getListOficina($usuario){
        require_once "class.connection_factory.php";
        require_once "../services/class.oficina_list.php";
        require_once "../beans/class.oficina.php";
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =   "SELECT O.CD_OFICINA 
                        ,A.DS_OFICINA 
                    FROM DBAMV.USUARIO_OFICINA O
                        ,DBAMV.OFICINA         A
                    WHERE O.CD_USUARIO = :usuario   
                      AND A.CD_OFICINA = O.CD_OFICINA
                      AND A.DS_OFICINA LIKE 'TI%'";
        $list = new oficina_list();
        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":usuario", $usuario );
            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $oficina = new oficina();
                $oficina->setCdOficina( $row["CD_OFICINA"]);
                $oficina->setDsOficina( $row["DS_OFICINA"]);
                $list->addOficina( $oficina );
            }
        } catch ( PDOException $ex ) {
            echo "Erro: ".$ex->getMessage();
        }

        return $list;
    }


    public function getListOficinas( ){
        require_once "class.connection_factory.php";
        require_once "../services/class.oficina_list.php";
        require_once "../beans/class.oficina.php";
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =   "SELECT O.CD_OFICINA 
                        ,A.DS_OFICINA 
                    FROM DBAMV.USUARIO_OFICINA O
                        ,DBAMV.OFICINA         A
                  WHERE A.CD_OFICINA = O.CD_OFICINA
                    AND A.DS_OFICINA LIKE 'TI%'
                    GROUP BY O.CD_OFICINA 
                             ,A.DS_OFICINA ";
        $list = new oficina_list();
        try {
            $stmt = ociparse( $conn, $sql );

            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $oficina = new oficina();
                $oficina->setCdOficina( $row["CD_OFICINA"]);
                $oficina->setDsOficina( $row["DS_OFICINA"]);
                $list->addOficina( $oficina );
            }
        } catch ( PDOException $ex ) {
            echo "Erro: ".$ex->getMessage();
        }

        return $list;
    }

    public function getListUsuarioOficina( $oficina ){
      require_once "class.connection_factory.php";
      require_once "../beans/class.usuario.php";
      require_once "../services/class.usuario_list.php";
      $con = new connection_factory();
      $conn = $con->getConnection();
      $sql =   "SELECT UF.CD_OFICINA
                      ,A.DS_OFICINA 
                      ,U.NM_USUARIO
                      ,U.CD_USUARIO
               FROM DBAMV.USUARIO_OFICINA UF
                   ,DBAMV.OFICINA         A
                   ,DBASGU.USUARIOS       U
              WHERE UF.CD_OFICINA = :oficina
                AND A.CD_OFICINA = UF.CD_OFICINA
                AND U.CD_USUARIO = UF.CD_USUARIO
                ORDER BY U.NM_USUARIO";
        $list = new usuario_list();
        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":oficina", $oficina );
            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $usuario = new usuario();
                $usuario->setNmUsuario( $row["NM_USUARIO"]);
                $usuario->setCdUsuario( $row["CD_USUARIO"]);
                $list->addUsuario($usuario);
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $list;
    }


    public function getListaResponsaveis(  ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.usuario.php";
        require_once "../services/class.usuario_list.php";
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =   "SELECT * FROM DBAMV.VIEW_HAM_OS_USUARIOS";
        $list = new usuario_list();
        try {
            $stmt = ociparse( $conn, $sql );
            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $usuario = new usuario();
                $usuario->setNmUsuario( $row["NM_USUARIO"]);
                $usuario->setCdUsuario( $row["CD_USUARIO"]);
                $list->addUsuario($usuario);
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $list;
    }


    public function verificaPapelUsuario( $usuario ){
        require_once "class.connection_factory.php";
        $con = new connection_factory();
        $teste = 0;
        $conn = $con->getConnection();
        $sql = "SELECT * FROM V_TI_PAPEL V WHERE V.USUARIO  = :LOGIN";
        /*$sql =   "SELECT UF.CD_OFICINA
                        ,A.DS_OFICINA 
                        ,U.NM_USUARIO
                        ,U.CD_USUARIO
                 FROM DBAMV.USUARIO_OFICINA UF
                     ,DBAMV.OFICINA         A
                     ,DBASGU.USUARIOS       U
                WHERE UF.CD_OFICINA = 15
                  AND A.CD_OFICINA = UF.CD_OFICINA
                  AND U.CD_USUARIO = UF.CD_USUARIO
                  AND UF.SN_ATIVO = 'S'                  
                  AND U.CD_USUARIO NOT IN ('JACILENE.MELO','VICTOR.FARIAS','JACILENE.MELO','DBAMV','ZULEIDE.OLIVEIRA')
                  AND U.CD_USUARIO = :usuario
                  ORDER BY U.NM_USUARIO";
*/
        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":LOGIN", $usuario );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $teste = $row['PAPEL'];
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $teste;
    }



    public function getListUsuarios(){
        require_once "class.connection_factory.php";
        require_once "../beans/class.usuario.php";
        require_once "../services/class.usuario_list.php";
        $con = new connection_factory();
        $conn = $con->getConnection();

        $sql =   " SELECT * 
                     FROM DBASGU.USUARIOS U
                     WHERE U.SN_ATIVO = 'S'
                     ORDER BY 1 ";
        $list = new usuario_list();
        try {
            $stmt = ociparse( $conn, $sql );
            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $usuario = new usuario();
                $usuario->setNmUsuario( $row["NM_USUARIO"]);
                $usuario->setCdUsuario( $row["CD_USUARIO"]);
                $list->addUsuario($usuario);
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $list;
    }


    public function verificaUltimoSolicitante($solicitante){
        require_once "class.connection_factory.php";
        $teste = false;

        $con = new connection_factory();
        $conn = $con->getConnection();

        $sql =  "  SELECT * FROM DBAMV.SOLICITACAO_OS OS 
                     WHERE OS.NM_SOLICITANTE = :solicitante";

        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":solicitante", $solicitante );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $teste = true;
            }
            $con->closeConnection( $conn );
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $teste;
    }

    public function getDadosUltimoSolicitante( $solicitante ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.setor.php";

        $setor = null;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =   "  SELECT  OS.CD_SETOR 
                            ,S.NM_SETOR
                       FROM SOLICITACAO_OS OS
                           ,SETOR          S
                      WHERE OS.NM_SOLICITANTE = :solicitante
                      AND   OS.CD_SETOR = S.CD_SETOR
                   ORDER BY OS.DT_PEDIDO DESC";

        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":solicitante", $solicitante );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $setor =  new setor();
                $setor->setCdSetor( $row['CD_SETOR'] );
                $setor->setNmSetor( $row["NM_SETOR"] );
            }
            $con->closeConnection( $conn );
        } catch ( PDOException $ex) {
              echo "Erro: ".$ex->getMessage();
        }

        return $setor;
    }

    public function getListSetor(){
        require_once "class.connection_factory.php";
        require_once "../beans/class.setor.php";
        require_once "../services/class.setor_list.php";
        $setor = null;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =    "   SELECT S.CD_SETOR
                            ,S.NM_SETOR
                       FROM DBAMV.SETOR S
                   ORDER BY S.NM_SETOR";
        $list = new setor_list();
        try {
            $stmt = ociparse( $conn, $sql );
            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $setor =  new setor();
                $setor->setCdSetor( $row["CD_SETOR"]);
                $setor->setNmSetor( $row["NM_SETOR"]);
                $list->addSetor($setor);
            }
        } catch ( PDOException $ex) {
               echo "Erro: ".$ex->getMessage();
        }

        return $list;
    }


    public function getUsuario( $user ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.setor.php";
        $usuario = "";
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =  "    SELECT U.NM_USUARIO
                       FROM DBASGU.USUARIOS U
                       WHERE U.CD_USUARIO = :usuario   ";

        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":usuario", $user );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $usuario = $row["NM_USUARIO"];
            }
        } catch ( PDOException $e ) {
              echo "Erro: ".$e->getMessage();
        }

        return $usuario;
    }


    public function insert_chamado(os $os){
        require_once "class.connection_factory.php";

        $retorno = 0;
        $codigo = $this->proxRegistro();
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql = "INSERT INTO DBAMV.SOLICITACAO_OS 
                 (CD_OS, DT_PEDIDO, DT_ENTREGA, NM_SOLICITANTE, CD_SETOR, CD_TIPO_OS,
                  CD_MOT_SERV, CD_OFICINA, DS_SERVICO, DS_OBSERVACAO,  CD_RESPONSAVEL, TP_SITUACAO, 
                  DS_CONCLUIDO, CD_MULTI_EMPRESA,  NM_USUARIO, DT_ULTIMA_ATUALIZACAO,
                  SN_SOL_EXTERNA,  SN_ORDEM_SERVICO_PRINCIPAL, 
                  SN_PACIENTE, TP_PRIORIDADE, SN_RECEBIDA,  SN_ETIQUETA_IMPRESSA,
                  SN_EMAIL_ENVIADO, TP_CLASSIFICACAO, CD_ESPEC, DS_RAMAL, TP_LOCAL
                  ,CD_BEM, CD_LOCALIDADE
                 )
                 VALUES 
                ( :codigo, TO_DATE(:pedido, 'DD/MM/YYYY HH24:MI' ), TO_DATE(:entrega, 'DD/MM/YYYY HH24:MI' ), :solicitante,:setor, 
                  :tipoos, :motserv, :oficina, :servico, :observacao,
                  :responsavel, :situacao, :resolucao, 1, :usuario, SYSDATE, 'S', 'S',
                 'N', 'E', 'S', 'N', 'N', 'P', 31, :ramal, 'I', :bem, :localidade)";

        try {

            $stmt = ociparse($conn, $sql);
            //System.out.println("Data: "+os.getData_pedido());
            $dataPedido   = $os->getDataPedido();
            $dataEntrega  = $os->getPrevisao();
            $solicitante  = $os->getSolicitante()->getCdusuario();
            $setor        = $os->getSetor()->getCdSetor();
            $tipoOs       = $os->getTipoOs()->getCdTipoOs();
            $motivoServi  = $os->getMotServ()->getCdMotServ();
            $oficina      = $os->getOficina()->getCdOficina();
            $descricao    = $os->getDescricao();
            $observacao   = $os->getObservacao();
            $responsavel  = $os->getResponsavel()->getCdUsuario();
            $situacao     = $os->getSituacao();
            $resolucao    = $os->getResolucao();
            $usuario      = $os->getUsuario()->getCdUsuario();
            $ramal        = $os->getDsRamal();
            $bem          = $os->getBem()->getCodBem();
            $localidade   = $os->getLocalidade();

            /*echo "OS DAO Bem: $bem \n";
            echo "OS DAO localidade: $localidade \n";
            echo "OS DAO tipo os: $tipoOs";*/
            ocibindbyname( $stmt, ":codigo", $codigo );
            ocibindbyname( $stmt, ":pedido", $dataPedido );
            ocibindbyname( $stmt, ":entrega", $dataEntrega );
            ocibindbyname( $stmt, ":solicitante", $solicitante );
            ocibindbyname( $stmt, ":setor", $setor );
            ocibindbyname( $stmt, ":tipoos", $tipoOs );
            ocibindbyname( $stmt, ":motserv", $motivoServi);
            ocibindbyname( $stmt, ":oficina", $oficina );
            ocibindbyname( $stmt, ":servico", $descricao );
            ocibindbyname( $stmt, ":observacao", $observacao );
            ocibindbyname( $stmt, ":responsavel", $responsavel);
            ocibindbyname( $stmt, ":situacao", $situacao);
            ocibindbyname( $stmt, ":resolucao", $resolucao);
            ocibindbyname( $stmt, ":usuario", $usuario );
            ocibindbyname( $stmt, ":ramal", $ramal );
            ocibindbyname( $stmt, ":bem", $bem );
            ocibindbyname( $stmt, ":localidade", $localidade );


            $retorno = $codigo;
            ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );


        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $retorno;
    }

    public function insert_nova_solicitacao(os $os){
        require_once "class.connection_factory.php";

        $retorno = 0;
        $codigo = $this->proxRegistro();
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql = "INSERT INTO DBAMV.SOLICITACAO_OS 
                 (CD_OS, DT_PEDIDO, DS_SERVICO, DS_OBSERVACAO,  NM_SOLICITANTE, TP_SITUACAO, CD_SETOR,
                  CD_MULTI_EMPRESA, CD_TIPO_OS, NM_USUARIO, DT_ULTIMA_ATUALIZACAO,
                  SN_SOL_EXTERNA, CD_OFICINA, SN_ORDEM_SERVICO_PRINCIPAL, 
                  SN_PACIENTE, DT_ENTREGA, TP_PRIORIDADE, SN_RECEBIDA,  SN_ETIQUETA_IMPRESSA,
                  SN_EMAIL_ENVIADO, TP_CLASSIFICACAO, CD_ESPEC, DS_RAMAL, TP_LOCAL
                 )
                 VALUES 
                ( :codigo, SYSDATE, :servico, :observacao, :solicitante, 'S', :setor, 
                 1, 30, :usuario , SYSDATE , 
                 'S', 14, 'S',  
                 'N', SYSDATE , :prioridade, 'N',  'N',
                 'N',  'P', 31, :ramal, 'I')";

        try {

            $stmt = ociparse($conn, $sql);

            $dataPedido   = $os->getDataPedido();
            $descricao    = $os->getDescricao();
            $observacao   = $os->getObservacao();
            $solicitante  = $os->getSolicitante()->getCdUsuario();
            $setor        = $os->getSetor()->getCdSetor();
            $usuario      = $os->getUsuario()->getCdUsuario();
            $prioridade   = $os->getPrioridade();
            $ramal        = $os->getDsRamal();
/*
            echo "Solicitante: $solicitante \n";
            echo "Usuario: $usuario \n";*/
            ocibindbyname( $stmt, ":codigo", $codigo );
            ocibindbyname( $stmt, ":servico", $descricao );
            ocibindbyname( $stmt, ":observacao", $observacao );
            ocibindbyname( $stmt, ":solicitante", $solicitante );
            ocibindbyname( $stmt, ":setor", $setor );
            ocibindbyname( $stmt, ":usuario", $usuario );
            ocibindbyname( $stmt, ":prioridade", $prioridade);
            ocibindbyname( $stmt, ":ramal", $ramal);

            $retorno = $codigo;
            ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );


        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $retorno;
    }


    public function update_chamado(os $os){
        require_once "class.connection_factory.php";

        $teste = false;

        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =  "UPDATE   DBAMV.SOLICITACAO_OS SET
                          DT_PEDIDO         = TO_DATE(:pedido, 'DD/MM/YYYY HH24:MI:SS')                         
                         ,DT_ENTREGA        = TO_DATE(:entrega, 'DD/MM/YYYY HH24:MI:SS')
                         ,NM_SOLICITANTE    = :solicitante                        
                         ,CD_SETOR          = :setor                         
                         ,CD_TIPO_OS        = :tipoos
                         ,CD_MOT_SERV       = :motservico
                         ,DS_SERVICO        = :servico
                         ,DS_OBSERVACAO      = :observacao
                         ,CD_RESPONSAVEL    = :responsavel
                         ,TP_SITUACAO       = :status
                         ,DS_CONCLUIDO      = :resolucao
                         ,DT_ULTIMA_ATUALIZACAO = SYSDATE 
                         ,CD_OFICINA        = :oficina 
                         ,TP_PRIORIDADE     = :prioridade
                         ,CD_ESPEC          = :especialidade
                         ,DS_RAMAL          = :ramal
                         ,TP_LOCAL          = 'I'
                         WHERE CD_OS = :codigo";


        try {

            $stmt = oci_parse( $conn, $sql );

            $codigo      = $os->getCdOs();
            $dataPedido  = $os->getDataPedido();
            $previsao    = $os->getPrevisao();
            $descricao   = $os->getDescricao();
            $observacao  = $os->getObservacao();
            $solicitante = $os->getSolicitante()->getCdUsuario();
            $setor        = $os->getSetor()->getCdSetor();
            $especidalide = $os->getEspecialidade()->getCdEspec();
            $tipoOs       = $os->getTipoOs()->getCdTipoOs();
            $oficina      = $os->getOficina()->getCdOficina();
            $motivoServi  = $os->getMotServ()->getCdMotServ();
            $prioridade   = $os->getPrioridade();
            $responsavel  = $os->getResponsavel()->getCdUsuario();
            $status       = $os->getSituacao();
            $resolucao    = $os->getResolucao();
            $ramal        = $os->getDsRamal();


            oci_bind_by_name( $stmt, ":pedido", $dataPedido );
            oci_bind_by_name( $stmt, ":entrega", $previsao );
            oci_bind_by_name( $stmt, ":solicitante", $solicitante );
            oci_bind_by_name( $stmt, ":setor", $setor );
            oci_bind_by_name( $stmt, ":tipoos", $tipoOs );
            oci_bind_by_name( $stmt, ":motservico", $motivoServi);
            oci_bind_by_name( $stmt, ":servico", $descricao );
            oci_bind_by_name( $stmt, ":observacao", $observacao );
            oci_bind_by_name( $stmt, ":responsavel", $responsavel, -1);
            oci_bind_by_name( $stmt, ":status", $status );
            oci_bind_by_name( $stmt, ":resolucao", $resolucao );
            oci_bind_by_name( $stmt, ":oficina", $oficina );
            oci_bind_by_name( $stmt, ":prioridade", $prioridade);
            oci_bind_by_name( $stmt, ":especialidade", $especidalide );
            oci_bind_by_name( $stmt, ":codigo", $codigo );
            oci_bind_by_name( $stmt, ":ramal", $ramal );
            oci_execute( $stmt, OCI_COMMIT_ON_SUCCESS );
            $teste = true;



        } catch ( PDOException $ex) {
             echo "Erro: ".$ex->getMessage();
        }
        return $teste;
    }


    public function update_solicitacao(os $os){
        require_once "class.connection_factory.php";

        $teste = false;

        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =  "UPDATE   DBAMV.SOLICITACAO_OS SET
                          DS_SERVICO        = :servico
                         ,NM_SOLICITANTE    = :solicitante                        
                         ,CD_SETOR          = :setor
                         ,DS_OBSERVACAO     = :observacao
                         ,DS_RAMAL          = :ramal
                         WHERE CD_OS = :codigo";


        try {

            $stmt = ociparse( $conn, $sql );

            $codigo      = $os->getCdOs();
            $descricao   = $os->getDescricao();
            $solicitante = $os->getSolicitante()->getCdUsuario();
            $setor       = $os->getSetor()->getCdSetor();
            $observacao  = $os->getObservacao();
            $ramal       = $os->getDsRamal();

            ocibindbyname( $stmt, ":servico", $descricao );
            ocibindbyname( $stmt, ":solicitante", $solicitante );
            ocibindbyname( $stmt, ":setor", $setor );
            ocibindbyname( $stmt, ":observacao", $observacao );
            ocibindbyname( $stmt, ":codigo", $codigo );
            ocibindbyname( $stmt, ":ramal", $ramal );

            ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );
            $teste = true;



        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $teste;
    }




    public function update_situacao($tp_situacao, $cdOs){
        require_once "class.connection_factory.php";
        $teste = false;

        $con = new connection_factory();
        $conn = $con->getConnection();
        $sqlConcluir = "UPDATE DBAMV.SOLICITACAO_OS SET
                               TP_SITUACAO        = 'C'
                               ,DT_EXECUCAO       = SYSDATE
                          WHERE CD_OS = :codigo";

        $sql  = "UPDATE DBAMV.SOLICITACAO_OS SET
                        TP_SITUACAO   = :situacao
                  WHERE CD_OS = :codigo";


        try {
            if( $tp_situacao == "C" ){
                $stmt = ociparse( $conn, $sqlConcluir );
                ocibindbyname( $stmt, ":codigo", $cdOs );


            }else{
                $stmt = ociparse( $conn, $sql );
                ocibindbyname( $stmt, ":situacao", $tp_situacao );
                ocibindbyname( $stmt, ":codigo", $cdOs );
            }

            ociexecute( $stmt, OCI_COMMIT_ON_SUCCESS );

            $teste = true;
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $teste;
    }


    private function proxRegistro(){
        require_once "class.connection_factory.php";
        require_once "../beans/class.manuEspec.php";
        require_once "../beans/class.tipo_os.php";
        require_once "../beans/class.setor.php";
        require_once "../beans/class.oficina.php";
        require_once "../beans/class.usuario.php";
        $codigo = 0;
        $con = new connection_factory();
        $conn = $con->getConnection();

        $sql = "SELECT SEQ_OS.NEXTVAL CODIGO FROM DUAL";

        try {
            $stmt = oci_parse( $conn, $sql );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $codigo = $row["CODIGO"];
            }
            $con->closeConnection( $conn );
        } catch ( PDOException $ex) {
              echo "Erro: ".$ex->getMessage();
        }
        return $codigo;
    }

    public function getSolicitacao( $codigoOs ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.os.php";
        require_once "../beans/class.usuario.php";
        require_once "../beans/class.manuEspec.php";
        require_once "../beans/class.tipo_os.php";
        require_once "../beans/class.motServ.php";
        require_once "../beans/class.setor.php";
        require_once "../beans/class.oficina.php";

        $os =  null;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =  "SELECT * FROM DBAMV.VIEW_HAM_GETSOLICITACAO V WHERE V.CODIGO = :codigo";
        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":codigo", $codigoOs );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_COMMIT_ON_SUCCESS ) ){
                $os = new os();
                $observacao = "";
                if( isset($row["OBSERVACAO"]) )
                    $observacao = $row["OBSERVACAO"];

                $espec = 0;
                if( isset( $row["CODIGO_ESPEC"] ) ){
                    $espec = $row["CODIGO_ESPEC"];
                }

                $motivo = 0;

                if( isset( $row["CODIGO_MOTIVO"] ) ){
                    $motivo = $row["CODIGO_MOTIVO"];
                }

                $resp = "";
                if( isset( $row["RESPONSAVEL"] ) ){
                    $resp = $row["RESPONSAVEL"];
                }
                $previsao = "";
                if( isset( $row["PREVISAO"] ) ){
                    $previsao = $row["PREVISAO"];
                }

                $resolucao = "";
                if( isset( $row["RESOLUCAO"] ) ){
                    $resolucao = $row["RESOLUCAO"];
                }

                $ramal = "";
                if( isset( $row['DS_RAMAL'] ) ){
                    $ramal = $row['DS_RAMAL'];
                }

              //  echo "Ramal : $ramal";

                $os->setUsuario( new usuario() );
                $os->getUsuario()->setCdUsuario( $row['USUARIO'] );
                $os->setDescricao( $row["SERVICO"]);
                $os->setSolicitante( new usuario() );
                $os->getSolicitante()->setCdUsuario( $row["SOLICITANTE"] );
                $os->setDataPedido( $row["DH_PEDIDO"]);
                $os->setEspecialidade( new manuEspec() );
                $os->getEspecialidade()->setCdEspec( $espec );
                $os->setTipoOs( new tipo_os() );
                $os->getTipoOs()->setCdTipoOs( $row["CODIGO_TIPO_OS"] );
                $os->setMotServ( new motServ() );
                $os->getMotServ()->setCdMotServ( $motivo );
                $os->setSetor( new setor() );
                $os->getSetor()->setCdSetor( $row["CODIGO_SETOR"] );
                $os->getSetor()->setNmSetor( $row["SETOR"] );
                $os->setOficina( new oficina() );
                $os->getOficina()->setCdOficina( $row["CODIGO_OFICINA"] );
                $os->setPrioridade( $row["PRIORIDADE"] );
                $os->setResponsavel( new usuario() );
                $os->getResponsavel()->setCdUsuario( $resp );
                $os->setSituacao( $row["SITUACAO"] );
                $os->setPrevisao( $previsao );
                $os->setObservacao( $observacao );
                $os->setResolucao( $resolucao );
                $os->setDsRamal( $ramal );



            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $os;
    }


    public function verificaSeTemSolicitacao( $codigoOs ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.os.php";
        require_once "../beans/class.usuario.php";
        require_once "../beans/class.manuEspec.php";
        require_once "../beans/class.tipo_os.php";
        require_once "../beans/class.motServ.php";
        require_once "../beans/class.setor.php";
        require_once "../beans/class.oficina.php";

        $os =  false;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =  "SELECT * FROM VIEW_HAM_GETSOLICITACAO V WHERE V.CODIGO = :codigo";
        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":codigo", $codigoOs );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_COMMIT_ON_SUCCESS ) ){

                    $os = true;

            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $os;
    }

    public function getListSolicitacao( $inicio, $fim ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.os.php";
        require_once "../services/class.os_list.php";
        require_once "../beans/class.usuario.php";
        require_once "../beans/class.manuEspec.php";
        require_once "../beans/class.tipo_os.php";
        require_once "../beans/class.motServ.php";
        require_once "../beans/class.setor.php";
        require_once "../beans/class.oficina.php";

        $os =  null;
        $con = new connection_factory();
        $conn = $con->getConnection();
        $osList = new os_list();
        $sql =  "SELECT * FROM (
                  SELECT rownum LINHA, V.* 
                  FROM DBAMV.VIEW_HAM_GETSOLICITACAO V
                  )
                  WHERE LINHA > :inicio AND LINHA < :fim";
        try {
            $stmt = ociparse( $conn, $sql );
            ocibindbyname( $stmt, ":inicio", $inicio );
            ocibindbyname( $stmt, ":fim", $fim );
            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_COMMIT_ON_SUCCESS ) ){
                $os = new os();
                $observacao = "";
                if( isset($row["OBSERVACAO"]) )
                    $observacao = $row["OBSERVACAO"];

                $espec = 0;
                if( isset( $row["CODIGO_ESPEC"] ) ){
                    $espec = $row["CODIGO_ESPEC"];
                }

                $motivo = 0;

                if( isset( $row["CODIGO_MOTIVO"] ) ){
                    $motivo = $row["CODIGO_MOTIVO"];
                }

                $resp = "";
                if( isset( $row["RESPONSAVEL"] ) ){
                    $resp = $row["RESPONSAVEL"];
                }
                $previsao = "";
                if( isset( $row["PREVISAO"] ) ){
                    $previsao = $row["PREVISAO"];
                }

                $resolucao = "";
                if( isset( $row["RESOLUCAO"] ) ){
                    $resolucao = $row["RESOLUCAO"];
                }

                $ramal = "";
                if( isset( $row['DS_RAMAL'] ) ){
                    $ramal = $row['DS_RAMAL'];
                }



                $os->setCdOs( $row['CODIGO'] );
                $os->setUsuario( new usuario() );
                $os->getUsuario()->setCdUsuario( $row['USUARIO'] );
                $os->setDescricao( $row["SERVICO"]);
                $os->setSolicitante( new usuario() );
                $os->getSolicitante()->setCdUsuario( $row["SOLICITANTE"] );
                $os->setDataPedido( $row["DH_PEDIDO"]);
                $os->setEspecialidade( new manuEspec() );
                $os->getEspecialidade()->setCdEspec( $espec );
                $os->setTipoOs( new tipo_os() );
                $os->getTipoOs()->setCdTipoOs( $row["CODIGO_TIPO_OS"] );
                $os->setMotServ( new motServ() );
                $os->getMotServ()->setCdMotServ( $motivo );
                $os->setSetor( new setor() );
                $os->getSetor()->setCdSetor( $row["CODIGO_SETOR"] );
                $os->getSetor()->setNmSetor( $row["SETOR"] );
                $os->setOficina( new oficina() );
                $os->getOficina()->setCdOficina( $row["CODIGO_OFICINA"] );
                $os->setPrioridade( $row["PRIORIDADE"] );
                $os->setResponsavel( new usuario() );
                $os->getResponsavel()->setCdUsuario( $resp );
                $os->setSituacao( $row["SITUACAO"] );
                $os->setPrevisao( $previsao );
                $os->setObservacao( $observacao );
                $os->setResolucao( $resolucao );
                $os->setDsRamal( $ramal );

                $osList->addOs( $os );



            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $osList;
    }




    public function verificaUsuario( $usuario){
        require_once "class.connection_factory.php";
        $teste = false;

        $con = new connection_factory();
        $conn = $con->getConnection();
        $sql =  "SELECT * FROM DBASGU.USUARIOS U
                 WHERE U.CD_USUARIO = :usuario";
        try {
            $stmt = ociparse( $conn, $conn );
            ocibindbyname( $stmt, ":usuario", $usuario );
            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $teste = true;
            }
        } catch ( PDOException $ex) {
          echo "Erro: ".$ex->getMessage();
        }
        return $teste;
    }

    public function getListaChamados( $opcao, $parametro ){
        require_once "class.connection_factory.php";
        $teste = false;

        $con = new connection_factory();
        $conn = $con->getConnection();


        try {

            switch ($opcao){
                case 'C':
                    $sql = "SELECT * FROM DBAMV.VIEW_HAM_MEUS_CHAMADOS V WHERE V.CD_OS = :codigo";
                    $stmt = ociparse( $conn, $conn );
                    ocibindbyname( $stmt, ":codigo", $parametro );
                    break;
                case 'O':
                    $sql = "SELECT * FROM DBAMV.VIEW_HAM_MEUS_CHAMADOS V WHERE V.CD_OS = :codigo";
                    $stmt = ociparse( $conn, $conn );
                    ocibindbyname( $stmt, ":codigo", $parametro );
                    break;

            }


            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $teste = true;
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $teste;
    }

	 public function getListaMeusChamados( $variavel ){
		require_once "../includes/error.php";
        require_once "class.connection_factory.php";
        require_once "../services/class.os_list.php";
        require_once "../beans/class.os.php";
        require_once "../beans/class.oficina.php";
        require_once "../beans/class.setor.php";
        require_once "../beans/class.usuario.php";


        $con = new connection_factory();
        $conn = $con->getConnection();
        $os_list = new os_list();

        try {
            $sql = "SELECT * 
                      FROM DBAMV.V_CHAMADOS_CONSULTA V
                     WHERE  V.NM_SOLICITANTE LIKE :solicitante
                        AND V.CD_SETOR       LIKE :setor
                        AND V.CD_OFICINA     LIKE :oficina
                        AND V.CD_OS          LIKE :codigo
                        AND V.CD_RESPONSAVEL LIKE :responsavel";
            $stmt = oci_parse( $conn, $sql );
            oci_bind_by_name( $stmt, "solicitante", $variavel['solicitante'] );
            oci_bind_by_name( $stmt, "setor", $variavel['setor'] );
            oci_bind_by_name( $stmt, "oficina", $variavel['oficina'] );
            oci_bind_by_name( $stmt, "codigo", $variavel['codigo'] );
            oci_bind_by_name( $stmt, "responsavel", $variavel['responsavel'] );

            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $os = new os();
                $servico = "";
                if( isset( $row['DS_SERVICO'] ) )
                    $servico = $row['DS_SERVICO'];

                $os->setCdOs( $row['CD_OS'] );
                $os->setPrioridade( $row['PRIORIDADE'] );
                $os->setOficina( new oficina() );
                $os->setSolicitante( new usuario() );
                $os->getSolicitante()->setCdUsuario( $row['NM_SOLICITANTE'] );
                $os->setResponsavel( new usuario() );
                $os->getResponsavel()->setCdUsuario( $row['CD_RESPONSAVEL'] );
                $os->setSetor( new setor() );
                $os->getSetor()->setNmSetor( $row['NM_SETOR'] );
                $os->setDescricao( $servico );
                $os->setDataPedido( $row['DT_PEDIDO'] );
                $os->setPrevisao( $row['TIME_'] );
                $os_list->addOs( $os );
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $os_list;
    }

    public function getListaMeusChamadosData( $variavel ){
        require_once "../includes/error.php";
        require_once "class.connection_factory.php";
        require_once "../services/class.os_list.php";
        require_once "../beans/class.os.php";
        require_once "../beans/class.oficina.php";
        require_once "../beans/class.setor.php";
        require_once "../beans/class.usuario.php";


        $con = new connection_factory();
        $conn = $con->getConnection();
        $os_list = new os_list();

        try {
            $sql = "SELECT * 
                      FROM DBAMV.V_CHAMADOS_CONSULTA_TOTAL V
                     WHERE  V.NM_SOLICITANTE LIKE :solicitante
                        AND V.CD_SETOR       LIKE :setor
                        AND V.CD_OFICINA     LIKE :oficina
                        AND V.CD_OS          LIKE :codigo
                        AND V.CD_RESPONSAVEL LIKE :responsavel
                        AND TRUNC(TO_DATE(V.DT_PEDIDO, 'DD/MM/YYYY HH24:MI:SS')) BETWEEN :inicio AND :fim";
            $stmt = oci_parse( $conn, $sql );
            oci_bind_by_name( $stmt, "solicitante", $variavel['solicitante'] );
            oci_bind_by_name( $stmt, "setor", $variavel['setor'] );
            oci_bind_by_name( $stmt, "oficina", $variavel['oficina'] );
            oci_bind_by_name( $stmt, "codigo", $variavel['codigo'] );
            oci_bind_by_name( $stmt, "responsavel", $variavel['responsavel'] );
            oci_bind_by_name( $stmt, "inicio", $variavel['inicio'] );
            oci_bind_by_name( $stmt, "fim", $variavel['fim'] );

            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $os = new os();
                $servico = "";
                if( isset( $row['DS_SERVICO'] ) )
                    $servico = $row['DS_SERVICO'];

                $os->setCdOs( $row['CD_OS'] );
                $os->setPrioridade( $row['PRIORIDADE'] );
                $os->setOficina( new oficina() );
                $os->setSolicitante( new usuario() );
                $os->getSolicitante()->setCdUsuario( $row['NM_SOLICITANTE'] );
                $os->setResponsavel( new usuario() );
                $os->getResponsavel()->setCdUsuario( $row['CD_RESPONSAVEL'] );
                $os->setSetor( new setor() );
                $os->getSetor()->setNmSetor( $row['NM_SETOR'] );
                $os->setDescricao( $servico );
                $os->setDataPedido( $row['DT_PEDIDO'] );
                $os->setPrevisao( $row['TIME_'] );
                $os->setSituacao( $row['TP_SITUACAO'] );
                $os_list->addOs( $os );
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $os_list;
    }


    public function getTotalMeusChamados( $usuario ){

        require_once "class.connection_factory.php";


        $con = new connection_factory();
        $conn = $con->getConnection();
        $total = 0;
        try {
            $sql = "SELECT COUNT(*) TOTAL 
                      FROM DBAMV.V_CHAMADOS_CONSULTA V
                        WHERE V.CD_RESPONSAVEL = :responsavel";
            $stmt = oci_parse( $conn, $sql );
            oci_bind_by_name( $stmt, "responsavel", $usuario );

            ociexecute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
               $total = $row['TOTAL'];
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $total;
    }

    public function getListaMeusServicos( $variavel ){
        require_once "../includes/error.php";
        require_once "class.connection_factory.php";
        require_once "../services/class.itemSolicitacaoServico_list.php";
        require_once "../beans/class.os.php";
        require_once "../beans/class.oficina.php";
        require_once "../beans/class.setor.php";
        require_once "../beans/class.usuario.php";
        require_once "../beans/class.itemSolicitacaoServico.php";
        require_once "../beans/class.manuServ.php";


        $con = new connection_factory();
        $conn = $con->getConnection();
        $os_list = new itemSolicitacaoServico_list();

        try {
            $sql = "SELECT * 
                      FROM DBAMV.V_CHAMADOS_SERVICOS V
                     WHERE  V.NM_SOLICITANTE LIKE :solicitante
                        AND V.CD_SETOR       LIKE :setor
                        AND V.CD_OFICINA     LIKE :oficina
                        AND V.CD_OS          LIKE :codigo
                        AND V.CD_FUNC        LIKE :responsavel";
            $stmt = oci_parse( $conn, $sql );
            oci_bind_by_name( $stmt, "solicitante", $variavel['solicitante'] );
            oci_bind_by_name( $stmt, "setor", $variavel['setor'] );
            oci_bind_by_name( $stmt, "oficina", $variavel['oficina'] );
            oci_bind_by_name( $stmt, "codigo", $variavel['codigo'] );
            oci_bind_by_name( $stmt, "responsavel", $variavel['responsavel'] );

            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $os = new itemSolicitacaoServico();

                $servico = "";
                if( isset( $row['DS_SERVICO'] ) )
                    $servico = $row['DS_SERVICO'];

                $os->setCdOs( $row['CD_OS'] );
                $os->setChamado( $row['CHAMADO'] );
                $os->setResponsavel( $row['CD_RESPONSAVEL'] );
                $os->setManuServ( new manuServ() );
                $os->getManuServ()->setStrNmServico( $row['NM_SERVICO'] );
                $os->setDescricao( $servico );
                $os->setDataInicial( $row['INICIO'] );
                $os->setTempo( $row['STATUS'] );

                $os_list->addItemSolicitacaoServico( $os );
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $os_list;
    }

    public function getListFuncionario(){
        require_once "class.connection_factory.php";
        require_once "../beans/class.funcionario.php";
        require_once "../services/class.funcionario_list.php";
        $con = new connection_factory();
        $conn = $con->getConnection();

        $sql =   " SELECT F.CD_FUNC
                          ,F.NM_FUNC
                    FROM   DBAMV.MANU_ESPEC  E
                          ,DBAMV.FUNCIONARIO F
                          ,DBAMV.FUNC_ESPEC  FE
                    WHERE FE.CD_ESPEC = E.CD_ESPEC
                      AND FE.CD_FUNC  = F.CD_FUNC
                    GROUP BY F.CD_FUNC
                          ,F.NM_FUNC
                          ORDER BY 2 ";
        $list = new funcionario_list();
        try {
            $stmt = ociparse( $conn, $sql );
            ociexecute( $stmt );
            while( $row = oci_fetch_array( $stmt, OCI_ASSOC ) ){
                $usuario = new funcionario();
                $usuario->setNmFuncionario( $row["NM_FUNC"]);
                $usuario->setCdFuncionario( $row["CD_FUNC"]);
                $list->addFuncionario( $usuario );
            }
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $list;
    }

    public function getByPlaqueta( $plaqueta ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.os.php";
        require_once "../beans/class.bens.php";
        require_once "../beans/class.setor.php";

        $bem = null;
        $con = new connection_factory();
        $conn = $con->getConnection();

      //  echo "Plaqueta: ".$plaqueta." \n ";
        $sql =   "SELECT * FROM BENS B WHERE B.NR_SERIE = :plaqueta ";

        try {
            $stmt = oci_parse( $conn, $sql );
            oci_bind_by_name( $stmt, ":plaqueta", $plaqueta );
            oci_execute( $stmt );
            if( $row = oci_fetch_array( $stmt, OCI_ASSOC )){
                $bem = new bens();
                $bem->setCodBem( $row['CD_BEM'] );
                $bem->setSetor( new setor() );
                $bem->getSetor()->setCdSetor( $row['CD_SETOR']);
                $bem->setLocalidade( $row['CD_LOCALIDADE']);
                $bem->setDescBem( $row['DS_BEM']);


            }
            $con->closeConnection( $conn );
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $bem;
    }

    public function inserirAnexo( $values ){
        require_once "class.connection_factory.php";
        $con  = new connection_factory();
        $conn = $con->getConnection();
        $retorno = false;
      //  echo "File: ".$values[2]." \n <br>";
        $sql = "INSERT INTO SOLICITACAO_SERVICO_DOC VALUES (:p0,SEQ_SOLICITACAO_SERVICO_DOC.NEXTVAL,:p1, EMPTY_BLOB())
                 RETURNING LO_ANEXO_SOLICITACAO INTO :p2";


        try{

            foreach ( $values as $valor => $chave) {
                $lob = oci_new_descriptor( $conn, OCI_D_LOB );
                $stmt = ociparse( $conn,$sql );
                oci_bind_by_name( $stmt, ":p0", $chave['os'] );
                oci_bind_by_name( $stmt, ":p1", $chave['name'] );
                oci_bind_by_name( $stmt, ":p2", $lob, -1, OCI_B_BLOB );
                //echo "Dao: ";
          //      var_dump( $values );


              //  echo "Codigo da os insert: ".$chave['os']." \n";
                $retorno = oci_execute( $stmt, OCI_NO_AUTO_COMMIT ); //NAO COMITAR PARA LOB->SAVE() FUNCIONAR
                $lob->save( $chave['arquivo'] );
                $lob->close();

            }
            //$lob->save( $values[2] );
            oci_commit( $conn );
            //$lob->close();
            $con->closeConnection( $conn );

        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }

        return $retorno;

    }

    public function getAnexo( $values ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.solicitacaoServicoOS.php";
        $con  = new connection_factory();
        $conn = $con->getConnection();
        $doc = array();
        //  echo "Dao CD OS: ".$values." \n";
        $sql = "SELECT  D.CD_SOLICITACAO_OS
                       ,D.CD_SOLICITACAO_DOC
                       ,D.DS_SOLICITACAO_DOC
                  FROM DBAMV.SOLICITACAO_SERVICO_DOC D 
                 WHERE D.CD_SOLICITACAO_OS = :OS";


        try {
            $stmt = oci_parse( $conn, $sql );
            oci_bind_by_name( $stmt, ":OS", $values );

            oci_execute( $stmt );

            while( $row = oci_fetch_array( $stmt, OCI_ASSOC)){
            //    print $row['LO_ANEXO_SOLICITACAO'];
             //   echo $row['CD_SOLICITACAO_OS'];
               // echo "Codigo do docum: ".$row['CD_SOLICITACAO_DOC']." \n";
                $doc[] = array(
                    "os"        => $row['CD_SOLICITACAO_OS'],
                    "codigo"    => $row['CD_SOLICITACAO_DOC'],
                    "descricao" => $row['DS_SOLICITACAO_DOC']
                );



            }
            $con->closeConnection( $conn );
        } catch ( PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }

        return $doc;

    }


    public function getDataFile( $id ){
        require_once "class.connection_factory.php";
        require_once "../beans/class.solicitacaoServicoOS.php";
        $con  = new connection_factory();
        $conn = $con->getConnection();
        $sql='SELECT   D.DS_SOLICITACAO_DOC
                       ,D.LO_ANEXO_SOLICITACAO
                       ,LENGTH(D.LO_ANEXO_SOLICITACAO)  SIZE_   
                FROM DBAMV.SOLICITACAO_SERVICO_DOC D 
                WHERE D.CD_SOLICITACAO_DOC = :ID'; //selecting a blob field named 'document_body' with id = 1
        $stmt = ociparse($conn,$sql);
        oci_bind_by_name( $stmt, ":ID", $id );

        ociexecute($stmt) or die($sql.'<hr>');
        $file = "";
        $name = "";
        $filesize = "";
        if(ocifetch($stmt)) //if file exists
        {
            $file=ociresult($stmt,"LO_ANEXO_SOLICITACAO");
            $name=ociresult($stmt,"DS_SOLICITACAO_DOC");
            $filesize=ociresult($stmt,"SIZE_");
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' .$filesize);
        print $file->load();
//browser promts to save or open the file
    }



}