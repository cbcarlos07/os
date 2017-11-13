<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 19/06/2017
 * Time: 09:26
 */
class os
{
    private $cdOs;
    private $usuario;
    private $especialidade;
    private $tipoOs;
    private $motServ;
    private $oficina;
    private $responsavel;
    private $prioridade;
    private $data_pedido;
    private $hora_pedido;
    private $descricao;
    private $solicitante;
    private $situacao;
    private $setor;
    private $observacao;
    private $data_entrega;
    private $previsao;
    private $resolucao;
    private $dsRamal;
    private $bem;
    private $localidade;

    /**
     * @return mixed
     */
    public function getLocalidade()
    {
        return $this->localidade;
    }

    /**
     * @param mixed $localidade
     * @return os
     */
    public function setLocalidade($localidade)
    {
        $this->localidade = $localidade;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getBem()
    {
        return $this->bem;
    }

    /**
     * @param mixed $bem
     * @return os
     */
    public function setBem( bens $bem)
    {
        $this->bem = $bem;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getDsRamal()
    {
        return $this->dsRamal;
    }

    /**
     * @param mixed $dsRamal
     * @return os
     */
    public function setDsRamal($dsRamal)
    {
        $this->dsRamal = $dsRamal;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getResolucao()
    {
        return $this->resolucao;
    }

    /**
     * @param mixed $resolucao
     * @return os
     */
    public function setResolucao($resolucao)
    {
        $this->resolucao = $resolucao;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getPrevisao()
    {
        return $this->previsao;
    }

    /**
     * @param mixed $previsao
     * @return os
     */
    public function setPrevisao($previsao)
    {
        $this->previsao = $previsao;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getDataEntrega()
    {
        return $this->data_entrega;
    }

    /**
     * @param mixed $data_entrega
     * @return os
     */
    public function setDataEntrega($data_entrega)
    {
        $this->data_entrega = $data_entrega;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * @param mixed $observacao
     * @return os
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
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
     * @return os
     */
    public function setCdOs($cdOs)
    {
        $this->cdOs = $cdOs;
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
     * @return os
     */
    public function setUsuario(usuario $usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEspecialidade()
    {
        return $this->especialidade;
    }

    /**
     * @param mixed $especialidade
     * @return os
     */
    public function setEspecialidade( manuEspec $especialidade)
    {
        $this->especialidade = $especialidade;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoOs()
    {
        return $this->tipoOs;
    }

    /**
     * @param mixed $tipoOs
     * @return os
     */
    public function setTipoOs( tipo_os $tipoOs)
    {
        $this->tipoOs = $tipoOs;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getMotServ()
    {
        return $this->motServ;
    }

    /**
     * @param mixed $motServ
     * @return os
     */
    public function setMotServ(motServ $motServ)
    {
        $this->motServ = $motServ;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOficina()
    {
        return $this->oficina;
    }

    /**
     * @param mixed $oficina
     * @return os
     */
    public function setOficina( oficina $oficina)
    {
        $this->oficina = $oficina;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponsavel()
    {
        return $this->responsavel;
    }

    /**
     * @param mixed $responsavel
     * @return os
     */
    public function setResponsavel( usuario  $responsavel)
    {
        $this->responsavel = $responsavel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrioridade()
    {
        return $this->prioridade;
    }

    /**
     * @param mixed $prioridade
     * @return os
     */
    public function setPrioridade($prioridade)
    {
        $this->prioridade = $prioridade;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataPedido()
    {
        return $this->data_pedido;
    }

    /**
     * @param mixed $data_pedido
     * @return os
     */
    public function setDataPedido($data_pedido)
    {
        $this->data_pedido = $data_pedido;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHoraPedido()
    {
        return $this->hora_pedido;
    }

    /**
     * @param mixed $hora_pedido
     * @return os
     */
    public function setHoraPedido($hora_pedido)
    {
        $this->hora_pedido = $hora_pedido;
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
     * @return os
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * @param mixed $solicitante
     * @return os
     */
    public function setSolicitante(usuario $solicitante)
    {
        $this->solicitante = $solicitante;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param mixed $situacao
     * @return os
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
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
     * @return os
     */
    public function setSetor(setor $setor)
    {
        $this->setor = $setor;
        return $this;
    }





}