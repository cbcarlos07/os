<?php

/**
 * Created by PhpStorm.
 * User: carlitemSolicitacaoServico.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class itemSolicitacaoServico_list_iterator
{
    protected $itemSolicitacaoServicoList;
    protected $currentItemSolicitacaoServico = 0;

    public function __construct(itemSolicitacaoServico_list $itemSolicitacaoServicoList_in) {
        $this->itemSolicitacaoServicoList = $itemSolicitacaoServicoList_in;
    }
    public function getCurrentItemSolicitacaoServico() {
        if (($this->currentItemSolicitacaoServico > 0) &&
            ($this->itemSolicitacaoServicoList->getItemSolicitacaoServicoCount() >= $this->currentItemSolicitacaoServico)) {
            return $this->itemSolicitacaoServicoList->getItemSolicitacaoServico($this->currentItemSolicitacaoServico);
        }
    }
    public function getNextItemSolicitacaoServico() {
        if ($this->hasNextItemSolicitacaoServico()) {
            return $this->itemSolicitacaoServicoList->getItemSolicitacaoServico(++$this->currentItemSolicitacaoServico);
        } else {
            return NULL;
        }
    }
    public function hasNextItemSolicitacaoServico() {
        if ($this->itemSolicitacaoServicoList->getItemSolicitacaoServicoCount() > $this->currentItemSolicitacaoServico) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}