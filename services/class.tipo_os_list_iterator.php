<?php

/**
 * Created by PhpStorm.
 * User: carltipo_os.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class tipo_os_list_iterator
{
    protected $tipo_osList;
    protected $currentTipo_Os = 0;

    public function __construct(tipo_os_list $tipo_osList_in) {
        $this->tipo_osList = $tipo_osList_in;
    }
    public function getCurrentTipo_Os() {
        if (($this->currentTipo_Os > 0) &&
            ($this->tipo_osList->getTipo_OsCount() >= $this->currentTipo_Os)) {
            return $this->tipo_osList->getTipo_Os($this->currentTipo_Os);
        }
    }
    public function getNextTipo_Os() {
        if ($this->hasNextTipo_Os()) {
            return $this->tipo_osList->getTipo_Os(++$this->currentTipo_Os);
        } else {
            return NULL;
        }
    }
    public function hasNextTipo_Os() {
        if ($this->tipo_osList->getTipo_OsCount() > $this->currentTipo_Os) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}