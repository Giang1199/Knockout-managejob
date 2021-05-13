<?php

namespace Dtn\ManageJob\Model\ResourceModel\Collection;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Dtn\ManageJob\Model\Work', 'Dtn\ManageJob\Model\ResourceModel\Work');
    }
}