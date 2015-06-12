<?php
class Segment_Analytics_Block_Loggedout extends Mage_Core_Block_Template {
	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $contextJson = Mage::helper('analytics')->getContextJson();
        Mage::unregister('segment_data');
		return '<script>document.observe("dom:loaded", function() { window.analytics.track(\'Logged Out\',{},'.$contextJson.');});</script>';
	}
}