<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 07/07/2017
 * Time: 12:14
 */
class manuServ
{
    private $cdServico;
    private $strNmServico;

    /**
     * @return mixed
     */
    public function getCdServico()
    {
        return $this->cdServico;
    }

    /**
     * @param mixed $cdServico
     * @return manuServ
     */
    public function setCdServico($cdServico)
    {
        $this->cdServico = $cdServico;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStrNmServico()
    {
        return $this->strNmServico;
    }

    /**
     * @param mixed $strNmServico
     * @return manuServ
     */
    public function setStrNmServico($strNmServico)
    {
        $this->strNmServico = $strNmServico;
        return $this;
    }


}