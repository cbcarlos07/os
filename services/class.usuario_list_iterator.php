<?php

/**
 * Created by PhpStorm.
 * User: carlusuario.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class usuario_list_iterator
{
    protected $usuarioList;
    protected $currentUsuario = 0;

    public function __construct(usuario_list $usuarioList_in) {
        $this->usuarioList = $usuarioList_in;
    }
    public function getCurrentUsuario() {
        if (($this->currentUsuario > 0) &&
            ($this->usuarioList->getUsuarioCount() >= $this->currentUsuario)) {
            return $this->usuarioList->getUsuario($this->currentUsuario);
        }
    }
    public function getNextUsuario() {
        if ($this->hasNextUsuario()) {
            return $this->usuarioList->getUsuario(++$this->currentUsuario);
        } else {
            return NULL;
        }
    }
    public function hasNextUsuario() {
        if ($this->usuarioList->getUsuarioCount() > $this->currentUsuario) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}