<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 18/07/2017
 * Time: 11:37
 */

$acao = $_POST['acao'];
$_cdOficina = 0;
$_cdEspec   = 0;

if( isset( $_POST['oficina'] ) )
    $_cdOficina = $_POST['oficina'];

if( isset( $_POST['especialidade'] ) )
    $_cdEspec = $_POST['especialidade'];

switch ($acao){
    case 'R':
        getListResponsavel( $_cdOficina );
        break;
    case 'U':
        getListResponsaveis(  );
        break;
    case 'F':
        getListFuncionario( $_cdEspec );
        break;
    case 'G':
        getListFunc(  );
        break;
}

    function getListResponsavel( $oficina ){
        require_once "../controller/class.os_controller.php";
        require_once "../beans/class.usuario.php";
        require_once "../services/class.usuario_list_iterator.php";

        $os_controller = new os_controller();
        $lista = $os_controller->getListUsuarioOficina( $oficina );

        echo json_encode( $lista );

    }


function getListResponsaveis(  ){
    require_once "../controller/class.os_controller.php";
    require_once "../beans/class.usuario.php";
    require_once "../services/class.usuario_list_iterator.php";

    $os_controller = new os_controller();
    $lista = $os_controller->getListaResponsaveis(  );
    $usuarioList = new usuario_list_iterator( $lista );
    $usuarios = array();
    while ( $usuarioList->hasNextUsuario() ){
        $usuario = $usuarioList->getNextUsuario();
        $usuarios[] = array(
            "nome" => $usuario->getNmUsuario(),
            "cdusuario" => $usuario->getCdUsuario()
        );
    }

    echo json_encode(array("usuarios" => $usuarios));

}



    function getListFuncionario( $cdEspec ){
        require_once "../controller/class.itemSolicitacaoServico_Controller.php";
        require_once "../beans/class.funcionario.php";
        require_once "../services/class.funcionario_list_iterator.php";

        $itemSolController = new itemSolicitacaoServico_Controller();
        $lista = $itemSolController->getListUsuarioEspecie( $cdEspec );
        $funcList = new funcionario_list_iterator( $lista );
        $funcionarios = array();
        while ( $funcList->hasNextFuncionario() ){
            $funcionario = $funcList->getNextFuncionario();
            $funcionarios[] = array(
                "codigo"  => $funcionario->getCdFuncionario(),
                "nome"    => $funcionario->getNmFuncionario()
            );

        }

        echo json_encode( array( "funcionarios" => $funcionarios ) );

    }


        function getListFunc(  ){
            require_once "../controller/class.os_controller.php";
            require_once "../beans/class.funcionario.php";
            require_once "../services/class.funcionario_list_iterator.php";

            $os_Controller = new os_controller();
            $lista = $os_Controller->getListFuncionario();
            $funcList = new funcionario_list_iterator( $lista );
            $funcionarios = array();
            while ( $funcList->hasNextFuncionario() ){
                $funcionario = $funcList->getNextFuncionario();
                $funcionarios[] = array(
                    "codigo"  => $funcionario->getCdFuncionario(),
                    "nome"    => $funcionario->getNmFuncionario()
                );

            }

            echo json_encode( array( "funcionarios" => $funcionarios ) );

        }