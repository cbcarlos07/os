<?php

/**
 * Created by PhpStorm.
 * User: carlfuncionario.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class funcionario_list
{
    private $_funcionario = array();
    private $_funcionarioCount = 0;
    public function __construct() {
    }
    public function getFuncionarioCount() {
        return $this->_funcionarioCount;
    }
    private function setFuncionarioCount($newCount) {
        $this->_funcionarioCount = $newCount;
    }
    public function getFuncionario($_funcionarioNumberToGet) {
        if ( (is_numeric($_funcionarioNumberToGet)) &&
            ($_funcionarioNumberToGet <= $this->getFuncionarioCount())) {
            return $this->_funcionario[$_funcionarioNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addFuncionario(funcionario $_funcionario_in) {
        $this->setFuncionarioCount($this->getFuncionarioCount() + 1);
        $this->_funcionario[$this->getFuncionarioCount()] = $_funcionario_in;
        return $this->getFuncionarioCount();
    }
    public function removeFuncionario(funcionario $_funcionario_in) {
        $counter = 0;
        while (++$counter <= $this->getFuncionarioCount()) {
            if ($_funcionario_in->getAuthorAndTitle() ==
                $this->_funcionario[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getFuncionarioCount(); $x++) {
                    $this->_funcionario[$x] = $this->_funcionario[$x + 1];
                }
                $this->setFuncionarioCount($this->getFuncionarioCount() - 1);
            }
        }
        return $this->getFuncionarioCount();
    }
}