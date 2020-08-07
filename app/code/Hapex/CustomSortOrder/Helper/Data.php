<?php
namespace Hapex\CustomSortOrder\Helper;

use Hapex\Core\Helper\DataHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;

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
        $this->helperLog->printLog("hapex_sortorder", $message);
    }
}
