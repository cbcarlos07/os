<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 19/06/2017
 * Time: 16:50
 */
class oficina
{
private $cdOficina;
private $dsOficina;

    /**
     * @return mixed
     */
    public function getCdOficina()
    {
        return $this->cdOficina;
    }

    /**
     * @param mixed $cdOficina
     * @return oficina
     */
    public function setCdOficina($cdOficina)
    {
        $this->cdOficina = $cdOficina;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsOficina()
    {
        return $this->dsOficina;
    }

    /**
     * @param mixed $dsOficina
     * @return oficina
     */
    public function setDsOficina($dsOficina)
    {
        $this->dsOficina = $dsOficina;
        return $this;
    }

}