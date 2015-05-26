<?php
class Segment_Analytics_Block_Additional extends Mage_Core_Block_Template {
    public $actions;
    
    public function __construct() {
        $this->actions = Mage::getModel('segment_analytics/observer')->getDeferredActions();
        Mage::getModel('segment_analytics/observer')->clearDeferredActions();
    }

	public function _toHtml() {
	    $script = '';
	    foreach ($this->actions as $action) {
	        $script .= Mage::app()->getLayout()->createBlock('analytics/' . $action->action)->toHtml();
	    }
	    return $script;
	}
}
