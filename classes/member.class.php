<?php

class Member {
  
  private $memberID;
  private $username;
  private $email;
  private $privilegeLevel;
  private $cart;
  private $orders;

  public function __construct($memberID, $username, $email, $privilegeLevel)
  {
    $this->memberID = $memberID;
    $this->username = $username;
    $this->email = $email;
    $this->privilegeLevel = $privilegeLevel;
    $this->updateCart();
    $this->updatePreviousOrder();
  }

  public static function CreateMemberFromID($memberID) {
    $sql = "SELECT * FROM Members WHERE MemberID = $memberID";
    $conn = new Dbhandler();
    $result = $conn->conn()->query($sql) or die($conn->conn()->error);
    $row = $result->fetch_assoc();
    $username = $row["Username"];
    $email = $row["Email"];
    $privilegeLevel = $row["PrivilegeLevel"];

    return new Member($memberID, $username, $email, $privilegeLevel);
  }

  public function updateCart() {
    $sql = "SELECT OrderID FROM Orders WHERE MemberID = $this->memberID AND CartFlag = 1";
    $conn = new Dbhandler();
    $result = $conn->conn()->query($sql);
    $row = $result->fetch_assoc();
    $this->cart = new OrderContr($row["OrderID"]);
  }

  public function updatePreviousOrder() {
    $sql = "SELECT OrderID FROM Orders WHERE MemberID = $this->memberID AND CartFlag = 0";
    $conn = new Dbhandler();
    $result = $conn->conn()->query($sql);

    $this->orders = array();
    while ($row = $result->fetch_assoc())
      array_push($this->orders, new OrderContr($row["OrderID"]));
  }

  public function getMemberID() { return $this->memberID; }
  public function getUsername() { return $this->username; }
  public function getEmail() { return $this->email; }
  public function getPrivilegeLevel() { return $this->privilegeLevel; }
  public function getCart() { return $this->cart; }
  public function getOrders() { return $this->orders; }

  public function setUsername($username) { $this->username = $username; }
  public function setEmail($email) { $this->email = $email; }
}