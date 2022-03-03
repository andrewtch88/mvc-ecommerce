<?php
  require_once "includes/class_autoloader.php";
  if (isset($_GET["member_id"]))
  {
    /** @var int $memberID */
    $memberID = $_GET["member_id"];
    $member = Member::CreateMemberFromID($memberID);
    $orders = $member->getOrders();
    $orderCount = count($orders);
  }
?>

<h4 class="page-title">Payment History / Previous Orders</h4>

<?php
  if ($orderCount <= 0) 
    echo("<h5 class='grey-text page-title'>There are no orders yet. How about 
    <a href='product_catalogue.php?query='>making some orders</a>? :)</h5>");

  for ($i=0; $i < $orderCount; $i++)
  {
    $idx = $i+1;
    echo("<h5 class='white-text page-title'>#$idx</h5>");
    // row starting point
    echo("<div class='row'>");
    // prev order list starting point
    echo("<div class='col s8'> <ul class='collapsible popout' id='cart'>");

    $order = $orders[$i];
    $orderID = $order->getOrderID();
    $orderItems = $order->getOrderItems();
    $orderItemCount = count($orderItems);

    $sumTotal = 0;
    for ($o=0; $o < $orderItemCount; $o++)
    {
      $orderItem = $orderItems[$o];
      $item = new Item($orderItem->GetItemID(), $conn);
      generateBoughtItem($item, $orderItem, $memberID);

      $quantity = $orderItem->getQuantity();
      $price = $orderItem->getPrice();
      $sumTotal += $price * $quantity;
    }
    $sumTotal = number_format($sumTotal+5, 2);

    // order items list closing point
    echo("</ul></div>");

    generateOrderDetails($orderItemCount, $sumTotal);

    // row closing point
    echo("</div>");
  }