<?php


namespace Practica\ProductSpecialPrice\Block;

use Magento\Customer\Model\Session;
use Magento\Catalog\Block\Product\View\AbstractView;
use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;

class ProductSpecialPrice extends Template
{
    protected $customerSession;
    protected $currentProduct;
    protected $registry;

    /**
     * @var int
     */
    private int $discount;
    /**
     * @param Template\Context $context
     * @param Session  $customerSession
     * @param Product  $currentProduct
     * @param array $data
     * @return void
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Session $customerSession,
        //Product $currentProduct,
        \Magento\Framework\Registry $registry,
        array $data = []
    ){
        $this->customerSession = $customerSession;
        //$this->currentProduct = $currentProduct;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isLoggendIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    /**
     * @return bool
     */
    public function showSpecialPrice()
    {
        if(!$this->isLoggendIn())
        {
            return false;
        }

        $this->currentProduct = $this->registry->registry('product');
        //$specialPrice= $this->currentProduct->getSpecialPrice();
        $specialPrice= $this->currentProduct->getFinalPrice();
        $specialFromDate = $this->currentProduct->getSpecialFromDate();
        $SpecialToDate = $this->currentProduct->getSpecialToDate();
        $currentDate = time();

        if(is_null($specialPrice) || is_null($specialFromDate))
        {
            return false;
        }

        if($specialPrice <= 0)
        {
            return false;
        }

        $this->discount = floor(100 - (($specialPrice * 100) / $this->currentProduct->getPrice()));

        return  $this->discount > 0 && strtotime($specialFromDate) < $currentDate && (is_null($SpecialToDate) || $currentDate < strtotime($SpecialToDate) );
    }

    /**
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerSession->getCustomer()->getFirstname();
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    public function getDiscountMessage()
    {
        "<p> $this->getCustomerName()! esta oferta es especial para vos! disfruta de un $this->discount% de descuento</p>";
    }
}
