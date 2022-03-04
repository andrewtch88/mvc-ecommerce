<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php 
    include "header.php";
    require_once "includes/class_autoloader.php";
    require_once "includes/product_catalogue.inc.php";
    $conn = new Dbhandler();

    if (isset($_GET["item_id"]))
    {
      $itemID = $_GET["item_id"];
      $item = new Item($itemID);

      $name = $item->getName(); 
    }
  ?>
  <title>OG Tech PC — <?php echo htmlspecialchars($name) ?></title>
</head>
<body>
  <?php 

    if (isset($_GET["item_id"])){
      $itemID = $_GET["item_id"];
      
      $image = $item->getImage();
      $brand = $item->getBrand();
      $description = $item->getDescription();
      $quantityInStock = $item->getQuantityInStock();
      $price = $item->getSellingPrice();
      $displayPrice = "RM" . number_format($price, 2);
      $category = $item->getCategory();
      $category = Item::CATEGORY[$category];

      $hasReviews = $item->HasReviews();
      $avgRatings = $item->getAvgRatings();

      // set amount of items to add into cart
      $cartQty = 0;
      if (isset($_GET["qty"])) $cartQty = $_GET["qty"];
      if ($cartQty > 0){
        // add into cart if qty in stock is larger than requested quantity
        if ($quantityInStock >= $cartQty){
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

          header("location: product.php?item_id=$itemID");
          exit();
        }
      }
    } else die("<h5 class='container white-text page-title' style='margin-top: 50px'>No item selected...</h5>");
  ?>

<input type="hidden" id="max-quantity" value=<?php echo($quantityInStock) ?>>
<div class="container" style="margin-top: 50px;">
  <div class="rounded-card-parent">
    <div class="card rounded-card">
      <a class="btn red darken-2" href="product_catalogue.php?query=" style='margin-left: 20px'>
        < BACK TO CATALOGUE</a>
      <form action="product.php" method="GET" style="padding-left: 10px;">
        <input type="hidden" name="item_id" value=<?php echo($itemID) ?>>
        <div class="row">
          <div class="col s4">   
            <img class="shadow-img" src="product_images/<?php echo($image); ?>"
              style="max-height: 350px; max-width: 350px; margin-top: 30px">
          </div>
          <div class="col s8">
            <div class="row">
              <table class="responsive-table">
                <tbody>
                  <tr><h4 class="white-text"><?php echo($name); ?></h4></tr>
                  <tr>
                    <!-- product details -->
                    <?php
                      if ($hasReviews)
                      {
                        $intRating = $avgRatings * 5 / 100;
                        echo(
                          "$intRating.0
                          <div class='ratings'>
                            <div class='empty-stars'></div>
                            <div class='full-stars' style='width: $avgRatings%'></div>
                          </div>"
                        );
                      } else echo("-")
                    ?>
                    |
                    <?php   
                      if ($hasReviews)
                      {
                        $reviews = $item->GetReviews();
                        $reviewCount = count($reviews);
                        echo(
                          "$reviewCount Ratings"
                        );
                      } else echo("No ratings yet")
                    ?>
                    |
                    <?php
                      if ($item->checkSoldCount()){
                        echo($item->checkSoldCount());
                        echo(" Sold");
                      }
                      else echo("0 Sold");
                    ?>
                    <!-- product details end -->
                  </tr>
                  <h4 class="amber-text"><?php echo($displayPrice); ?></h4>
                  <tr><th class='grey-text'>Brand: </th><td><?php echo($brand); ?></td></tr>
                  <tr><th class='grey-text'>Description: </th><td><?php echo($description); ?></td></tr>
                  <tr><th class='grey-text'>Category: </th><td><?php echo($category); ?></td></tr>
                </tbody>
              </table>
            </div>

            <div class="row input-field grid">
              <a style="margin-right: 10px"><p class="grey-text">Quantity:</p></a>          
              <button type="button" class="btn-small waves-effect waves-light red"
                onclick="subtractQty()">
                <i class="material-icons">remove</i>
              </button>

              <input id="qty" class="white-text" type="number" disabled
                style="padding: 10px; width: 3%;" value=0></input>
              <input id="sync-qty" name="qty" class="white-text" type="hidden" value=0></input>

              <button type="button" class="btn-small waves-effect waves-light green"
                onclick="addQty()">
                <i class="material-icons">add</i>
              </button>
              <?php 
              if ($quantityInStock < 6) echo("<a class='red-text' style='margin-left: 10px'>$quantityInStock items left!</a>"); 
              else echo("<a class='grey-text' style='margin-left: 10px'>$quantityInStock items left</a>");          
              ?>
            </div>
            <div class="row grid" style="margin-right: 10px">
              <button type="submit" class="btn waves-effect waves-light" onclick="return addToCart()">
                <a class="white-text">
                  <i class="material-icons right">shopping_cart</i>
                  Add To Cart
                </a>
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>