<?php

/**
 * Created by PhpStorm.
 * User: carlitemSolicitacaoServico.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class itemSolicitacaoServico_list
{
    private $_itemSolicitacaoServico = array();
    private $_itemSolicitacaoServicoCount = 0;
    public function __construct() {
    }
    public function getItemSolicitacaoServicoCount() {
        return $this->_itemSolicitacaoServicoCount;
    }
    private function setItemSolicitacaoServicoCount($newCount) {
        $this->_itemSolicitacaoServicoCount = $newCount;
    }
    public function getItemSolicitacaoServico($_itemSolicitacaoServicoNumberToGet) {
        if ( (is_numeric($_itemSolicitacaoServicoNumberToGet)) &&
            ($_itemSolicitacaoServicoNumberToGet <= $this->getItemSolicitacaoServicoCount())) {
            return $this->_itemSolicitacaoServico[$_itemSolicitacaoServicoNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addItemSolicitacaoServico(itemSolicitacaoServico $_itemSolicitacaoServico_in) {
        $this->setItemSolicitacaoServicoCount($this->getItemSolicitacaoServicoCount() + 1);
        $this->_itemSolicitacaoServico[$this->getItemSolicitacaoServicoCount()] = $_itemSolicitacaoServico_in;
        return $this->getItemSolicitacaoServicoCount();
    }
    public function removeItemSolicitacaoServico(itemSolicitacaoServico $_itemSolicitacaoServico_in) {
        $counter = 0;
        while (++$counter <= $this->getItemSolicitacaoServicoCount()) {
            if ($_itemSolicitacaoServico_in->getAuthorAndTitle() ==
                $this->_itemSolicitacaoServico[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getItemSolicitacaoServicoCount(); $x++) {
                    $this->_itemSolicitacaoServico[$x] = $this->_itemSolicitacaoServico[$x + 1];
                }
                $this->setItemSolicitacaoServicoCount($this->getItemSolicitacaoServicoCount() - 1);
            }
        }
        return $this->getItemSolicitacaoServicoCount();
    }
}