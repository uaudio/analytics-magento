<?php

class Segment_Analytics_Block_Additional extends Mage_Core_Block_Template {

    public static $actions = [];
    
    public function __construct() {
        $observer = Mage::getSingleton('segment_analytics/observer');
        self::$actions = array_merge(self::$actions, $observer->getActions(), $observer->getDeferredActions());
        $observer->clearDeferredActions();
    }

    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $script = '';
        foreach (self::$actions as $action) {
            $script .= Mage::app()->getLayout()->createBlock($action->module . '/' . $action->action, '', ['action_data' => $action->data])->toHtml();
        }
        return $script;
    }
}
