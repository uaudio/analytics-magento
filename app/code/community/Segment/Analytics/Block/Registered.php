<?php

class Segment_Analytics_Block_Registered extends Segment_Analytics_Block_Abstract {

    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $data = $this->getActionData();
        if (!isset($data['customer_id'])) return false;
        return $this->track('Signed Up', ['userId' => $data['customer_id']]);
    }
}
