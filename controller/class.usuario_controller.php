<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 14/06/2017
 * Time: 17:28
 */
class usuario_controller
{
    public function recuperarEmpresa ($user){
        require_once '../dao/class.usuario_dao.php';
        $user_dao = new usuario_dao();
        $teste = $user_dao->recuperarEmpresa($user);
        return $teste;
    }

    public function verificarPapel ($login){
        require_once '../dao/class.usuario_dao.php';
        $user_dao = new usuario_dao();
        $teste = $user_dao->verificarPapel($login);
        return $teste;
    }

    public function verificarLogin($login, $senha){
        require_once '../dao/class.usuario_dao.php';
        $user_dao = new usuario_dao();
        $teste = $user_dao->verificarLogin($login, $senha);
        return $teste;
    }
}