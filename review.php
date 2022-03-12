<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Make your review</title>
  <?php
    include "header.php";
    require_once "includes/class_autoloader.php";
    require_once "includes/review.inc.php";

    $orderItemID = $_GET["review_item"];
    $conn = new Dbhandler();

    if (isset($orderItemID))
    {
      $sql = "SELECT I.Image, I.Name from Items I, OrderItems O, Items WHERE O.OrderItemID = $orderItemID AND I.ItemID = O.ItemID";
      $result = $conn->conn()->query($sql) or die($conn->conn()->error);
      $row = $result->fetch_assoc();
      $image = $row["Image"];
      $name = $row["Name"];
    }
  ?>
</head>
<body>
  <div class="container" style="margin-top: 50px;">
    <div class="rounded-card-parent">
      <div class="card rounded-card">
        <a href='cart.php?member_id=<?php echo($memberID); ?>'><i class="material-icons">arrow_back</i></a>
        <h5 class="orange-text bold"><?php echo($name) ?></h5>
      </div>
    </div>
</body>
</html>