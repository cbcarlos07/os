<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class os_list_iterator
{
    protected $osList;
    protected $currentOs = 0;

    public function __construct(os_list $osList_in) {
        $this->osList = $osList_in;
    }
    public function getCurrentOs() {
        if (($this->currentOs > 0) &&
            ($this->osList->getOsCount() >= $this->currentOs)) {
            return $this->osList->getOs($this->currentOs);
        }
    }
    public function getNextOs() {
        if ($this->hasNextOs()) {
            return $this->osList->getOs(++$this->currentOs);
        } else {
            return NULL;
        }
    }
    public function hasNextOs() {
        if ($this->osList->getOsCount() > $this->currentOs) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}