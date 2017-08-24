<?php

/**
 * Created by PhpStorm.
 * User: carlsetor.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class setor_list_iterator
{
    protected $setorList;
    protected $currentSetor = 0;

    public function __construct(setor_list $setorList_in) {
        $this->setorList = $setorList_in;
    }
    public function getCurrentSetor() {
        if (($this->currentSetor > 0) &&
            ($this->setorList->getSetorCount() >= $this->currentSetor)) {
            return $this->setorList->getSetor($this->currentSetor);
        }
    }
    public function getNextSetor() {
        if ($this->hasNextSetor()) {
            return $this->setorList->getSetor(++$this->currentSetor);
        } else {
            return NULL;
        }
    }
    public function hasNextSetor() {
        if ($this->setorList->getSetorCount() > $this->currentSetor) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}