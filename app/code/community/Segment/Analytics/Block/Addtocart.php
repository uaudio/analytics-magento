<?php
class Segment_Analytics_Block_Addtocart extends Mage_Core_Block_Template {
	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $contextJson = Mage::helper('analytics')->getContextJson();
        $data = Mage::registry('segment_data');
        Mage::unregister('segment_data');
		return '<script>document.observe("dom:loaded", function() { window.analytics.track(\'Added Product\',{\'sku\':\''.$data['sku'].'\'},'.$contextJson.');});</script>';
	}
}