<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 14/11/2017
 * Time: 08:34
 */

class solicitacaoServicoOS
{
   private $cdOs;
   private $cdSolicitacaoDoc;
   private $dsSolicitacaoDoc;
   private $loAnexoSolicitacao;

    /**
     * @return mixed
     */
    public function getCdOs()
    {
        return $this->cdOs;
    }

    /**
     * @param mixed $cdOs
     * @return SolicitacaoServicoOS
     */
    public function setCdOs($cdOs)
    {
        $this->cdOs = $cdOs;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCdSolicitacaoDoc()
    {
        return $this->cdSolicitacaoDoc;
    }

    /**
     * @param mixed $cdSolicitacaoDoc
     * @return SolicitacaoServicoOS
     */
    public function setCdSolicitacaoDoc($cdSolicitacaoDoc)
    {
        $this->cdSolicitacaoDoc = $cdSolicitacaoDoc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsSolicitacaoDoc()
    {
        return $this->dsSolicitacaoDoc;
    }

    /**
     * @param mixed $dsSolicitacaoDoc
     * @return SolicitacaoServicoOS
     */
    public function setDsSolicitacaoDoc($dsSolicitacaoDoc)
    {
        $this->dsSolicitacaoDoc = $dsSolicitacaoDoc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLoAnexoSolicitacao()
    {
        return $this->loAnexoSolicitacao;
    }

    /**
     * @param mixed $loAnexoSolicitacao
     * @return SolicitacaoServicoOS
     */
    public function setLoAnexoSolicitacao($loAnexoSolicitacao)
    {
        $this->loAnexoSolicitacao = $loAnexoSolicitacao;
        return $this;
    }


}