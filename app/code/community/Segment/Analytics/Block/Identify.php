<?php
    class Segment_Analytics_Block_Identify extends Mage_Core_Block_Template {
    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $contextJson = Mage::helper('analytics')->getContextJson();
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $customerInfo = Mage::helper('analytics')->getCustomerInformation($customer->getData());
            $code = '<script>document.observe("dom:loaded", function() { window.analytics.identify("'.$customer->getId().'", ' . json_encode($customerInfo) . ','.$contextJson.');   });</script>';
            return $code;
        }
    }
}
