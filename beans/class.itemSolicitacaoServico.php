<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 12/07/2017
 * Time: 15:54
 */
class itemSolicitacaoServico
{
    private $cdItem;
    private $cdOs;
    private $manuServ;
    private $funcionario;
    private $snFeito;
    private $dataInicial;
    private $horaInicial;
    private $dataFinal;
    private $horaFinal;
    private $tempoHora;
    private $tempoMinuto;
    private $tempo;
    private $descricao;
    private $chamado;
    private $responsavel;

    /**
     * @return mixed
     */
    public function getResponsavel()
    {
        return $this->responsavel;
    }

    /**
     * @param mixed $responsavel
     * @return itemSolicitacaoServico
     */
    public function setResponsavel($responsavel)
    {
        $this->responsavel = $responsavel;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getChamado()
    {
        return $this->chamado;
    }

    /**
     * @param mixed $chamado
     * @return itemSolicitacaoServico
     */
    public function setChamado($chamado)
    {
        $this->chamado = $chamado;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     * @return itemSolicitacaoServico
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getCdItem()
    {
        return $this->cdItem;
    }

    /**
     * @param mixed $cdItem
     * @return itemSolicitacaoServico
     */
    public function setCdItem($cdItem)
    {
        $this->cdItem = $cdItem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCdOs()
    {
        return $this->cdOs;
    }

    /**
     * @param mixed $cdOs
     * @return itemSolicitacaoServico
     */
    public function setCdOs( $cdOs)
    {
        $this->cdOs = $cdOs;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getManuServ()
    {
        return $this->manuServ;
    }

    /**
     * @param mixed $manuServ
     * @return itemSolicitacaoServico
     */
    public function setManuServ(manuServ $manuServ)
    {
        $this->manuServ = $manuServ;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }

    /**
     * @param mixed $funcionario
     * @return itemSolicitacaoServico
     */
    public function setFuncionario(funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSnFeito()
    {
        return $this->snFeito;
    }

    /**
     * @param mixed $snFeito
     * @return itemSolicitacaoServico
     */
    public function setSnFeito($snFeito)
    {
        $this->snFeito = $snFeito;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataInicial()
    {
        return $this->dataInicial;
    }

    /**
     * @param mixed $dataInicial
     * @return itemSolicitacaoServico
     */
    public function setDataInicial($dataInicial)
    {
        $this->dataInicial = $dataInicial;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHoraInicial()
    {
        return $this->horaInicial;
    }

    /**
     * @param mixed $horaInicial
     * @return itemSolicitacaoServico
     */
    public function setHoraInicial($horaInicial)
    {
        $this->horaInicial = $horaInicial;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     * @param mixed $dataFinal
     * @return itemSolicitacaoServico
     */
    public function setDataFinal($dataFinal)
    {
        $this->dataFinal = $dataFinal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHoraFinal()
    {
        return $this->horaFinal;
    }

    /**
     * @param mixed $horaFinal
     * @return itemSolicitacaoServico
     */
    public function setHoraFinal($horaFinal)
    {
        $this->horaFinal = $horaFinal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempoHora()
    {
        return $this->tempoHora;
    }

    /**
     * @param mixed $tempoHora
     * @return itemSolicitacaoServico
     */
    public function setTempoHora($tempoHora)
    {
        $this->tempoHora = $tempoHora;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempoMinuto()
    {
        return $this->tempoMinuto;
    }

    /**
     * @param mixed $tempoMinuto
     * @return itemSolicitacaoServico
     */
    public function setTempoMinuto($tempoMinuto)
    {
        $this->tempoMinuto = $tempoMinuto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempo()
    {
        return $this->tempo;
    }

    /**
     * @param mixed $tempo
     * @return itemSolicitacaoServico
     */
    public function setTempo($tempo)
    {
        $this->tempo = $tempo;
        return $this;
    }



}