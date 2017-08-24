<?php

/**
 * Created by PhpStorm.
 * User: carlfuncionario.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class funcionario_list_iterator
{
    protected $funcionarioList;
    protected $currentFuncionario = 0;

    public function __construct(funcionario_list $funcionarioList_in) {
        $this->funcionarioList = $funcionarioList_in;
    }
    public function getCurrentFuncionario() {
        if (($this->currentFuncionario > 0) &&
            ($this->funcionarioList->getFuncionarioCount() >= $this->currentFuncionario)) {
            return $this->funcionarioList->getFuncionario($this->currentFuncionario);
        }
    }
    public function getNextFuncionario() {
        if ($this->hasNextFuncionario()) {
            return $this->funcionarioList->getFuncionario(++$this->currentFuncionario);
        } else {
            return NULL;
        }
    }
    public function hasNextFuncionario() {
        if ($this->funcionarioList->getFuncionarioCount() > $this->currentFuncionario) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}