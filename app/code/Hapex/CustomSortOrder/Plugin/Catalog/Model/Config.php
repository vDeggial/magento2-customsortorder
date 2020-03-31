<?php
namespace Hapex\CustomSortOrder\Plugin\Catalog\Model;

use Hapex\CustomSortOrder\Helper\Data as DataHelper;

class Config
{
    public function __construct(DataHelper $helperData)
    {
        $this->helperData = $helperData;
    }

    /**
     * Adding custom options and changing labels
     *
     * @param \Magento\Catalog\Model\Config $catalogConfig
     * @param [] $options
     * @return []
     */
    public function afterGetAttributeUsedForSortByArray(\Magento\Catalog\Model\Config $catalogConfig, $options)
    {
        switch ($this->helperData->isEnabled()) {
            case true:
                //Remove default sorting options
                unset($options['position']);
                unset($options['name']);
                unset($options['price']);
                unset($options['quantity_and_stock_status']);

                //Change label of default sorting options if needed
                //$options['position'] = __('Relevance');

                //New sorting options
                $customOptions = [];
                $customOptions['price_desc'] = __('Price: High to Low');
                $customOptions['price_asc'] = __('Price: Low to High');
                $customOptions['qty_desc'] = __('Quantity: High to Low');
                $customOptions['qty_asc'] = __('Quantity: Low to High');
                $customOptions['name_asc'] = __('Product Name: A to Z');
                $customOptions['name_desc'] = __('Product Name: Z to A');

                $options = array_merge($options, $customOptions);
                break;
        }
        return $options;
    }
}