<?php

/**
 * Created by PhpStorm.
 * User: carlusuario.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class usuario_list
{
    private $_usuario = array();
    private $_usuarioCount = 0;
    public function __construct() {
    }
    public function getUsuarioCount() {
        return $this->_usuarioCount;
    }
    private function setUsuarioCount($newCount) {
        $this->_usuarioCount = $newCount;
    }
    public function getUsuario($_usuarioNumberToGet) {
        if ( (is_numeric($_usuarioNumberToGet)) &&
            ($_usuarioNumberToGet <= $this->getUsuarioCount())) {
            return $this->_usuario[$_usuarioNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addUsuario(Usuario $_usuario_in) {
        $this->setUsuarioCount($this->getUsuarioCount() + 1);
        $this->_usuario[$this->getUsuarioCount()] = $_usuario_in;
        return $this->getUsuarioCount();
    }
    public function removeUsuario(Usuario $_usuario_in) {
        $counter = 0;
        while (++$counter <= $this->getUsuarioCount()) {
            if ($_usuario_in->getAuthorAndTitle() ==
                $this->_usuario[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getUsuarioCount(); $x++) {
                    $this->_usuario[$x] = $this->_usuario[$x + 1];
                }
                $this->setUsuarioCount($this->getUsuarioCount() - 1);
            }
        }
        return $this->getUsuarioCount();
    }
}