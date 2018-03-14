<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 14/03/2018
 * Time: 09:14
 */

class fornecedor
{
    private $cdFornecedor;
    private $nmFornecedor;
    private $nmFantasia;
    private $dsSigla;

    /**
     * @return mixed
     */
    public function getDsSigla()
    {
        return $this->dsSigla;
    }

    /**
     * @param mixed $dsSigla
     * @return fornecedor
     */
    public function setDsSigla($dsSigla)
    {
        $this->dsSigla = $dsSigla;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getCdFornecedor()
    {
        return $this->cdFornecedor;
    }

    /**
     * @param mixed $cdFornecedor
     * @return fornecedor
     */
    public function setCdFornecedor($cdFornecedor)
    {
        $this->cdFornecedor = $cdFornecedor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmFornecedor()
    {
        return $this->nmFornecedor;
    }

    /**
     * @param mixed $nmFornecedor
     * @return fornecedor
     */
    public function setNmFornecedor($nmFornecedor)
    {
        $this->nmFornecedor = $nmFornecedor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmFantasia()
    {
        return $this->nmFantasia;
    }

    /**
     * @param mixed $nmFantasia
     * @return fornecedor
     */
    public function setNmFantasia($nmFantasia)
    {
        $this->nmFantasia = $nmFantasia;
        return $this;
    }


}