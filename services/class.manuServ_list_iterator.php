<?php

/**
 * Created by PhpStorm.
 * User: carlmanuServ.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class manuServ_list_iterator
{
    protected $manuServList;
    protected $currentManuServ = 0;

    public function __construct(manuServ_list $manuServList_in) {
        $this->manuServList = $manuServList_in;
    }
    public function getCurrentManuServ() {
        if (($this->currentManuServ > 0) &&
            ($this->manuServList->getManuServCount() >= $this->currentManuServ)) {
            return $this->manuServList->getManuServ($this->currentManuServ);
        }
    }
    public function getNextManuServ() {
        if ($this->hasNextManuServ()) {
            return $this->manuServList->getManuServ(++$this->currentManuServ);
        } else {
            return NULL;
        }
    }
    public function hasNextManuServ() {
        if ($this->manuServList->getManuServCount() > $this->currentManuServ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}