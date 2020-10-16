<?php

namespace Hapex\CustomSortOrder\Model;

use Magento\Catalog\Model\Config as CatalogConfig;
use Hapex\CustomSortOrder\Helper\Data as DataHelper;

class Config
{
    public function __construct(DataHelper $helperData)
    {
        $this->helperData = $helperData;
    }

    public function afterGetAttributeUsedForSortByArray(CatalogConfig $catalogConfig, $options)
    {
        switch ($this->helperData->isEnabled()) {
            case true:
                try {
                    //Remove default sorting options
                    unset($options['position']);
                    unset($options['name']);
                    unset($options['price']);
                    unset($options['quantity_and_stock_status']);

                    //Change label of default sorting options if needed
                    //$options['position'] = __('Relevance');

                    //New sorting options
                    $customOptions = [];
                    $customOptions['price_asc'] = __('Price: Low to High');
                    $customOptions['price_desc'] = __('Price: High to Low');
                    $customOptions['qty_asc'] = __('Quantity: Low to High');
                    $customOptions['qty_desc'] = __('Quantity: High to Low');
                    $customOptions['name_asc'] = __('Product Name: A to Z');
                    $customOptions['name_desc'] = __('Product Name: Z to A');

                    $options = array_merge($options, $customOptions);
                } catch (\Exception $e) {
                    $this->helperData->errorLog(__METHOD__, $e->getMessage());
                }
                break;
        }
        return $options;
    }
}
