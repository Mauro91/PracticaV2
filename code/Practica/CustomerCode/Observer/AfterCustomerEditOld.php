<?php

namespace Practica\CustomerCode\Observer;

//use Magento\Customer\Model\Logger;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Practica\CustomerCode\Logger\Logger;

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
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
    public function execute(Observer $observer)
    {
        $this->logger->info('');
    }
    private function changeName($oldName)
    {
        $newName = "";
        preg_match('!\+\d+!',$oldName , $numberFound);

        if(count($numberFound) == 1 && is_numeric($numberFound[0]))
        {
            $number = intval($numberFound[0]);
            $number++;
            $newName = str_replace("+".$numberFound[0], "+".$number, $oldName);
        }else
        {
            $newName = $oldName."+1";
        }
        return $newName;
    }
}
