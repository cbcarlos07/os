<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 07/07/2017
 * Time: 12:17
 */
class motServ
{
   private $cdMotServ;
   private $dsMotServ;

    /**
     * @return mixed
     */
    public function getCdMotServ()
    {
        return $this->cdMotServ;
    }

    /**
     * @param mixed $cdMotServ
     * @return motServ
     */
    public function setCdMotServ($cdMotServ)
    {
        $this->cdMotServ = $cdMotServ;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsMotServ()
    {
        return $this->dsMotServ;
    }

    /**
     * @param mixed $dsMotServ
     * @return motServ
     */
    public function setDsMotServ($dsMotServ)
    {
        $this->dsMotServ = $dsMotServ;
        return $this;
    }


}