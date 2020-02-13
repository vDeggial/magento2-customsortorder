<?php
namespace Hapex\CustomSortOrder\Plugin\Catalog\Block;

use Hapex\CustomSortOrder\Helper\Data as DataHelper;

class Toolbar
{
    public function __construct(DataHelper $helperData)
    {
        $this->helperData = $helperData;
    }

    /**
    * @param \Magento\Catalog\Block\Product\ProductList\Toolbar $subject
    * @param \Closure $proceed
    * @param \Magento\Framework\Data\Collection $collection
    * @return \Magento\Catalog\Block\Product\ProductList\Toolbar
    */
    public function aroundSetCollection(\Magento\Catalog\Block\Product\ProductList\Toolbar $toolbar, \Closure $proceed, $collection)
    {
        $this->_collection = $collection;
        $result = $proceed($collection);
        switch ($this->helperData->isEnabled()) {
            case true:
                $currentOrder = $toolbar->getCurrentOrder();
                $currentDirection = $toolbar->getCurrentDirection();

                if ($currentOrder) {
                    switch ($currentOrder) {

                    case 'qty_asc':
                        $this->_collection->setOrder('quantity_and_stock_status', "asc");
                        break;

                    case 'qty_desc':
                        $this->_collection->setOrder('quantity_and_stock_status', "desc");
                        break;

                    default:
                        $this->_collection->setOrder($currentOrder, $currentDirection);
                    break;

                    }
                }
                break;
        }
        //var_dump((string) $this->_collection->getSelect()); You can use this to get a list of all the available sort fields
        return $result;
    }
}
