<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:33
 */
class bens
{
    private $cdBem;
    private $dsItem;
    private $cdSetor;
    private $cdLocalidade;
    private $proprietario;
    private $nrPatrimonio;

    /**
     * @return mixed
     */
    public function getCdBem()
    {
        return $this->cdBem;
    }

    /**
     * @param mixed $cdBem
     * @return bens
     */
    public function setCdBem($cdBem)
    {
        $this->cdBem = $cdBem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsItem()
    {
        return $this->dsItem;
    }

    /**
     * @param mixed $dsItem
     * @return bens
     */
    public function setDsItem($dsItem)
    {
        $this->dsItem = $dsItem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCdSetor()
    {
        return $this->cdSetor;
    }

    /**
     * @param mixed $cdSetor
     * @return bens
     */
    public function setCdSetor($cdSetor)
    {
        $this->cdSetor = $cdSetor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCdLocalidade()
    {
        return $this->cdLocalidade;
    }

    /**
     * @param mixed $cdLocalidade
     * @return bens
     */
    public function setCdLocalidade($cdLocalidade)
    {
        $this->cdLocalidade = $cdLocalidade;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProprietario()
    {
        return $this->proprietario;
    }

    /**
     * @param mixed $proprietario
     * @return bens
     */
    public function setProprietario($proprietario)
    {
        $this->proprietario = $proprietario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrPatrimonio()
    {
        return $this->nrPatrimonio;
    }

    /**
     * @param mixed $nrPatrimonio
     * @return bens
     */
    public function setNrPatrimonio($nrPatrimonio)
    {
        $this->nrPatrimonio = $nrPatrimonio;
        return $this;
    }




}