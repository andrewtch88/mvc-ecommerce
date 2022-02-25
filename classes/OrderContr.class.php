<?php 

class OrderContr extends Dbhandler {
  private $orderID;
  /** @var OrderItemContr[] $orderItems */
  private $orderItems;

  function __construct($orderID) {
    $this->orderID = $orderID;
    $this->updateOrderItems();
  }

  // update order items related to this order
  protected function updateOrderItems() {
    $sql = "SELECT OrderItemID FROM OrderItems WHERE ORDERID = '$this->orderID'";
    $result = $this->conn()->query($sql) or die($this->conn()->error);

    // create multiple OrderItem instances
    $this->orderItems = array();
    while ($row = $result->fetch_assoc())
      array_push($this->orderItems, new OrderItemContr($row["OrderItemID"]));
  }

  public function getOrderID() { return $this->orderID; }
  public function getOrderItems() { return $this->orderItems; }
}