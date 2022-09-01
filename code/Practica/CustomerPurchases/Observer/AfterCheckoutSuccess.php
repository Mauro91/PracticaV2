<?php

namespace Practica\CustomerPurchases\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AfterCheckoutSuccess implements ObserverInterface
{
    const CLIENTES_PREMIUM = 5;
    const CLIENTES_BASE = 4;

    protected $order;
    protected $customerModel;
    protected $customerRepository;
    protected $dataHelper;
    protected $orderCollection;

    public function __construct(
        \Magento\Sales\Model\Order $order,
        \Magento\Customer\Model\Customer $customerModel,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Sales\Model\ResourceModel\Order\Collection $orderCollection,
        \Practica\CustomerPurchases\Helper\Data $dataHelper
    )
    {
        $this->order = $order;
        $this->customerModel = $customerModel;
        $this->customerRepository = $customerRepository;
        $this->orderCollection = $orderCollection;
        $this->dataHelper = $dataHelper;
    }
    public function execute(Observer $observer)
    {
        if(!$this->dataHelper->isModuleEnabled())
            return;

        $order = $observer->getEvent()->getOrder();
        $customerId = $order->getCustomerId();
        $customer = $this->customerRepository->getById($customerId);
        $totalItemCount = $order->getTotalItemCount();
        if($customer->getGroupId() == AfterCheckoutSuccess::CLIENTES_PREMIUM || $totalItemCount == 0)
            return;

        //$newGroupId = $order->getTotalItemCount() > 3 ? AfterCheckoutSuccess::CLIENTES_PREMIUM : AfterCheckoutSuccess::CLIENTES_BASE;
        $this->orderCollection->addAttributeToSearchFilter('customer_id', $customerId)->load();
        $newGroupId = $this->orderCollection->count() > 3 ? AfterCheckoutSuccess::CLIENTES_PREMIUM : AfterCheckoutSuccess::CLIENTES_BASE;
        $customer->setGroupId($newGroupId);

        $this->customerRepository->save($customer);
    }
}
