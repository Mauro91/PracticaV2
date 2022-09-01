<?php


namespace Practica\CustomerCode\Controller\Test;


class Insert extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $customerCodeFactory;
    /** @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManage2;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\ObjectManagerInterface $objectManage
    ){
        $this->resultPageFactory = $resultPageFactory;
        $this->objectManage2 = $objectManage;
        parent::__construct($context);
    }
    /*public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Practica\CustomerCode\Model\CustomerCode $customerCodeFactory
    ){
        $this->resultPageFactory = $resultPageFactory;
        $this->customerCodeFactory = $customerCodeFactory;
        parent::__construct($context);
    }*/
    /*public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }*/
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $objectManagertest = \Magento\Framework\App\ObjectManager::getInstance();
        //$subscription = $this->objectManager2->create('Practica\CustomerCode\Model\CustomerCode');
        //$subscription = $this->customerCodeFactory->create();
        $subscription = $objectManagertest->create('Practica\CustomerCode\Model\CustomerCode');
        $subscription->setCode('Marcos');
        $subscription->setCustomerId(11);


        $subscription->save();
        $this->getResponse()->setBody('Success');


        return $resultPage;
    }
}
