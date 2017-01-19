<?php

class Segment_Analytics_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getWriteKey() {
        return Mage::getStoreConfig('segment_analytics/options/write_key');
    }

    public function getCustomerInformation($data) {
        $fields = trim(Mage::getStoreConfig('segment_analytics/options/customer_traits'));
        $to_send = preg_split('%[\n\r]%', $fields, -1, PREG_SPLIT_NO_EMPTY);

        $optionAttrs = Mage::getModel('eav/entity_attribute') ->getCollection();
        $optionAttrs->addFieldToFilter('entity_type_id', 1)
            ->getSelect()
            ->joinLeft(
                ['ao' => $optionAttrs->getTable('eav/attribute_option')],
                'ao.attribute_id = main_table.attribute_id',
                'option_id')
            ->group('main_table.attribute_id')
            ->where('(main_table.frontend_input = ? AND ao.option_id > 0)', 'select');
        $attrByCode = [];
        foreach ($optionAttrs as $attr) {
            $attrByCode[$attr->getAttributeCode()] = $attr;
        }

        $data_final = array();
        foreach($to_send as $field) {
            $fieldData = array_key_exists($field, $data) ? $data[$field] : null;
            if (isset($attrByCode[$field])) {
                $attr = $attrByCode[$field];
                $collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
                    ->setAttributeFilter($attr->getId())
                    ->addFieldToFilter('main_table.option_id', $fieldData)
                    ->setStoreFilter(0);
                $value = $collection->getFirstItem()->getValue();
            }
            else {
                $value = $fieldData;
            }
            $data_final[$field] = $value;
        }
        return $data_final;
    }

    public function isAdmin() {
        return Mage::app()->getStore()->isAdmin();
    }

    public function isEnabled() {
        return !$this->isAdmin() && $this->getWriteKey();
    }
}
