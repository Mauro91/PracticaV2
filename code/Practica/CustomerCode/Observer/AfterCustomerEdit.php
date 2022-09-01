<?php

namespace Practica\CustomerCode\Observer;

//use Magento\Customer\Model\Logger;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

use Magento\Customer\Model\Customer;


class AfterCustomerEdit implements ObserverInterface
{
    /**
     * Logger of customer's log data.
     *
     * @var Logger
     */
    protected $logger;

    /**
     * @param Logger $logger
     *
     */

    protected $customerCollection;
    protected $customerRepository;
    protected $customerSession;
    public function __construct(Customer $customerCollection,
    \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
    \Magento\Customer\Model\Session $session,

    )
    {
        $this->customerCollection = $customerCollection;
        $this->customerRepository = $customerRepository;
        $this->customerSession = $session;
    }
    public function execute(Observer $observer)
    {
        $customerObject = $observer->getEvent()->getCustomerDataObject();

        $newCustomer = $this->customerRepository->getById($customerObject->getId());

        $newName = $this->changeName($newCustomer->getFirstname());
        $newCustomer->setFirstname($newName);
        $this->customerRepository->save($newCustomer);
    }
    private function changeName($oldName)
    {
        $newName = "";
        preg_match('!\d+!',$oldName , $numberFound);

        if(count($numberFound) == 1 && is_numeric($numberFound[0]))
        {
            $number = intval($numberFound[0]);
            $number++;
            $newName = str_replace($numberFound[0], $number, $oldName);
        }else
        {
            $newName = $oldName."1";
        }
        return $newName;
    }
}
