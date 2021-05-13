<?php

namespace Dtn\ManageJob\Model;

use Magento\Framework\Model\AbstractModel;

class Work extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Dtn\ManageJob\Model\ResourceModel\Work');
    }
}