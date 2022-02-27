<?php

namespace Hapex\CustomSortOrder\Block\Product\ProductList;

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
                        case "qty_asc":
                            $this->_collection->clear();
                            $this->_collection->addAttributeToSelect('*')->addAttributeToSort('quantity_and_stock_status', 'ASC')->load();
                            //var_dump($collection);
                            break;

                        case "qty_desc":
                            $this->_collection->clear();
                            $this->_collection->addAttributeToSelect('*')->addAttributeToSort('quantity_and_stock_status', 'DESC')->load();
                            break;

                        default:
                            $this->setOrder($currentOrder, $currentDirection);
                            break;
                    }
                } catch (\Exception $e) {
                    $this->helperData->getLogHelper()->errorLog(__METHOD__, $e->getMessage());
                }
                break;
        }
        return $result;
    }

    private function setOrder($currentOrder = null, $currentDirection = null)
    {
        switch ($currentOrder) {

            case 'qty_asc':
                $this->setCurrentOrder('quantity_and_stock_status', "asc");
                break;

            case 'qty_desc':
                $this->setCurrentOrder('quantity_and_stock_status', "desc");
                break;

            case 'price_asc':
                $this->setCurrentOrder('price', "asc");
                break;
            case 'price_desc':
                $this->setCurrentOrder('price', "desc");
                break;

            case 'name_asc':
                $this->setCurrentOrder('name', "asc");
                break;
            case 'name_desc':
                $this->setCurrentOrder('name', "desc");
                break;

            default:
                $this->setCurrentOrder($currentOrder, $currentDirection);
                break;
        }
    }

    private function setCurrentOrder($order = null, $direction = null)
    {
        $this->_collection->setOrder($order, $direction);
    }
}
