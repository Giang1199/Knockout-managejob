<?php
declare(strict_types=1);

namespace Dtn\ManageJob\Block;

use Magento\Framework\View\Element\Template;
use Dtn\ManageJob\Model\ResourceModel\Collection\CollectionFactory;

class GetData extends \Magento\Framework\View\Element\Template
{
    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * GetData constructor.
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct
    (
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    )
    {
        $this->collection = $collectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return array data
     */
    public function getCollection()
    {
        $scheduleData = $this->collection->create();
        $result = array();
        foreach ($scheduleData as $collection) {
            $result[] = $collection->getData();
        }
        return json_encode($result);
    }
}