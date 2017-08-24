<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:33
 */
class bens
{
private $sequencia;
private $codBem;
private $checado;
private $plaqueta;
private $nrSerie;
private $descBem;
private $marca;
private $modelo;
private $setor;
private $localidade;
private $dtCompra;
private $especie;
private $classe;
private $subClasse;
private $classificacao;
private $subClassificacao;

    /**
     * @return mixed
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * @param mixed $sequencia
     * @return bens
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * @param mixed $codBem
     * @return bens
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChecado()
    {
        return $this->checado;
    }

    /**
     * @param mixed $checado
     * @return bens
     */
    public function setChecado($checado)
    {
        $this->checado = $checado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlaqueta()
    {
        return $this->plaqueta;
    }

    /**
     * @param mixed $plaqueta
     * @return bens
     */
    public function setPlaqueta($plaqueta)
    {
        $this->plaqueta = $plaqueta;
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
    public function getDescBem()
    {
        return $this->descBem;
    }

    /**
     * @param mixed $descBem
     * @return bens
     */
    public function setDescBem($descBem)
    {
        $this->descBem = $descBem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     * @return bens
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     * @return bens
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSetor()
    {
        return $this->setor;
    }

    /**
     * @param mixed $setor
     * @return bens
     */
    public function setSetor(Setor $setor)
    {
        $this->setor = $setor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocalidade()
    {
        return $this->localidade;
    }

    /**
     * @param mixed $localidade
     * @return bens
     */
    public function setLocalidade($localidade)
    {
        $this->localidade = $localidade;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtCompra()
    {
        return $this->dtCompra;
    }

    /**
     * @param mixed $dtCompra
     * @return bens
     */
    public function setDtCompra($dtCompra)
    {
        $this->dtCompra = $dtCompra;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * @param mixed $especie
     * @return bens
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param mixed $classe
     * @return bens
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubClasse()
    {
        return $this->subClasse;
    }

    /**
     * @param mixed $subClasse
     * @return bens
     */
    public function setSubClasse($subClasse)
    {
        $this->subClasse = $subClasse;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClassificacao()
    {
        return $this->classificacao;
    }

    /**
     * @param mixed $classificacao
     * @return bens
     */
    public function setClassificacao($classificacao)
    {
        $this->classificacao = $classificacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubClassificacao()
    {
        return $this->subClassificacao;
    }

    /**
     * @param mixed $subClassificacao
     * @return bens
     */
    public function setSubClassificacao($subClassificacao)
    {
        $this->subClassificacao = $subClassificacao;
        return $this;
    }


}