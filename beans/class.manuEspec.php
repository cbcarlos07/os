<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 07/07/2017
 * Time: 12:12
 */
class manuEspec
{
    private $cdEspec;
    private $dsEspec;

    /**
     * @return mixed
     */
    public function getCdEspec()
    {
        return $this->cdEspec;
    }

    /**
     * @param mixed $cdEspec
     * @return manuEspec
     */
    public function setCdEspec($cdEspec)
    {
        $this->cdEspec = $cdEspec;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsEspec()
    {
        return $this->dsEspec;
    }

    /**
     * @param mixed $dsEspec
     * @return manuEspec
     */
    public function setDsEspec($dsEspec)
    {
        $this->dsEspec = $dsEspec;
        return $this;
    }

}