<?php
class Segment_Analytics_Block_Page extends Mage_Core_Block_Template {
    public function _toHtml() {
		return '<script>document.observe("dom:loaded", function() { window.analytics.page("'.(is_object($this->getLayout()->getBlock('head'))?$this->getLayout()->getBlock('head')->getTitle():'').'");});</script>';
	}
}