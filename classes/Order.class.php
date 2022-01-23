<?php

class Order extends Dbhandler{
  private $orderID;
  private $orderItems;

  // update order items related to this order
  protected function updateOrderItems() {
    $sql = "SELECT OrderItemID FROM OrderItems WHERE ORDERID = '$this->orderID'";
    $result = $this->conn()->query($sql) or die($this->conn()->error);

    // create multiple OrderItem instances
    $this->orderItems = array();
    while ($row = $result->fetch_assoc())
      array_push($this->orderItems, new OrderItem($row["OrderItemID"]));
  }

  public function getOrderID() { return $this->orderID; }
  public function getOrderItems() { return $this->orderItems; }
}