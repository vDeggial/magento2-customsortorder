<?php

namespace Hapex\CustomSortOrder\Plugin\Catalog\Block;

use Hapex\CustomSortOrder\Helper\Data as DataHelper;
use Magento\Catalog\Block\Product\ProductList\Toolbar as ToolBarProductList;

class Toolbar
{
    public function __construct(DataHelper $helperData)
    {
        $this->helperData = $helperData;
    }

    public function aroundSetCollection(ToolbarProductList $toolbar, \Closure $proceed, $collection)
    {
        $this->_collection = $collection;
        $result = $proceed($collection);
        switch ($this->helperData->isEnabled()) {
            case true:
                try {
                    $currentOrder = $toolbar->getCurrentOrder();
                    $currentDirection = $toolbar->getCurrentDirection();
                    switch ($currentOrder) {

                        case 'qty_asc':
                            $this->_collection->setOrder('quantity_and_stock_status', "asc");
                            break;

                        case 'qty_desc':
                            $this->_collection->setOrder('quantity_and_stock_status', "desc");
                            break;

                        case 'price_asc':
                            $this->_collection->setOrder('price', "asc");
                            break;
                        case 'price_desc':
                            $this->_collection->setOrder('price', "desc");
                            break;

                        case 'name_asc':
                            $this->_collection->setOrder('name', "asc");
                            break;
                        case 'name_desc':
                            $this->_collection->setOrder('name', "desc");
                            break;

                        default:
                            $this->_collection->setOrder($currentOrder, $currentDirection);
                            break;
                    }
                } catch (\Exception $e) {
                    $this->helperData->errorLog(__METHOD__, $e->getMessage());
                }
                break;
        }
        return $result;
    }
}
