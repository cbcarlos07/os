<?php

/**
 * Created by PhpStorm.
 * User: carlmanuServ.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class manuServ_list
{
    private $_manuServ = array();
    private $_manuServCount = 0;
    public function __construct() {
    }
    public function getManuServCount() {
        return $this->_manuServCount;
    }
    private function setManuServCount($newCount) {
        $this->_manuServCount = $newCount;
    }
    public function getManuServ($_manuServNumberToGet) {
        if ( (is_numeric($_manuServNumberToGet)) &&
            ($_manuServNumberToGet <= $this->getManuServCount())) {
            return $this->_manuServ[$_manuServNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addManuServ(ManuServ $_manuServ_in) {
        $this->setManuServCount($this->getManuServCount() + 1);
        $this->_manuServ[$this->getManuServCount()] = $_manuServ_in;
        return $this->getManuServCount();
    }
    public function removeManuServ(ManuServ $_manuServ_in) {
        $counter = 0;
        while (++$counter <= $this->getManuServCount()) {
            if ($_manuServ_in->getAuthorAndTitle() ==
                $this->_manuServ[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getManuServCount(); $x++) {
                    $this->_manuServ[$x] = $this->_manuServ[$x + 1];
                }
                $this->setManuServCount($this->getManuServCount() - 1);
            }
        }
        return $this->getManuServCount();
    }
}