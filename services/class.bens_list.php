<?php

/**
 * Created by PhpStorm.
 * User: carlbens.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class bens_list
{
    private $_bens = array();
    private $_bensCount = 0;
    public function __construct() {
    }
    public function getBensCount() {
        return $this->_bensCount;
    }
    private function setBensCount($newCount) {
        $this->_bensCount = $newCount;
    }
    public function getBens($_bensNumberToGet) {
        if ( (is_numeric($_bensNumberToGet)) &&
            ($_bensNumberToGet <= $this->getBensCount())) {
            return $this->_bens[$_bensNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addBens(Bens $_bens_in) {
        $this->setBensCount($this->getBensCount() + 1);
        $this->_bens[$this->getBensCount()] = $_bens_in;
        return $this->getBensCount();
    }
    public function removeBens(Bens $_bens_in) {
        $counter = 0;
        while (++$counter <= $this->getBensCount()) {
            if ($_bens_in->getAuthorAndTitle() ==
                $this->_bens[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getBensCount(); $x++) {
                    $this->_bens[$x] = $this->_bens[$x + 1];
                }
                $this->setBensCount($this->getBensCount() - 1);
            }
        }
        return $this->getBensCount();
    }
}