<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 12/07/2017
 * Time: 15:55
 */
class funcionario
{
    private $cdFuncionario;
    private $nmFuncionario;

    /**
     * @return mixed
     */
    public function getCdFuncionario()
    {
        return $this->cdFuncionario;
    }

    /**
     * @param mixed $cdFuncionario
     * @return funcionario
     */
    public function setCdFuncionario($cdFuncionario)
    {
        $this->cdFuncionario = $cdFuncionario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmFuncionario()
    {
        return $this->nmFuncionario;
    }

    /**
     * @param mixed $nmFuncionario
     * @return funcionario
     */
    public function setNmFuncionario($nmFuncionario)
    {
        $this->nmFuncionario = $nmFuncionario;
        return $this;
    }


}