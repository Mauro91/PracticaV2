<?php

namespace Practica\CustomerCode\Model\ResourceModel\CustomerCode;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init('Practica\CustomerCode\Model\CustomerCode', 'Practica\CustomerCode\Model\ResourceModel\CustomerCode');
    }
}
