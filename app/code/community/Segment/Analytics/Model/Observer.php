<?php
class Segment_Analytics_Model_Observer {
    public function addScripts($observer) {
        if (count($this->getDeferredActions()) == 0) return $this;
        $layout = $observer->getEvent()->getLayout();
        if(!$layout) return;
        $content = $layout->getBlock('content');
        if(!$content) return;
        $block = $layout->createBlock('segment_analytics/additional');
        $content->append($block);
        return $this;
    }
    
    public function loggedIn($observer) {
        $this->addDeferredAction('loggedin');
    }
    
    public function loggedOut($observer) {
        $this->addDeferredAction('loggedout');
    }
    
    public function addToCart($observer) {
        $product = $observer->getProduct();
        $this->addDeferredAction('addtocart',
            array('sku'=>$product->getSku())
        );
    }

    public function removeFromCart($observer) {
        $product = $observer->getQuoteItem()->getProduct();
        $this->addDeferredAction('removefromcart',
            array('sku'=>$product->getSku())
        );
    }

    public function loadedSearch($observer) {
        $o = $observer->getDataObject();
        if(!$o->getQueryText()){return;}
        $this->addAction('loadedsearch',
            array('query'=>$o->getQueryText())
        );
    }
    
    public function customerRegistered($observer) {
        $customer = $observer->getCustomer();
        $this->addDeferredAction('registered',
            array('customer_id'=>$customer->getEntityId())
        );
    }

    public function _getSession() {
        return Mage::getSingleton('segment_analytics/session');
    }

    public function addDeferredAction($action, $action_data=array()) {
        $o_action = new stdClass;
        $o_action->action = $action;
        $o_action->data = $action_data;
        $session = $this->_getSession();
        $deferred = $session->getDeferredActions();
        $deferred = $deferred ? $deferred : array();
        foreach ($deferred as $i => $_action) {
            if ($_action->action == $action) unset($deferred[$i]);
        }
        $deferred[] = $o_action;
        $session->setDeferredActions($deferred);
        return $this;
    }

    public function clearDeferredActions() {
        $this->_getSession()->setDeferredActions(array())->setDeferredActionsData(array());
        return $this;
    }
    
    public function getDeferredActions() {
        $actions = $this->_getSession()->getDeferredActions();
        $actions = $actions ? $actions : array();
        Mage::log($actions);
        return $actions;
    }

    public function addAction($action, $action_data=array()) {
        $o_action = new stdClass;
        $o_action->action = $action;
        $o_action->data = $action_data;
        $actions = Mage::registry('actions');
        $actions[] = $o_action;
        Mage::unregister('actions');
        Mage::register('actions',$actions);
        return $this;
    }
    
    public function getActions() {
        $actions = Mage::registry('actions');
        $actions = $actions ? $actions : array();
        return $actions;
    }

}