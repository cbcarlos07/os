<?php

/**
 * Created by PhpStorm.
 * User: carlmanuEspec.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class manuEspec_list_iterator
{
    protected $manuEspecList;
    protected $currentManuEspec = 0;

    public function __construct(manuEspec_list $manuEspecList_in) {
        $this->manuEspecList = $manuEspecList_in;
    }
    public function getCurrentManuEspec() {
        if (($this->currentManuEspec > 0) &&
            ($this->manuEspecList->getManuEspecCount() >= $this->currentManuEspec)) {
            return $this->manuEspecList->getManuEspec($this->currentManuEspec);
        }
    }
    public function getNextManuEspec() {
        if ($this->hasNextManuEspec()) {
            return $this->manuEspecList->getManuEspec(++$this->currentManuEspec);
        } else {
            return NULL;
        }
    }
    public function hasNextManuEspec() {
        if ($this->manuEspecList->getManuEspecCount() > $this->currentManuEspec) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}