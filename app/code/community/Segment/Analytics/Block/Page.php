<?php

class Segment_Analytics_Block_Page extends Segment_Analytics_Block_Abstract {

    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        return $this->page($this->_getCategoryName(), $this->_getTitle());
    }

    protected function _getCategoryName() {
        return ucfirst($this->getRequest()->getRequestedRouteName());
    }

    protected function _getTitle() {
        return is_object($this->getLayout()->getBlock('head')) ? $this->getLayout()->getBlock('head')->getTitle() : '';
    }
}
