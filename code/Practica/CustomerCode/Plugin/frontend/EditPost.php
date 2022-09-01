<?php

namespace Practica\CustomerCode\Plugin\frontend;

use Magento\Customer\Api\Data\CustomerInterface;

class EditPost
{
    protected $logger;
    public function __construct(
        \Practica\CustomerCode\Logger\Logger $logger
    )
    {
        $this->logger = $logger;
    }
    public function beforeSave($subject, CustomerInterface $customer, $passwordHash = null){
        $firstName = $customer->getFirstname();
        $customer->setFirstname($this->changeName($firstName));
        $msgLog = "UPDATE: Firstname: {$customer->getFirstname()} | Lastname: {$customer->getLastname()} | Email: {$customer->getEmail()} | ID: {$customer->getId()}";
        $this->logger->info($msgLog);

        return [$customer, $passwordHash];
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
