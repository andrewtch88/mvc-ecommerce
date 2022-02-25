<?php

  require_once "includes/order.inc.php";
  require_once "includes/class_autoloader.php";

  if (isset($_GET["member_id"]))
  {
    $memberID = $_GET["member_id"];
    $member = Member::CreateMemberFromID($memberId);
    $cart = $member->getCart();
    $cartID = $cart->getOrderID();
    $cartItems = $cart->getOrderItems();
    $cartItemCount = count($cartItems);
  }

  if (isset($_GET["remove_item"])){
    $orderItemID = $_GET["remove_item"];
    $sql = "DELETE FROM OrderItems WHERE OrderItemID = $orderItemID";
    $conn = new Dbhandler();
    $conn->conn()->query($sql) or die($conn->conn()->error);

    $itemID = $_GET["item_id"];
    $quantity = $_GET["qty"];
    $quantityInStock = $_GET["qty_stock"];
    $quantityInStock = $quantityInStock + $quantity;
    $sql = "UPDATE Items SET QuantityInStock = $quantityInStock WHERE ItemID = $itemID";
    $conn->conn()->query($sql) or die($conn->conn()->error);
    header("location: cart.php?member_id=$memberID");
  }
?>

<h4 class="page-title">Cart</h4>
<div class="row">
  <div class="col s8">
    <ul class="collapsible popout" id="cart">
      <!-- generate all rows of items -->
      <?php
        if (isset($cartItems))
        {
          $sumTotal = 0;
          for ($c=0; $c < $cartItemCount; $c++)
          {
            $orderItem = $cartItems[$c];
            $dbh = new Dbhandler();
            $Dbh = $dbh->conn();
            $item = new Item($orderItem->GetItemID(), $Dbh);
            GenerateItem($item, $orderItem, $memberID);

            $quantity = $orderItem->GetQuantity();
            $price = $orderItem->GetPrice();
            $sumTotal = $sumTotal + $price * $quantity;
          }
          $sumTotal = number_format($sumTotal+10, 2);
        }
      ?>
    </ul>
  </div>

  <div class="col s4">
    <div class="rounded-card-parent">
      <div class="card rounded-card tint-glass-cyan blurer">
        <span class="card-title bold">Cart Details</span>
        <form action="checkout_payment.php" method="GET">
          <table class="responsive-table">
            <tbody>
              <?php
                echo("<tr><th>Total Items:</th><td>$cartItemCount</td></tr>");
                echo("<tr><th>Delivery Charges:</th><td>RM10.00</td></tr>");
                echo("<tr><th>Sum Total:</th><td>RM$sumTotal</td></tr>");
              ?>
            </tbody>
          </table>
          <?php if (!isset($_GET["view_order"]) && $cartItemCount > 0) { ?>
          <button class="btn orange darken-3" style="margin-top: 10px;">
            Checkout
          </button>
          <input type="hidden" name="order_id" value=<?php echo($cartID); ?>>
          <input type="hidden" name="view_order" value=1>
          <input type="hidden" name="member_id" value=<?php echo($memberID) ?>>
          <?php } ?>
        </form>
      </div>
    </div>
  </div>
</div>