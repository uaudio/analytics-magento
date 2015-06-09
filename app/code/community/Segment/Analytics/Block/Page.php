<?php
class Segment_Analytics_Block_Page extends Mage_Core_Block_Template {
    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $contextJson = Mage::helper('analytics')->getContextJson();
		return '<script>document.observe("dom:loaded", function() { window.analytics.page("'.$this->_getCategoryName().'","'.$this->_getTitle().'",{},'.$contextJson.');});</script>';
	}
	
	protected function _getCategoryName() { 
	    return ucfirst($this->getRequest()->getRequestedRouteName());
	}

	protected function _getTitle() {
	    return is_object($this->getLayout()->getBlock('head'))?$this->getLayout()->getBlock('head')->getTitle():'';
	}
}