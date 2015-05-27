<?php
class Segment_Analytics_Block_Additional extends Mage_Core_Block_Template {
    public $actions = array();
    public $deferredActions = array();
    
    public function __construct() {
        $this->actions = Mage::getModel('segment_analytics/observer')->getActions();
        $this->deferredActions = Mage::getModel('segment_analytics/observer')->getDeferredActions();
        Mage::getModel('segment_analytics/observer')->clearDeferredActions();
    }

	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
	    $script = '';
	    foreach ($this->deferredActions as $action) {
	        Mage::register('segment_data',$action->data);
	        $script .= Mage::app()->getLayout()->createBlock('analytics/' . $action->action)->toHtml();
	    }
	    foreach ($this->actions as $action) {
	        Mage::register('segment_data',$action->data);
	        $script .= Mage::app()->getLayout()->createBlock('analytics/' . $action->action)->toHtml();
	    }
	    return $script;
	}
}
