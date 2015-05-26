<?php
class Segment_Analytics_Block_Loggedin extends Mage_Core_Block_Template {
	public function _toHtml() {
		return '<script>document.observe("dom:loaded", function() { window.analytics.track(\'Logged In\',{});});</script>';
	}
}