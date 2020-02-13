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
        switch($this->helperData->isEnabled())
        {
            case true:
                //Remove default sorting options
                unset($options['position']);
                //unset($options['name']);
                //unset($options['price']);
                unset($options['quantity_and_stock_status']);
        
                //Change label of default sorting options if needed
                //$options['position'] = __('Relevance');
        
                //New sorting options
                $options['qty_asc'] = __('Quantity: Low to High');
                $options['qty_desc'] = __('Quantity: High to Low');
                break;
        }
        return $options;
    }
}