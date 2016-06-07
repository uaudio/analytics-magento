<?php

class Segment_Analytics_Block_Loadedsearch extends Segment_Analytics_Block_Abstract {

    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $data = $this->getActionData();
        if (!isset($data['query'])) return false;
        return $this->track('Searched Products', ['query' => $data['query']]);
    }
}
