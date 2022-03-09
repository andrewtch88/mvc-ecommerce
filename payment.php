<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech PC - Payment</title>
  <?php 
    include "header.php"; 
    require_once "includes/class_autoloader.php";
  ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<body>
  <div class="container">
    <div class="col s12" style="margin-bottom: 50px;">
      <?php include "static/pages/cart_items.php"; ?>
    </div>
    <div class="selectable-card grey darken-4" id="no-hover">
      <div class="row">
        <h4 class="orange-text bold" style="padding-top: 10px;">Payment</h4>
      </div>

      <form class="row white-text"
        action="payment.php?order_id=<?php echo($_GET["order_id"]) ?>&member_id=<?php echo($_GET["member_id"]) ?>&view_order=1"
        method="POST" style="margin-left: 50px;">
        <div class="col s8">
          <div class="row">
            <div class="input-field col s6">
              <i class="material-icons prefix">account_circle</i>
              <input id="name" type="text" placeholder="XXX XXX XXX" name="card_name" class="validate white-text">
              <label class="active cyan-text" for="name">Name on Card</label>
              <span class="helper-text grey-text" data-error="CardHolder Name" data-success="CardHolder Name"></span>
            </div>

            <div class="input-field col s6">
              <i class="material-icons prefix">badge</i>
              <input placeholder="0000 0000 0000 0000" id="card_number" name="card_number" type="text" class="validate white-text">
              <label class="active cyan-text" for="card_number">Card Number</label>
              <span class="helper-text grey-text" data-error="Invalid Card Number" data-success="Valid Card Number"></span>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s4">
              <i class="material-icons prefix">date_range</i>
              <input id="exp_month" type="tel" name="exp_month" class="validate white-text">
              <label for="exp_month">Exp Month</label>
              <span class="helper-text grey-text" data-error="Invalid Exp Month" data-success="Valid Exp Month"></span>
            </div>
            <div class="input-field col s4">
              <i class="material-icons prefix">event</i>
              <input id="exp_year" type="tel" name="exp_year" class="validate white-text">
              <label for="exp_year">Exp Year</label>
              <span class="helper-text grey-text" data-error="Invalid Exp Year" data-success="Valid Exp Year"></span>
            </div>
            <div class="input-field col s4">
              <i class="material-icons prefix">confirmation_number</i>
              <input id="cvv" type="tel" name="cvv" class="validate white-text">
              <label for="cvv">CVV</label>
              <span class="helper-text grey-text" data-error="Invalid CVV" data-success="Valid CVV"></span>
            </div>
          </div>

          <div class="row">
            <div class="input-field">
              <i class="material-icons prefix">home</i>
              <textarea placeholder="House No, Street, District, Zip, State" id="home"
                class="materialize-textarea white-text"
                name="address" type="text" class="validate white-text"></textarea>
              <label class="active cyan-text" for="home">Billing Address</label>
              <span class="helper-text grey-text" data-error="Invalid Address" data-success="Valid Address"></span>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s4">
              <i class="material-icons prefix">contact_phone</i>
              <input id="phone" type="text" name="phone" class="validate white-text">
              <label for="phone">Phone number</label>
              <span class="helper-text grey-text" data-error="Invalid Number" data-success="Valid Number"></span>
            </div>
            <div class="input-field col s4">
            <i class="material-icons prefix">map</i>
              <input id="state" type="text" name="state" class="validate white-text">
              <label for="state">State</label>
              <span class="helper-text grey-text" data-error="Invalid State" data-success="Valid State"></span>
            </div>
            <div class="input-field col s4">
            <i class="material-icons prefix">place</i>
              <input id="zip" type="text" name="zip" class="validate white-text">
              <label for="zip">Zip</label>
              <span class="helper-text grey-text" data-error="Invalid Zip Code" data-success="Valid Zip Code"></span>
            </div>
          </div>
          <div class="errormsg">
            <?php
              if (isset($_GET["error"]))
              {
                if ($_GET["error"] == "empty_input")
                  echo "<p>*Fill in all fields!<p>";
              }
            ?>
          </div>
          <button type="submit" name="payment" class="btn" style="margin-bottom: 20px;">Confirm Payment</button>
        </div>
        <div class="col s4">
          <div class="rounded-card tint-glass-black" style="margin-top: 100px;">
            <div class="card-content">
              <label class="bold white-text" style="font-size: 24px;">Accepted Cards</label>
              <div style= 'margin-bottom: 20px; padding: 7px 0; font-size: 40px;'>
                <i class="fa fa-cc-visa payable-cards" style="color: navy;"></i>
                <i class="fa fa-cc-amex payable-cards" style="color: blue;"></i>
                <i class="fa fa-cc-mastercard payable-cards" style="color: red;"></i>
                <i class="fa fa-cc-discover payable-cards" style="color: orange;"></i>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>

<?php
  function EmptyInputPayment($name, $number, $month, $year, $cvv, $address, $phone, $state, $zip)
  { return empty($name) || (empty($number)) || (empty($month)) || (empty($year)) || (empty($cvv)) 
    || (empty($address)) || (empty($phone)) || (empty($state)) || (empty($zip)); }

  if (isset($_POST["payment"])) 
  {
    $name = $_POST["card_name"];
    $number = $_POST["card_number"];
    $month = $_POST["exp_month"];
    $year = $_POST["exp_year"];
    $cvv = $_POST["cvv"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];

    if (EmptyInputPayment($name, $number, $month, $year, $cvv, $address, $phone, $state, $zip))
    {
      $orderID = $_GET["order_id"];
      $memberID = $_GET["member_id"];
      echo("<script>location.href = 'payment.php?error=empty_input&order_id=$orderID&member_id=$memberID&view_order=1';</script>");
      exit();
    }

    if (isset($_GET["order_id"]))
    {
      $orderid = $_GET["order_id"];
      $conn = new Dbhandler();

      $itemID = $item->getItemID();
      $item = new Item($itemID);
      $quantityInStock = $item->getQuantityInStock();
      $quantity = $orderItem->getQuantity();

      $item->setQuantityInStock($quantityInStock - $quantity);
      $item->setData();

      $sql = "INSERT INTO Payment(OrderID, PaymentDate)
        VALUES($orderid, CURRENT_TIME)";
      $conn->conn()->query($sql) or die($conn->error);


      $sql = "UPDATE Orders SET CartFlag = 0 WHERE OrderID = $orderid";
      $conn->conn()->query($sql) or die($conn->error);

      $sql = "INSERT INTO Orders(MemberID, CartFlag)
        VALUES($memberID, 1)";
      $conn->conn()->query($sql) or die($conn->error);
      
      echo("<script>location.href = 'payment_done.php';</script>");
      exit();
    }
  }
?>

<?php include "footer.php"; ?>
</html>