<?php 

class OrderContr extends Order {
  
  function __construct($orderID) {
    $this->orderID = $orderID;
    $this->updateOrderItems();
  }
}