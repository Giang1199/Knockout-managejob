<?php

declare(strict_types=1);

namespace Dtn\ManageJob\Controller\Employee;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Dtn\ManageJob\Model\WorkFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use Dtn\ManageJob\Model\ResourceModel\Collection\CollectionFactory;

class Save extends Action
{
    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var WorkFactory
     */
    protected $workFactory;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * Save constructor.
     * @param Context $context
     * @param WorkFactory $workFactory
     * @param RequestInterface $request
     * @param CollectionFactory $collectionFactory
     * @param JsonFactory $jsonFactory
     */
    public function __construct
    (
        Context $context,
        CollectionFactory $collectionFactory,
        WorkFactory $workFactory,
        RequestInterface $request,
        JsonFactory $jsonFactory
    )
    {
        $this->collection = $collectionFactory;
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->workFactory = $workFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $timeJob = $this->request->getParam('timeJob');
        $workToDo = $this->request->getParam('work');
        $editId = $this->request->getParam('editVal');

        $model = $this->workFactory->create();
        $result = $this->jsonFactory->create();

        $saveData = [
            'work_time' => $timeJob,
            'work_to_do' => $workToDo
        ];
        try {
            if ($editId != ""){
                $model->load($editId);
                $model->addData($saveData)->save();
                $data = ['action'=>'edit' ,'data'=>$this->getWorks()];
            }
            else{
                $model->addData($saveData)->save();
                $data = ['action'=>'save' ,'data'=>$model->getData()];
            }
            $result->setData($data);
            return $result;
        } catch (\Exception $exception) {

        }
        return $result->setData($data);
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