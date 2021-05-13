<?php

declare(strict_types=1);

namespace Dtn\ManageJob\Controller\Employee;

use Dtn\ManageJob\Model\ResourceModel\Work;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Dtn\ManageJob\Model\WorkFactory;
use Dtn\ManageJob\Model\ResourceModel\Collection\CollectionFactory;

class Delete extends Action
{
    /**
     * @var WorkFactory
     */
    protected $model;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var Work
     */
    protected $resourse;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Work $work
     * @param RequestInterface $requestInterface
     * @param JsonFactory $jsonFactory
     * @param CollectionFactory $collectionFactory
     * @param WorkFactory $workFactory
     */
    public function __construct
    (
        Context $context,
        Work $work,
        RequestInterface $requestInterface,
        JsonFactory $jsonFactory,
        CollectionFactory $collectionFactory,
        WorkFactory $workFactory
    )
    {
        $this->model = $workFactory;
        $this->jsonFactory = $jsonFactory;
        $this->request = $requestInterface;
        $this->resourse = $work;
        $this->collection = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->jsonFactory->create();
        $dataDelete = $this->request->getParam('deleteId');
        $workModel = $this->model->create();
        $data = array();
        $this->getWorks();
        foreach ($dataDelete as $item) {
            $this->resourse->load($workModel, $item['entity_id']);
            try {
                $workModel->delete();
            } catch (\Exception $exception) {
            }
        }
        $result->setData(['status'=>true , 'data'=>$this->getWorks()]);
        return $result;
    }

    /**
     * @return array data
     */
    public function getWorks()
    {
        $scheduleData = $this->collection->create();
        $result = array();
        foreach ($scheduleData as $collection) {
            $result[] = $collection->getData();
        }
        return $result;
    }

}