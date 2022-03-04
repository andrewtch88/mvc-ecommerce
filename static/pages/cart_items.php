<?php

  require_once "includes/order.inc.php";
  require_once "includes/class_autoloader.php";

  if (isset($_GET["member_id"]))
  {
    $memberID = $_GET["member_id"];
    $member = Member::CreateMemberFromID($memberID);
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
          if ($cartItemCount <= 0) 
            echo("<h5 class='grey-text page-title'>Your shopping cart is empty.</h5><h6 class='grey-text page-title'>
              <a href='product_catalogue.php?query='>Shop Now!</a></h6>");

          $sumTotal = 0;
          for ($c=0; $c < $cartItemCount; $c++)
          {
            $orderItem = $cartItems[$c];
            $item = new Item($orderItem->getItemID());
            generateItem($item, $orderItem, $memberID);

            $quantity = $orderItem->getQuantity();
            $price = $orderItem->getPrice();
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
                echo("<tr><th>Enter voucher code:</th>
                  <td>
                    <form id='form-filter' method='GET'>
                      <ul id='filter_dropdown' class='dropdown-content black'>
                        <li><a class='cyan-text page-title' onclick='select_category(this)'>Clear</a></li>
                        <li><a class='cyan-text page-title' onclick='select_category(this)'>PC Packages</a></li>
                        <li><a class='cyan-text page-title' onclick='select_category(this)'>Monitor & Audio</a></li>
                        <li><a class='cyan-text page-title' onclick='select_category(this)'>Peripherals</a></li>
                      </ul>
                      <a class='btn dropdown-trigger cyan' data-target='filter_dropdown' style='margin-top: 5px;'>
                        <?php
                          if (!= -1) echo(CATEGORY_NAMES[]);
                          else echo('Select Voucher');
                        ?>
                        <i class='material-icons right'>arrow_drop_down</i>
                      </a>
                    </form>
                  </td></tr>");
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