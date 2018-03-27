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
    private $dsBem;
    private $proprietario;
    private $nrPatrimonio;
    private $nrSerie;
    private $cdTipoEquipamento;
    private $cdFabricante;

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
    public function getDsBem()
    {
        return $this->dsBem;
    }

    /**
     * @param mixed $dsBem
     * @return bens
     */
    public function setDsBem($dsBem)
    {
        $this->dsBem = $dsBem;
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

    /**
     * @return mixed
     */
    public function getNrSerie()
    {
        return $this->nrSerie;
    }

    /**
     * @param mixed $nrSerie
     * @return bens
     */
    public function setNrSerie($nrSerie)
    {
        $this->nrSerie = $nrSerie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCdTipoEquipamento()
    {
        return $this->cdTipoEquipamento;
    }

    /**
     * @param mixed $cdTipoEquipamento
     * @return bens
     */
    public function setCdTipoEquipamento($cdTipoEquipamento)
    {
        $this->cdTipoEquipamento = $cdTipoEquipamento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCdFabricante()
    {
        return $this->cdFabricante;
    }

    /**
     * @param mixed $cdFabricante
     * @return bens
     */
    public function setCdFabricante($cdFabricante)
    {
        $this->cdFabricante = $cdFabricante;
        return $this;
    }







}