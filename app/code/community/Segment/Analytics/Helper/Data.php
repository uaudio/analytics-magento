<?php

class Segment_Analytics_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getWriteKey() {
        return Mage::getStoreConfig('segment_analytics/options/write_key');
    }

    public function getCustomerInformation($data) {
        $fields = trim(Mage::getStoreConfig('segment_analytics/options/customer_traits'));
        $to_send = preg_split('%[\n\r]%', $fields, -1, PREG_SPLIT_NO_EMPTY);        
        
        $data_final = array();
        foreach($to_send as $field) {
            $data_final[$field] = array_key_exists($field, $data) ? $data[$field] : null;
        }
        return $data_final;
    }
    
    public function isAdmin() {
        return Mage::app()->getStore()->isAdmin();
    }
    
    public function isEnabled() {
        return !$this->isAdmin() && $this->getWriteKey();
    }
}
