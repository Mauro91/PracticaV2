<?php

namespace Practica\CustomerCode\Observer;

use Magento\Customer\Model\Logger;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ActionInterface;
use \Magento\Framework\App\ObjectManager;
use Practica\CustomerCode\Model\CustomerCode;

class AfterCustomerRegistration implements ObserverInterface
{
    const CODE_MAX_LENGTH = 40;

    private CustomerCode $customerCode;

    public function __construct(CustomerCode $customerCode)
    {
        $this->customerCode = $customerCode;
    }
    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $idCustomer = $customer->getId();

        if($idCustomer <= 0)
            return;

        //$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        //$customerCode = $objectManager->create('Practica\CustomerCode\Model\CustomerCode');
        $this->customerCode->setCustomerId($idCustomer);
        $code = $this->generateUniqueCode($idCustomer, AfterCustomerRegistration::CODE_MAX_LENGTH);
        $this->customerCode->setCode($code);
        $this->customerCode->save();
    }

    private function generateUniqueCode($id, $length_of_string) {

        return substr(md5(time()).md5($id), 0, $length_of_string);
    }
}
