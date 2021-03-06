<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 16/06/2017
 * Time: 12:30
 */
    require '../controller/class.usuario_controller.php';

    $acao = $_POST['acao'];
    $usuario = "";
    $senha   = "";

    if(isset($_POST['usuario']))
        $usuario = strtoupper($_POST['usuario']);

    if(isset($_POST['senha']))
        $senha = strtoupper($_POST['senha']);


    switch ($acao){
        case 'E':
            recuperarEmpresa($usuario);
            break;
        case 'L':
            loginESenha($usuario, $senha);
            break;
        case 'S':
            logOff();
            break;
        case 'U':
            getListUsuarios();
            break;
        case 'P':
            verificarPapel( $usuario );
            break;
    }


    function recuperarEmpresa($usuario){
        $usuarioController = new usuario_controller();
        $empresa = $usuarioController->recuperarEmpresa($usuario);

        echo json_encode(array("empresa" => $empresa));
    }

    function loginESenha($usuario, $senha){
        require_once "../controller/class.os_controller.php";
        $usuarioController = new usuario_controller();
        $teste = $usuarioController->verificarLogin($usuario, $senha);
        $osController = new os_controller();
       // $system = 0;
        session_start();


        if( $teste ==  1){

            $sistema = $osController->verificaPapelUsuario( $usuario );
           // echo "Sistema: ".$sistema;
          //  $system = $sistema;
            $cdFunc = $usuarioController->getCodigoFuncionario( $usuario );


            $_SESSION['sistema'] = $sistema;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['funcionario'] = $cdFunc;
           // $_SESSION['versao']      = 'v2.7.0';

        }
        echo json_encode(array("sucesso" => $teste));

    }

    function verificarPapel( $usuario ){
        require_once "../controller/class.os_controller.php";
        $osController = new os_controller();

        $usuarioDeTI = $osController->verificaPapelUsuario( $usuario );

        echo json_encode( array("permissao" => $usuarioDeTI ) );
    }

    function logOff(){
        session_start();
        $host = $_SERVER[ 'HTTP_HOST'];
        session_destroy();
        echo json_encode(array("sucesso" => 1, "host" => $host));
    }

    function getListUsuarios(){
        require_once "../controller/class.os_controller.php";
        require_once "../services/class.usuario_list_iterator.php";
        require_once "../beans/class.usuario.php";

        $osController = new os_controller();
        $lista = $osController->getListUsuarios();
        $usuariosList = new usuario_list_iterator( $lista );
        $usuarios = array();
        while ( $usuariosList->hasNextUsuario() ){
            $usuario = $usuariosList->getNextUsuario();
            $usuarios[] = array(
                "usuario" => $usuario->getCdUsuario(),
                "nome" => $usuario->getNmUsuario()
            );
        }

        echo json_encode(array( "usuarios" => $usuarios));



    }