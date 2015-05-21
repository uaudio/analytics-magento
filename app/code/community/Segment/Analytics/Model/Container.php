<?php
/**
 * Analytics specific full page cache container
 *
 * @package    Uaudio_Analytics
 * @author     Universal Audio <web-dev@uaudio.com>
 */
class Segment_Analytics_Model_Container  extends Enterprise_PageCache_Model_Container_Abstract {

	/**
	 * @ignore
	 */
	protected function _getIdentifier() {
		$block = $this->_placeholder->getAttribute('block');
		return $block.$_COOKIE['PHPSESSID'];
	}

	/**
	 * @ignore
	 */
	protected function _getCacheId() {
		return 'ANALYTICS_CONTAINER' . md5($this->_placeholder->getAttribute('cache_id') . $this->_getIdentifier());
	}

	/**
	 * @ignore
	 */
	protected function _renderBlock() {
		$block = $this->_placeholder->getAttribute('block');
		$template = $this->_placeholder->getAttribute('template');

		$block = new $block;
		$block->setTemplate($template);
		$block->setLayout(Mage::app()->getLayout());

		return $block->toHtml();
	}

	/**
	 * @ignore
	 */
	public function saveCache($blockContent) {
		return $this;
	}
	
	public function applyWithoutApp(&$content) {
        	return false;
    	}
}
