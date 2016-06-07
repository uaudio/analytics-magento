<?php

class Segment_Analytics_Block_Loggedin extends Segment_Analytics_Block_Abstract {

	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        return $this->track('Logged In', new stdClass);
	}
}
