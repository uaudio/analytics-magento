<?php

class Segment_Analytics_Block_Orderplaced extends Segment_Analytics_Block_Abstract {
    public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $data = $this->getActionData();
        $info = Mage::getModel('sales/order_api')->info($data['increment_id']);

        $params = [
            'order_id' => $info['order_id'],
            'increment_id' => $data['increment_id'],
            'total' => (float) $info['grand_total'],
            'revenue' => (float) $info['grand_total'],
            'coupon' => $info['coupon_code'],
            'currency' => $info['order_currency_code'],
            'status' => $info['status'],
            'shipping' => (float) $info['shipping_amount'],
            'tax' => (float) $info['tax_amount'],
            'products' => [],
        ];

        foreach($info['items'] as $item) {
            $category = Mage::getModel('catalog/product')->loadBySku($item['sku'])->getDefaultCategory();
            $params['products'][] = [
                'sku' => $item['sku'],
                'name' => $item['name'],
                'price' => (float) ($item['price'] - $item['discount_amount']),
                'quantity' => (float) $item['qty_ordered'],
                'id' => (int) $item['product_id'],
                'category' => is_object($category) ? $category->getName() : '',
            ];
        }

        return $this->track('Completed Order', $params);
    }
}
