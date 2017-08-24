<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 07/07/2017
 * Time: 12:15
 */
class tipo_os
{
    private $cd_Tipo_Os;
    private $descricao;

    /**
     * @return mixed
     */
    public function getCdTipoOs()
    {
        return $this->cd_Tipo_Os;
    }

    /**
     * @param mixed $cd_Tipo_Os
     * @return tipo_os
     */
    public function setCdTipoOs($cd_Tipo_Os)
    {
        $this->cd_Tipo_Os = $cd_Tipo_Os;
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
     * @return tipo_os
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }


}