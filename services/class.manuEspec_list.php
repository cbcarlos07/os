<?php

/**
 * Created by PhpStorm.
 * User: carlmanuEspec.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class manuEspec_list
{
    private $_manuEspec = array();
    private $_manuEspecCount = 0;
    public function __construct() {
    }
    public function getManuEspecCount() {
        return $this->_manuEspecCount;
    }
    private function setManuEspecCount($newCount) {
        $this->_manuEspecCount = $newCount;
    }
    public function getManuEspec($_manuEspecNumberToGet) {
        if ( (is_numeric($_manuEspecNumberToGet)) &&
            ($_manuEspecNumberToGet <= $this->getManuEspecCount())) {
            return $this->_manuEspec[$_manuEspecNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addManuEspec(ManuEspec $_manuEspec_in) {
        $this->setManuEspecCount($this->getManuEspecCount() + 1);
        $this->_manuEspec[$this->getManuEspecCount()] = $_manuEspec_in;
        return $this->getManuEspecCount();
    }
    public function removeManuEspec(ManuEspec $_manuEspec_in) {
        $counter = 0;
        while (++$counter <= $this->getManuEspecCount()) {
            if ($_manuEspec_in->getAuthorAndTitle() ==
                $this->_manuEspec[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getManuEspecCount(); $x++) {
                    $this->_manuEspec[$x] = $this->_manuEspec[$x + 1];
                }
                $this->setManuEspecCount($this->getManuEspecCount() - 1);
            }
        }
        return $this->getManuEspecCount();
    }
}