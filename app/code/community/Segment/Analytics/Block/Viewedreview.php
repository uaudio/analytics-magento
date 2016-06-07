<?php

class Segment_Analytics_Block_Viewedreview extends Segment_Analytics_Block_Abstract {

	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $data = $this->getActionData();
        return $this->track('Viewed Product Reviews', ['category' => 'Product', 'sku' => $data['sku']]);
	}
}
