<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 26/03/18
 * Time: 09:11
 */

class fabricante
{
   private $cdFabricante;
   private $nmFabricante;

    /**
     * @return mixed
     */
    public function getCdFabricante()
    {
        return $this->cdFabricante;
    }

    /**
     * @param mixed $cdFabricante
     * @return fabricante
     */
    public function setCdFabricante($cdFabricante)
    {
        $this->cdFabricante = $cdFabricante;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmFabricante()
    {
        return $this->nmFabricante;
    }

    /**
     * @param mixed $nmFabricante
     * @return fabricante
     */
    public function setNmFabricante($nmFabricante)
    {
        $this->nmFabricante = $nmFabricante;
        return $this;
    }


}