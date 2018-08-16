<?php
  class ShoppingCart {
   
     private $productList = array();
      
     function setPricing($productName, $price){
      $this->productList[$productName] = new Product($price);
     }
     
     function setVolumePricing($productName, $volumeQuantity, $volumePrice){
      if($this->isProductExist($productName)){
       $this->productList[$productName]->setVolumePricing($volumeQuantity, $volumePrice); 
      }
     }
     
     function scan($productName){
      if(!$this->isProductExist($productName)){
       return;
      }
      $this->productList[$productName]->scan($productName);
     }
     
     function total(){
      $total = 0;
      foreach ($this->productList as $value) {
           $total = $total + $value->getTotal();
      }
      
      print $total;
     }
     
     private function isProductExist($productName){
      return array_key_exists($productName, $this->productList);
     }
  }

  class Product{
    
    private $singleUnitPrice = 0;
    private $volumePrice = 0;
    private $volumeQuantity = 0;
    private $totalPrice = 0;
    private $totalQuantity = 0;
    
    function __construct($singleUnitPrice){
     $this->singleUnitPrice = $singleUnitPrice;
    }
    
    function setVolumePricing($volumeQuantity, $volumePrice){
     $this->volumeQuantity = $volumeQuantity;
     $this->volumePrice = $volumePrice;
    }
    
    function scan($productName){
     
     $this->totalQuantity += 1;

     $price = $this->totalPrice + $this->singleUnitPrice;

     if($this->volumeQuantity > 0){
      if($this->totalQuantity >= $this->volumeQuantity){
       $r = $this->totalQuantity % $this->volumeQuantity;
       $d = floor($this->totalQuantity / $this->volumeQuantity);
       $p = $d * $this->volumePrice;
       $rp = $r * $this->singleUnitPrice;
       $price = $p + $rp;
      }
     }

     $this->totalPrice = $price;
    }
    
    function getTotal(){
     return $this->totalPrice; 
    }
   }


//Sample Test case
$cart = new ShoppingCart();
$cart->setPricing('A', 2);
$cart->setVolumePricing('A', 4, 7);
$cart->setPricing('B', 12);
$cart->setPricing('C', 1.25);
$cart->setVolumePricing('C', 6, 6);
$cart->setPricing('D', 0.15);
$cart->scan('A');
$cart->scan('B');
$cart->scan('C');
$cart->scan('D');
$cart->total();

 ?>