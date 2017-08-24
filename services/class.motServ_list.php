<?php

/**
 * Created by PhpStorm.
 * User: carlmotServ.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class motServ_list
{
    private $_motServ = array();
    private $_motServCount = 0;
    public function __construct() {
    }
    public function getMotServCount() {
        return $this->_motServCount;
    }
    private function setMotServCount($newCount) {
        $this->_motServCount = $newCount;
    }
    public function getMotServ($_motServNumberToGet) {
        if ( (is_numeric($_motServNumberToGet)) &&
            ($_motServNumberToGet <= $this->getMotServCount())) {
            return $this->_motServ[$_motServNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addMotServ(MotServ $_motServ_in) {
        $this->setMotServCount($this->getMotServCount() + 1);
        $this->_motServ[$this->getMotServCount()] = $_motServ_in;
        return $this->getMotServCount();
    }
    public function removeMotServ(MotServ $_motServ_in) {
        $counter = 0;
        while (++$counter <= $this->getMotServCount()) {
            if ($_motServ_in->getAuthorAndTitle() ==
                $this->_motServ[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getMotServCount(); $x++) {
                    $this->_motServ[$x] = $this->_motServ[$x + 1];
                }
                $this->setMotServCount($this->getMotServCount() - 1);
            }
        }
        return $this->getMotServCount();
    }
}