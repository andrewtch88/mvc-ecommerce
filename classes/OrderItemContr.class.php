<?php

class OrderItemContr extends OrderItem{

  function __construct($orderItemID)
  {
    $this->orderItemID = $orderItemID;
    $this->initData();
  }
}