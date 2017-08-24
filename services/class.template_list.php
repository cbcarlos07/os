<?php

/**
 * Created by PhpStorm.
 * User: carltemplate.bruno
 * Date: 19/06/2017
 * Time: 16:42
 */
class template_list
{
    private $_template = array();
    private $_templateCount = 0;
    public function __construct() {
    }
    public function getTemplateCount() {
        return $this->_templateCount;
    }
    private function setTemplateCount($newCount) {
        $this->_templateCount = $newCount;
    }
    public function getTemplate($_templateNumberToGet) {
        if ( (is_numeric($_templateNumberToGet)) &&
            ($_templateNumberToGet <= $this->getTemplateCount())) {
            return $this->_template[$_templateNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addTemplate( template $_template_in) {
        $this->setTemplateCount($this->getTemplateCount() + 1);
        $this->_template[$this->getTemplateCount()] = $_template_in;
        return $this->getTemplateCount();
    }
    public function removeTemplate( template $_template_in) {
        $counter = 0;
        while (++$counter <= $this->getTemplateCount()) {
            if ($_template_in->getAuthorAndTitle() ==
                $this->_template[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getTemplateCount(); $x++) {
                    $this->_template[$x] = $this->_template[$x + 1];
                }
                $this->setTemplateCount($this->getTemplateCount() - 1);
            }
        }
        return $this->getTemplateCount();
    }
}