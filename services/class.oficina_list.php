<?php

/**
 * Created by PhpStorm.
 * User: carloficina.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class oficina_list
{
    private $_oficina = array();
    private $_oficinaCount = 0;
    public function __construct() {
    }
    public function getOficinaCount() {
        return $this->_oficinaCount;
    }
    private function setOficinaCount($newCount) {
        $this->_oficinaCount = $newCount;
    }
    public function getOficina($_oficinaNumberToGet) {
        if ( (is_numeric($_oficinaNumberToGet)) &&
            ($_oficinaNumberToGet <= $this->getOficinaCount())) {
            return $this->_oficina[$_oficinaNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addOficina(Oficina $_oficina_in) {
        $this->setOficinaCount($this->getOficinaCount() + 1);
        $this->_oficina[$this->getOficinaCount()] = $_oficina_in;
        return $this->getOficinaCount();
    }
    public function removeOficina(Oficina $_oficina_in) {
        $counter = 0;
        while (++$counter <= $this->getOficinaCount()) {
            if ($_oficina_in->getAuthorAndTitle() ==
                $this->_oficina[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getOficinaCount(); $x++) {
                    $this->_oficina[$x] = $this->_oficina[$x + 1];
                }
                $this->setOficinaCount($this->getOficinaCount() - 1);
            }
        }
        return $this->getOficinaCount();
    }
}