<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 25/07/2017
 * Time: 10:41
 */
class template
{
    private $cdTemplate;
    private $nmSolicitante;
    private $cdSetor;
    private $dsServico;
    private $dsObservacao;
    private $nmUsuario;
    private $dsTitulo;

    /**
     * @return mixed
     */
    public function getDsTitulo()
    {
        return $this->dsTitulo;
    }

    /**
     * @param mixed $dsTitulo
     * @return template
     */
    public function setDsTitulo($dsTitulo)
    {
        $this->dsTitulo = $dsTitulo;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCdTemplate()
    {
        return $this->cdTemplate;
    }

    /**
     * @param mixed $cdTemplate
     * @return template
     */
    public function setCdTemplate($cdTemplate)
    {
        $this->cdTemplate = $cdTemplate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmSolicitante()
    {
        return $this->nmSolicitante;
    }

    /**
     * @param mixed $nmSolicitante
     * @return template
     */
    public function setNmSolicitante($nmSolicitante)
    {
        $this->nmSolicitante = $nmSolicitante;
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
     * @return template
     */
    public function setCdSetor($cdSetor)
    {
        $this->cdSetor = $cdSetor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsServico()
    {
        return $this->dsServico;
    }

    /**
     * @param mixed $dsServico
     * @return template
     */
    public function setDsServico($dsServico)
    {
        $this->dsServico = $dsServico;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsObservacao()
    {
        return $this->dsObservacao;
    }

    /**
     * @param mixed $dsObservacao
     * @return template
     */
    public function setDsObservacao($dsObservacao)
    {
        $this->dsObservacao = $dsObservacao;
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
     * @return template
     */
    public function setNmUsuario($nmUsuario)
    {
        $this->nmUsuario = $nmUsuario;
        return $this;
    }



}