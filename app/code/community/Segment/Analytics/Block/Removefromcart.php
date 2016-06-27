<?php

class Segment_Analytics_Block_Removefromcart extends Segment_Analytics_Block_Abstract {

    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        return $this->track('Removed Product', $this->getActionData());
    }
}
