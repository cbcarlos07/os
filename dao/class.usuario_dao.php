<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 14/06/2017
 * Time: 17:23
 */
class usuario_dao
{

    public function recuperarEmpresa ($user){
        require_once  'class.connection_factory.php';
        $conn = new connection_factory();
        $conexao = $conn->getConnection();
        $i = "";
        $sql_text = "SELECT  
                        E.DS_MULTI_EMPRESA EMPRESA  
                      FROM   
                      DBASGU.USUARIOS                  U  
                      ,DBAMV.USUARIO_MULTI_EMPRESA     M  
                      ,DBAMV.MULTI_EMPRESAS            E  
                      WHERE  
                           U.CD_USUARIO = :NAME  
                      AND  U.CD_USUARIO = M.CD_ID_USUARIO ";
        try {
            $stmt = oci_parse($conexao, $sql_text);
            //echo "Variavel use $user";
            oci_bind_by_name($stmt, ":NAME", $user);
            oci_execute($stmt);
            if ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                $i = $row['EMPRESA'];
            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $i;
    }

    public function verificarPapel ($login){
        require_once 'class.connection_factory.php';
        //    System.out.println("DAO");
        $teste = false;
        $conn = new connection_factory();
        $conexao = $conn->getConnection();
        try {
            $sql_text = "SELECT * FROM V_CARDAPIO_PAPEL V WHERE V.USUARIO  = :LOGIN";


            $stmt =  oci_parse($conexao, $sql_text);
            oci_bind_by_name($stmt, ":LOGIN", $login);
            oci_execute($stmt);
            if($row = oci_fetch_array($stmt, OCI_ASSOC)){

                $teste = true;

            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }

        return $teste;
    }

    public function verificarLogin($login, $senha){
        $retorno = 0;
        $usuario_banco = "";
        $senha_banco = "";
        require_once 'class.connection_factory.php';
        require  ('../lib/nusoap.php');
        $conn = new connection_factory();
        $conexao = $conn->getConnection();
        $sql = "select dbaadv.senhausuariomv(:usuario)  SENHA FROM DUAL ";
        try {
            $stmt =  oci_parse($conexao, $sql);
            oci_bind_by_name($stmt, ":usuario", $login, -1);
            oci_execute($stmt);
            if($row = oci_fetch_array($stmt, OCI_ASSOC)){

               // $usuario_banco = $row['CD_USUARIO'];
                $senha_banco   = $row['SENHA'];;
                if( $senha_banco == $senha  ){
                    $retorno = 1;
                }

            }
            //echo "Usuario Form: ".$login."\n";
            //echo "Senha Form: ".$senha;
            /*$conn->closeConnection($conexao);


            $client = new nusoap_client("http://chamados.sulwork.com.br/webservice/usermv/service.php?wsdl");

            $retorno =     $client->call('price_senha_form',array("senha"=>"$senha"
            ,"senha_b"=>"$senha_banco"
            ,"usuario_f"=>"$login"
            ,"usuario_b"=>"$usuario_banco"));*/

        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }

        return $retorno;
    }
}