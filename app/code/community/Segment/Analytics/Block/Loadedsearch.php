<?php
class Segment_Analytics_Block_Loadedsearch extends Mage_Core_Block_Template {
	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $contextJson = Mage::helper('analytics')->getContextJson();
        $data = Mage::registry('segment_data');
        Mage::unregister('segment_data');
        if (!isset($data['query'])) return false;
		return '<script>document.observe("dom:loaded", function() { window.analytics.track(\'Searched Products\',{\'query\':\''.$data['query'].'\'},'.$contextJson.');});</script>';
	}
}