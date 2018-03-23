<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 23/03/18
 * Time: 11:11
 */

class tipo
{
  private $cdTipoEquipamento;
  private $dsTipoEquipamento;

    /**
     * @return mixed
     */
    public function getCdTipoEquipamento()
    {
        return $this->cdTipoEquipamento;
    }

    /**
     * @param mixed $cdTipoEquipamento
     * @return tipo
     */
    public function setCdTipoEquipamento($cdTipoEquipamento)
    {
        $this->cdTipoEquipamento = $cdTipoEquipamento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsTipoEquipamento()
    {
        return $this->dsTipoEquipamento;
    }

    /**
     * @param mixed $dsTipoEquipamento
     * @return tipo
     */
    public function setDsTipoEquipamento($dsTipoEquipamento)
    {
        $this->dsTipoEquipamento = $dsTipoEquipamento;
        return $this;
    }


}