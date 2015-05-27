<?php
class Segment_Analytics_Block_Removefromcart extends Mage_Core_Block_Template {
	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $data = Mage::registry('segment_data');
        Mage::unregister('segment_data');
		return '<script>document.observe("dom:loaded", function() { window.analytics.track(\'Removed Product\',{\'sku\':\''.$data['sku'].'\'});});</script>';
	}
}