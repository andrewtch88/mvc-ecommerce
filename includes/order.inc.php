<?php 

require_once "class_autoloader.php";

/**
 * @param Item
 * @param OrderItemContr $cartItem
 * @param int $memberID
*/

function generateOrderDetails($item, $cartItem){
  $itemID = $item->getItemID();
  $quantityInStock = $item->getQuantityInStock();
  $itemName = $item->getName();
  $categoryIdx = $item->getCategory();
  $icon = Item::CATEGORY_ICON[$categoryIdx];
  $categoryName = Item::CATEGORY[$categoryIdx];
  $dbh = new Dbhandler();

  $sql = "SELECT I.Image from Items I WHERE I.ItemID = $itemID";
  $result = $dbh->conn()->query($sql) or die($dbh->conn()->error);
  $row = $result->fetch_assoc();
  $image = $row["Image"];

  $dateAdded = $cartItem->getAddedDateTime();
  $price = $cartItem->getPrice();
  $price = "RM" . $price;
  $quantity = $cartItem->getQuantity();
  $quantityDisplay = "x" . $quantity;
  $orderItemID = $cartItem->getOrderItemID();
  
  return [$itemID, $quantity, $quantityInStock, $icon, $image, $itemName, $price, $quantityDisplay, $orderItemID, $dateAdded,  $categoryName];
}

function generateItem($item, $cartItem, $memberID){

  // admin view orders
  [$itemID, $quantity, $quantityInStock, $icon, $image, $itemName, $price, $quantityDisplay, $orderItemID, $dateAdded,  $categoryName] 
    = generateOrderDetails($item, $cartItem);

  $view_order = isset($_GET["view_order"]);
  echo(
    "<li>
      <form method='GET' class='collapsible-header collapsible-card bold'>
        <input type='hidden' name='member_id' value=$memberID>
        <input type='hidden' name='item_id' value=$itemID>
        <input type='hidden' name='qty' value=$quantity>
        <input type='hidden' name='qty_stock' value=$quantityInStock>
        <i class='material-icons'>$icon</i>

        <p class='col s4' style='padding: 0px; margin: 0px;'>
          <img class='shadow-img' src='product_images/$image'
            style='max-height: 50px; max-width: 50px;'>
        </p>
        <p class='col s4' style='padding: 0px; margin: 0px;'>$itemName</p>
        <p class='col s3' style='padding: 0px; margin: 0px;'>$price</p>
        <p class='col s3' style='padding: 0px; margin: 0px;'>$quantityDisplay</p>

        <a class='btn orange darken-4 col s2 light-weight-text' style='margin-right: 5px; padding: 0px;'
          href='item_page.php?item_id=$itemID'>
          Inspect
        </a>"
  );

  if (!$view_order)
  {
    echo(
          "<button class='btn red darken-4 col s2' style='padding: 0px; margin: 0px;'
            name='remove_item' value='$orderItemID'
            onclick=\"return confirm('Are you sure you want remove \'$itemName\'?');\">
            Remove
          </button>"
    );
  }
  echo(
    "</div>
    <div class='collapsible-body row collapsible-card bold' style='margin: 0px;'>
      <div class='col s6'>
        <span>Date Added:</span>
        <span class='light-weight-text'>$dateAdded</span>
      </div>
      <div class='col s6'>
        <span>Category:</span>
        <span class='light-weight-text'>$categoryName</span>
      </div>
    </div>
  </li>"
  );
}

function generateBoughtItem($item, $cartItem){
  $sql = "SELECT P.OrderID, P.PaymentDate, OI.OrderID FROM Payment P, OrderItems OI
  WHERE P.OrderID = OI.OrderID";
  $dbh = new Dbhandler();
  $result = $dbh->conn()->query($sql);
  while ($row = $result->fetch_assoc()) {
    $paymentDate = $row["PaymentDate"];
  }

  [$itemID, $quantity, $quantityInStock, $icon, $image, $itemName, $price, $quantityDisplay, $orderItemID, $dateAdded,  $categoryName] 
    = generateOrderDetails($item, $cartItem);

  $view_order = isset($_GET["view_order"]);

  echo(
    "<li>
      <div class='collapsible-header collapsible-card bold'>
        <i class='material-icons'>$icon</i>

        <p class='col s4' style='padding: 0px; margin: 0px;'>$itemName</p>
        <p class='col s3' style='padding: 0px; margin: 0px;'>$price</p>
        <p class='col s3' style='padding: 0px; margin: 0px;'>$quantityDisplay</p>
        <a class='btn orange darken-4 col s2 light-weight-text' style='margin-right: 5px; padding: 0px;'
            href='item_page.php?item_id=$itemID'>
            Inspect
        </a>"
  );

  if (!$view_order)
  {
    echo(
          "<a class='btn cyan darken-4 col s2' style='padding: 0px; margin: 0px;'
            href='review.php?review_item=$orderItemID'>
            Review
          </a>"
    );
  }
  echo(
      "</div>
      <div class='collapsible-body row collapsible-card bold' style='margin: 0px;'>
        <div class='col s6'>
          <span>Paid:</span>
          <span class='light-weight-text'>$paymentDate</span>
        </div>
        <div class='col s6'>
          <span>Category:</span>
          <span class='light-weight-text'>$categoryName</span>
        </div>
      </div>
    </li>"
  );
}

function generateOrderSum($totalItems, $sumTotal)
{
  echo(
    "<div class='col s4'>
      <div class='rounded-card-parent'>
        <div class='card rounded-card tint-glass-brown'>
          <div class='card-content white-text'>
            <span class='card-title bold'>Order Details</span>
            <table class='responsive-table'>
              <tbody>
                <tr><th>Total Items:</th><td>$totalItems</td></tr>
                <tr><th>Delivery Charges:</th><td>RM10.00</td></tr>
                <tr><th>Sum Total:</th><td>RM$sumTotal</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>"
  );
}