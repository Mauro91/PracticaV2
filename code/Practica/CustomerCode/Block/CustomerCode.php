<?php


namespace Practica\CustomerCode\Block;

use Magento\Framework\View\Element\Template;

class CustomerCode extends Template
{
    /**
     * @param Template\Context $context
     * @param array $data
     * @return void
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ){
        parent::__construct($context, $data);
    }
}
