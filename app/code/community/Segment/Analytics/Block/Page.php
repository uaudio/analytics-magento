<?php

class Segment_Analytics_Block_Page extends Segment_Analytics_Block_Abstract {

    public static $actions = [];

    public function __construct() {
        $observer = Mage::getSingleton('segment_analytics/observer');
        self::$actions = array_merge(self::$actions, $observer->getPageActions());
    }

    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $script = $this->page($this->_getCategoryName(), $this->_getTitle());
        foreach(self::$actions as $action) {
            $script .= Mage::app()->getLayout()->createBlock($action->module . '/' . $action->action, '', ['action_data' => $action->data])->toHtml();
        }

        return $script;
    }

    protected function _getCategoryName() {
        return ucfirst($this->getRequest()->getRequestedRouteName());
    }

    protected function _getTitle() {
        return is_object($this->getLayout()->getBlock('head')) ? $this->getLayout()->getBlock('head')->getTitle() : '';
    }
}
