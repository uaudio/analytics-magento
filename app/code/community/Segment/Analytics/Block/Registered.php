<?php
class Segment_Analytics_Block_Registered extends Mage_Core_Block_Template {
	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $data = Mage::registry('segment_data');
        Mage::unregister('segment_data');
        if (!isset($data['customer_id'])) return false;
		return '<script>document.observe("dom:loaded", function() { window.analytics.track(\'Signed Up\',{\'userId\':\''.$data['customer_id'].'\'});});</script>';
	}
}