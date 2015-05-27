<?php
class Segment_Analytics_Block_Loggedin extends Mage_Core_Block_Template {
	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
		return '<script>alert('.time().'); document.observe("dom:loaded", function() { window.analytics.track(\'Logged In\',{});});</script>';
	}
}