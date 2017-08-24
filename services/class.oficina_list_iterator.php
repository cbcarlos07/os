<?php

/**
 * Created by PhpStorm.
 * User: carloficina.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class oficina_list_iterator
{
    protected $oficinaList;
    protected $currentOficina = 0;

    public function __construct(oficina_list $oficinaList_in) {
        $this->oficinaList = $oficinaList_in;
    }
    public function getCurrentOficina() {
        if (($this->currentOficina > 0) &&
            ($this->oficinaList->getOficinaCount() >= $this->currentOficina)) {
            return $this->oficinaList->getOficina($this->currentOficina);
        }
    }
    public function getNextOficina() {
        if ($this->hasNextOficina()) {
            return $this->oficinaList->getOficina(++$this->currentOficina);
        } else {
            return NULL;
        }
    }
    public function hasNextOficina() {
        if ($this->oficinaList->getOficinaCount() > $this->currentOficina) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}