<?php 

function buyOrCart($conn, $quantityInStock, $cartQty, $itemID, $price, $cart){
  // add into cart if qty in stock is larger than requested quantity
  if ($quantityInStock >= $cartQty){
    if (isset($_SESSION["Member"])) 
    {
      $orderID = $cart->getOrderID();
      // check if order has been added before
      $sql = "SELECT OrderItemID, Quantity FROM OrderItems WHERE OrderID = $orderID AND ItemID = $itemID";
      $result = $conn->conn()->query($sql) or die($conn->conn()->error);
      $row = $result->fetch_assoc();
      $orderItemID = $row["OrderItemID"];

      if ($orderItemID == NULL)
      {
        // add as new order
        $sql = "INSERT INTO OrderItems(OrderID, ItemID, Price, Quantity, AddedDatetime)
          VALUES ($orderID, $itemID, $price, $cartQty, CURRENT_TIME)";
        $conn->conn()->query($sql) or die($conn->conn()->error);
      } else
      {
        $cartQty += $row["Quantity"];
        $sql = "UPDATE OrderItems SET Quantity = $cartQty";
        $conn->conn()->query($sql) or die($conn->conn()->error);
      }
    }
    else {
      echo ("<script>alert('Login to add to cart.');</script>");
      echo ("<script>window.location.href='login.php';</script>");
    }
  }
}