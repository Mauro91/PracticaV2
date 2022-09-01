<?php

namespace Practica\CustomerCode\Controller\Adminhtml\CustomerCode;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
//use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
//use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Exception\NotFoundException;
use Practica\CustomerCode\Model\ResourceModel\CustomerCode\Collection;
//use Practica\CustomerCode\Model\CustomerCode;
use Practica\CustomerCode\Model\ResourceModel\CustomerCode;

class MassDelete extends Action
{
    protected $filter;

    //protected $collectionFactory;
    protected $collection;
    protected $customerCodeRepository;

    //private $categoryRepository;

    public function __construct(
        Action\Context              $context,
        Filter                      $filter,
        //CollectionFactory           $collectionFactory,
        //CategoryRepositoryInterface $categoryRepository = null
        Collection $collection,
        CustomerCode $customerCodeRepository
    )
    {
        $this->filter = $filter;
        //$this->collectionFactory = $collectionFactory;
        //$this->categoryRepository = $categoryRepository
        //    ?: \Magento\Framework\App\ObjectManager::getInstance()->create(CategoryRepositoryInterface::class);
        $this->collection = $collection;
        $this->customerCodeRepository = $customerCodeRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $collection = $this->filter->getCollection($this->collection);
        $categoryDeleted = 0;
        foreach ($collection->getItems() as $customerCode) {
            $this->customerCodeRepository->delete($customerCode);
            $categoryDeleted++;
        }

        if ($categoryDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $categoryDeleted)
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('practica_customercode/index/index');
    }
}
