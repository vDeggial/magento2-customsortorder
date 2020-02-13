<?php
namespace Hapex\CustomSortOrder\Helper;

use Hapex\Core\Helper\DataHelper;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\Context;

class Data extends DataHelper
{
    public function __construct(Context $context, ObjectManagerInterface $objectManager)
    {
        parent::__construct($context, $objectManager);
    }

    public function isEnabled()
    {
        return $this->getConfigFlag('hapex_customsortorder/general/enable');
    }

    public function log($message)
    {
        $this->printLog("hapex_sortorder", $message);
    }
}
