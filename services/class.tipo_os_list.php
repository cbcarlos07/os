<?php

/**
 * Created by PhpStorm.
 * User: carltipo_os.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class tipo_os_list
{
    private $_tipo_os = array();
    private $_tipo_osCount = 0;
    public function __construct() {
    }
    public function getTipo_OsCount() {
        return $this->_tipo_osCount;
    }
    private function setTipo_OsCount($newCount) {
        $this->_tipo_osCount = $newCount;
    }
    public function getTipo_Os($_tipo_osNumberToGet) {
        if ( (is_numeric($_tipo_osNumberToGet)) &&
            ($_tipo_osNumberToGet <= $this->getTipo_OsCount())) {
            return $this->_tipo_os[$_tipo_osNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addTipo_Os(Tipo_Os $_tipo_os_in) {
        $this->setTipo_OsCount($this->getTipo_OsCount() + 1);
        $this->_tipo_os[$this->getTipo_OsCount()] = $_tipo_os_in;
        return $this->getTipo_OsCount();
    }
    public function removeTipo_Os(Tipo_Os $_tipo_os_in) {
        $counter = 0;
        while (++$counter <= $this->getTipo_OsCount()) {
            if ($_tipo_os_in->getAuthorAndTitle() ==
                $this->_tipo_os[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getTipo_OsCount(); $x++) {
                    $this->_tipo_os[$x] = $this->_tipo_os[$x + 1];
                }
                $this->setTipo_OsCount($this->getTipo_OsCount() - 1);
            }
        }
        return $this->getTipo_OsCount();
    }
}