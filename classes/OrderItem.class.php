<?php

class OrderItem extends Dbhandler{
  private $orderItemID;
  private $itemID;
  private $price;
  private $quantity;
  private $addedDateTime;

  protected function initData() {
    $sql = "SELECT * FROM OrderItems WHERE OrderItemID = $this->orderItemID";
    $result = $this->connect()->query($sql) or die($this->connect()->error);
    $row = $result->fetch_assoc();
    $this->itemID = $row["ItemID"];
    $this->price = $row["Price"];
    $this->quantity = $row["Quantity"];
    $this->addedDateTime = $row["AddedDatetime"];
  }

  protected function DeleteOrders() {
    $sql = "DELETE * FROM OrderItems WHERE OrderItemID = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute($this->orderItemID);
    
    mysqli_stmt_close($stmt);
    return $stmt;
  }

  public function GetOrderItemID() { return $this->orderItemID; }
  public function GetItemID() { return $this->itemID; }
  public function GetPrice() { return $this->price; }
  public function GetQuantity() { return $this->quantity; }
  public function GetAddedDateTime() { return $this->addedDateTime; }
}