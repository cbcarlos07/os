<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 27/03/18
 * Time: 10:06
 */

class bemHistorico
{
    private $cdHistorico;
    private $cdBem;
    private $cdSetor;
    private $cdLocalidade;
    private $dtEntrada;
    private $usuario;

    /**
     * @return mixed
     */
    public function getCdHistorico()
    {
        return $this->cdHistorico;
    }

    /**
     * @param mixed $cdHistorico
     * @return bemHistorico
     */
    public function setCdHistorico($cdHistorico)
    {
        $this->cdHistorico = $cdHistorico;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCdBem()
    {
        return $this->cdBem;
    }

    /**
     * @param mixed $cdBem
     * @return bemHistorico
     */
    public function setCdBem($cdBem)
    {
        $this->cdBem = $cdBem;
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
     * @return bemHistorico
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
     * @return bemHistorico
     */
    public function setCdLocalidade($cdLocalidade)
    {
        $this->cdLocalidade = $cdLocalidade;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtEntrada()
    {
        return $this->dtEntrada;
    }

    /**
     * @param mixed $dtEntrada
     * @return bemHistorico
     */
    public function setDtEntrada($dtEntrada)
    {
        $this->dtEntrada = $dtEntrada;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     * @return bemHistorico
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }


}