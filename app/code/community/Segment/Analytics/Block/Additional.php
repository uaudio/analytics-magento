<?php
class Segment_Analytics_Block_Additional extends Mage_Core_Block_Template {
    public $actions = array();
    
    public function __construct() {
        $this->actions = array_merge(Mage::getModel('segment_analytics/observer')->getActions(),Mage::getModel('segment_analytics/observer')->getDeferredActions());
        Mage::getModel('segment_analytics/observer')->clearDeferredActions();
    }

	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
	    $script = '';
	    foreach ($this->actions as $action) {
	        if (file_exists(__DIR__.'/'.ucfirst($action->action).'.php')) {
	            Mage::register('segment_data',$action->data);
	            $script .= Mage::app()->getLayout()->createBlock('segment_analytics/' . $action->action)->toHtml();
	        }
	    }
	    return $script;
	}
}
