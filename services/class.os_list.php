<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class os_list
{
    private $_os = array();
    private $_osCount = 0;
    public function __construct() {
    }
    public function getOsCount() {
        return $this->_osCount;
    }
    private function setOsCount($newCount) {
        $this->_osCount = $newCount;
    }
    public function getOs($_osNumberToGet) {
        if ( (is_numeric($_osNumberToGet)) &&
            ($_osNumberToGet <= $this->getOsCount())) {
            return $this->_os[$_osNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addOs(Os $_os_in) {
        $this->setOsCount($this->getOsCount() + 1);
        $this->_os[$this->getOsCount()] = $_os_in;
        return $this->getOsCount();
    }
    public function removeOs(Os $_os_in) {
        $counter = 0;
        while (++$counter <= $this->getOsCount()) {
            if ($_os_in->getAuthorAndTitle() ==
                $this->_os[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getOsCount(); $x++) {
                    $this->_os[$x] = $this->_os[$x + 1];
                }
                $this->setOsCount($this->getOsCount() - 1);
            }
        }
        return $this->getOsCount();
    }
}