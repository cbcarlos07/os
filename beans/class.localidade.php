<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 07/03/2018
 * Time: 11:53
 */

class localidade
{
    private $cdLocalidade;
    private $dsLocalidade;

    /**
     * @return mixed
     */
    public function getCdLocalidade()
    {
        return $this->cdLocalidade;
    }

    /**
     * @param mixed $cdLocalidade
     * @return localidade
     */
    public function setCdLocalidade($cdLocalidade)
    {
        $this->cdLocalidade = $cdLocalidade;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsLocalidade()
    {
        return $this->dsLocalidade;
    }

    /**
     * @param mixed $dsLocalidade
     * @return localidade
     */
    public function setDsLocalidade($dsLocalidade)
    {
        $this->dsLocalidade = $dsLocalidade;
        return $this;
    }


}