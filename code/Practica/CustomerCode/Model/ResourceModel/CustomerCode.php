<?php

namespace Practica\CustomerCode\Model\ResourceModel;

class CustomerCode extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init('customer_code', 'entity_id');
    }
}
