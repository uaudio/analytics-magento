<?php
class Segment_Analytics_Block_Orderplaced extends Mage_Core_Block_Template {
	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $data = Mage::registry('segment_data');
        Mage::unregister('segment_data');
        $info = Mage::getModel('sales/order_api')->info($data['increment_id']);

        $params = array();
        $params['total']            = (float) $info['grand_total'];
        $params['revenue']            = (float) $info['grand_total'];
        $params['coupon']       =   $info['coupon_code'];
        $params['status']           = $info['status'];        
        $params['shipping']         = (float) $info['shipping_amount'];
        $params['tax']              = (float) $info['tax_amount'];
        $params['products']         = array();
        foreach($info['items'] as $item) {
            $tmp = array();      
            $tmp['sku']           = $item['sku'];
            $tmp['name']          = $item['name'];
            $tmp['price']         = (float) ($item['price'] - $item['discount_amount']);
            $tmp['quantity']      = (float) $item['qty_ordered'];
            $tmp['id']    = (int) $item['product_id'];            
            $params['products'][] = $tmp;
        }
        $json = Mage::helper("core")->jsonEncode($params);
        $json = preg_replace('%[\r\n]%','',$json);
        

		return '<script>document.observe("dom:loaded", function() { window.analytics.track(\'Completed Order\',
		'.$json.'
		);});</script>';
	}
}