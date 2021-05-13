<?php

namespace Dtn\ManageJob\Model\ResourceModel;

class Work extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('dtn_schedule', 'entity_id');
    }
}