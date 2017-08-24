<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 05/07/2017
 * Time: 11:35
 */
class setor
{
private $cdSetor;
private $nmSetor;

    /**
     * @return mixed
     */
    public function getCdSetor()
    {
        return $this->cdSetor;
    }

    /**
     * @param mixed $cdSetor
     * @return setor
     */
    public function setCdSetor($cdSetor)
    {
        $this->cdSetor = $cdSetor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmSetor()
    {
        return $this->nmSetor;
    }

    /**
     * @param mixed $nmSetor
     * @return setor
     */
    public function setNmSetor($nmSetor)
    {
        $this->nmSetor = $nmSetor;
        return $this;
    }


}