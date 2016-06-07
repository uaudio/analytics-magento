<?php

class Segment_Analytics_Block_Identify extends Segment_Analytics_Block_Abstract {

    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            return $this->identify($customer->getId(), Mage::helper('analytics')->getCustomerInformation($customer->getData()));
        }
    }
}
