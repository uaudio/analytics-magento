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
        return $actions;
    }

}