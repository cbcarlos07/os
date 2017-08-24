<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 19/06/2017
 * Time: 09:25
 */
class usuario
{
    private $cdUsuario;
    private $nmUsuario;
    private $pwdUsuario;

    /**
     * @return mixed
     */
    public function getCdUsuario()
    {
        return $this->cdUsuario;
    }

    /**
     * @param mixed $cdUsuario
     * @return usuario
     */
    public function setCdUsuario($cdUsuario)
    {
        $this->cdUsuario = $cdUsuario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmUsuario()
    {
        return $this->nmUsuario;
    }

    /**
     * @param mixed $nmUsuario
     * @return usuario
     */
    public function setNmUsuario($nmUsuario)
    {
        $this->nmUsuario = $nmUsuario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPwdUsuario()
    {
        return $this->pwdUsuario;
    }

    /**
     * @param mixed $pwdUsuario
     * @return usuario
     */
    public function setPwdUsuario($pwdUsuario)
    {
        $this->pwdUsuario = $pwdUsuario;
        return $this;
    }
}