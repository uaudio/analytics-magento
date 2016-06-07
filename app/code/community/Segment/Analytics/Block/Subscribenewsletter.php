<?php

class Segment_Analytics_Block_Subscribenewsletter extends Segment_Analytics_Block_Abstract {

    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $data = $this->getActionData();
        return $this->track('Subscribed to Newsletter', new stdClass);
    }
}
