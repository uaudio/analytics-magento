<?php

class Segment_Analytics_Block_Abstract extends Mage_Core_Block_Template {

    public function track($event, $data) {
        return sprintf('<script>document.observe("dom:loaded", function() { window.analytics.track(%s, %s, %s); });</script>', $this->jsonEncode($event), $this->jsonEncode($data), $this->getContextJson());
    }

    public function identify($id, $data) {
        return sprintf('<script>document.observe("dom:loaded", function() { window.analytics.identify(%s, %s, %s); });</script>', $this->jsonEncode($id), $this->jsonEncode($data), $this->getContextJson());
    }

    public function page($name, $title) {
        return sprintf('<script>document.observe("dom:loaded", function() { window.analytics.page(%s, %s, {}, %s); });</script>', $this->jsonEncode($name), $this->jsonEncode($title), $this->getContextJson());
    }

    public function getContextJson() {
        //Segment hasn't added "Pretty View Support" in debugger for analytics-magento yet, so we'll return empty for now.
        return '{}';

        $context = [
            'library' => [
                'name' => 'analytics-magento',
                'version' => (string) Mage::getConfig()->getNode()->modules->Segment_Analytics->version
            ]
        ];
        return $this->jsonEncode($context);
    }

    public function jsonEncode($data) {
        return preg_replace('%[\r\n]%', '', Mage::helper("core")->jsonEncode($data));
    }
}
