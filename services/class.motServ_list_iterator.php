<?php

/**
 * Created by PhpStorm.
 * User: carlmotServ.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class motServ_list_iterator
{
    protected $motServList;
    protected $currentMotServ = 0;

    public function __construct(motServ_list $motServList_in) {
        $this->motServList = $motServList_in;
    }
    public function getCurrentMotServ() {
        if (($this->currentMotServ > 0) &&
            ($this->motServList->getMotServCount() >= $this->currentMotServ)) {
            return $this->motServList->getMotServ($this->currentMotServ);
        }
    }
    public function getNextMotServ() {
        if ($this->hasNextMotServ()) {
            return $this->motServList->getMotServ(++$this->currentMotServ);
        } else {
            return NULL;
        }
    }
    public function hasNextMotServ() {
        if ($this->motServList->getMotServCount() > $this->currentMotServ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}