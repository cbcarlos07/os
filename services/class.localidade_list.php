<?php

/**
 * Created by PhpStorm.
 * User: carllocalidade.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class localidade_list
{
    private $_localidade = array();
    private $_localidadeCount = 0;
    public function __construct() {
    }
    public function getLocalidadeCount() {
        return $this->_localidadeCount;
    }
    private function setLocalidadeCount($newCount) {
        $this->_localidadeCount = $newCount;
    }
    public function getLocalidade($_localidadeNumberToGet) {
        if ( (is_numeric($_localidadeNumberToGet)) &&
            ($_localidadeNumberToGet <= $this->getLocalidadeCount())) {
            return $this->_localidade[$_localidadeNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addLocalidade(Localidade $_localidade_in) {
        $this->setLocalidadeCount($this->getLocalidadeCount() + 1);
        $this->_localidade[$this->getLocalidadeCount()] = $_localidade_in;
        return $this->getLocalidadeCount();
    }
    public function removeLocalidade(Localidade $_localidade_in) {
        $counter = 0;
        while (++$counter <= $this->getLocalidadeCount()) {
            if ($_localidade_in->getAuthorAndTitle() ==
                $this->_localidade[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getLocalidadeCount(); $x++) {
                    $this->_localidade[$x] = $this->_localidade[$x + 1];
                }
                $this->setLocalidadeCount($this->getLocalidadeCount() - 1);
            }
        }
        return $this->getLocalidadeCount();
    }
}