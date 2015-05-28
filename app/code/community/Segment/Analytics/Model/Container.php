<?php
/**
 * Analytics specific full page cache container
 *
 * @package    Segment_Analytics
 */
class Segment_Analytics_Model_Container  extends Enterprise_PageCache_Model_Container_Abstract {

	public function applyWithoutApp(&$content) {
	    return false;
    }
    
    public function _getCacheId() {
        return false;
    }

    protected function _renderBlock() {
        $block = $this->_getPlaceHolderBlock();
        Mage::dispatchEvent('render_block', array('block' => $block, 'placeholder' => $this->_placeholder));
        return $block->toHtml();
    }

}
