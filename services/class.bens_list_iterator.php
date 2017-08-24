<?php

/**
 * Created by PhpStorm.
 * User: carlbens.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class bens_list_iterator
{
    protected $bensList;
    protected $currentBens = 0;

    public function __construct(bens_list $bensList_in) {
        $this->bensList = $bensList_in;
    }
    public function getCurrentBens() {
        if (($this->currentBens > 0) &&
            ($this->bensList->getBensCount() >= $this->currentBens)) {
            return $this->bensList->getBens($this->currentBens);
        }
    }
    public function getNextBens() {
        if ($this->hasNextBens()) {
            return $this->bensList->getBens(++$this->currentBens);
        } else {
            return NULL;
        }
    }
    public function hasNextBens() {
        if ($this->bensList->getBensCount() > $this->currentBens) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}