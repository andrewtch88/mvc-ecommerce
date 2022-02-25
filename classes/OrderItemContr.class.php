<?php

class OrderItemContr extends Dbhandler{
  private $orderItemID;
  private $itemID;
  private $price;
  private $quantity;
  private $addedDateTime;

  function __construct($orderItemID)
  {
    $this->orderItemID = $orderItemID;
    $this->initData();
  }

  protected function initData() {
    $sql = "SELECT * FROM OrderItems WHERE OrderItemID = $this->orderItemID";
    $result = $this->conn()->query($sql) or die($this->conn()->error);
    $row = $result->fetch_assoc();
    $this->itemID = $row["ItemID"];
    $this->price = $row["Price"];
    $this->quantity = $row["Quantity"];
    $this->addedDateTime = $row["AddedDatetime"];
  }

  protected function deleteOrders() {
    $sql = "DELETE * FROM OrderItems WHERE OrderItemID = ?";
    $stmt = $this->conn()->prepare($sql);
    $stmt->execute($this->orderItemID);
    
    mysqli_stmt_close($stmt);
    return $stmt;
  }

  public function getOrderItemID() { return $this->orderItemID; }
  public function getItemID() { return $this->itemID; }
  public function getPrice() { return $this->price; }
  public function getQuantity() { return $this->quantity; }
  public function getAddedDateTime() { return $this->addedDateTime; }
}