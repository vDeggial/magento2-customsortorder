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
     * @param \Magento\Catalog\Block\Product\ProductList\Toolbar $toolbar
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
                try {
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
                    }
                    break;
                } catch (\Exception $e) {
                    $this->helperData->errorLog(__METHOD__, $e->getMessage());
                }
            break;
        }
        //var_dump((string) $this->_collection->getSelect()); You can use this to get a list of all the available sort fields
        return $result;
    }
}
