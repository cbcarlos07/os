<?php

/**
 * Created by PhpStorm.
 * User: carltemplate.bruno
 * Date: 19/06/2017
 * Time: 16:43
 */
class template_list_iterator
{
    protected $templateList;
    protected $currentTemplate = 0;

    public function __construct(template_list $templateList_in) {
        $this->templateList = $templateList_in;
    }
    public function getCurrentTemplate() {
        if (($this->currentTemplate > 0) &&
            ($this->templateList->getTemplateCount() >= $this->currentTemplate)) {
            return $this->templateList->getTemplate($this->currentTemplate);
        }
    }
    public function getNextTemplate() {
        if ($this->hasNextTemplate()) {
            return $this->templateList->getTemplate(++$this->currentTemplate);
        } else {
            return NULL;
        }
    }
    public function hasNextTemplate() {
        if ($this->templateList->getTemplateCount() > $this->currentTemplate) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}