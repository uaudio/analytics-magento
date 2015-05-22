<?php
class Segment_Analytics_Block_Identify extends Mage_Core_Block_Template {
	public function _toHtml() {
	    if (Mage::getSingleton('customer/session')->isLoggedIn()) {
	        $customer = Mage::getSingleton('customer/session')->getCustomer();
	        return '<script>document.observe("dom:loaded", function() { window.analytics.identify("'.$customer->getId().'", {
	            name: "'. $customer->getFirstname() . ' ' . $customer->getLastname().'",
	            email: "'.$customer->getEmail().'"
	            });   });</script>';
        }
	}
}
