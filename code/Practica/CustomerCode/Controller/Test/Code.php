<?php
namespace Practica\CustomerCode\Controller\Test;


class Code extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;


    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    ){
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();

        $pedro = $this->changeName("Predooo +1");
        $ramon = $this->changeName("Ramon");
        $pepe = $this->changeName("Pepepe +56");
        $roman = $this->changeName("Roman -58");

        return $resultPage;
    }

    private function changeName($nombre)
    {
        $newName = "";
        preg_match('!\+\d+!',$nombre , $matche);

        if(count($matche) == 1 && is_numeric($matche[0]))
        {
            $number = intval($matche[0]);
            $number++;
            $newName = str_replace("+".$matche[0], "+".$number, $nombre);
        }else
        {
            $newName = $nombre."+1";
        }
        return $newName;
    }
}
