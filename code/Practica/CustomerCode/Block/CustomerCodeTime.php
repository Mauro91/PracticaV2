<?php


namespace Practica\CustomerCode\Block;

use Magento\Framework\View\Element\Template;

class CustomerCodeTime extends Template
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTimeFactory
     */
    protected $dateTimeFactory;
    /**
     * @param Template\Context $context
     * @param array $data
     * @return void
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateTimeFactory,
        array $data = []
    ){
        $this->dateTimeFactory = $dateTimeFactory;
        parent::__construct($context, $data);
    }
    public function getCurrentGMTDateTime()
    {
        $dateModel = $this->dateTimeFactory->create();
        return $dateModel->gmtDate();
    }
}
