<?php

/**
 * Created by PhpStorm.
 * User: carllocalidade.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class localidade_list_iterator
{
    protected $localidadeList;
    protected $currentLocalidade = 0;

    public function __construct(localidade_list $localidadeList_in) {
        $this->localidadeList = $localidadeList_in;
    }
    public function getCurrentLocalidade() {
        if (($this->currentLocalidade > 0) &&
            ($this->localidadeList->getLocalidadeCount() >= $this->currentLocalidade)) {
            return $this->localidadeList->getLocalidade($this->currentLocalidade);
        }
    }
    public function getNextLocalidade() {
        if ($this->hasNextLocalidade()) {
            return $this->localidadeList->getLocalidade(++$this->currentLocalidade);
        } else {
            return NULL;
        }
    }
    public function hasNextLocalidade() {
        if ($this->localidadeList->getLocalidadeCount() > $this->currentLocalidade) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}