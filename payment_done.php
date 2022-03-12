<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech - Thank you</title>
  <?php include "header.php"; ?>
</head>
<body>
  <div class="container center-align" style="margin-top: 100px;">
    <div class="rounded-card-parent" style="margin-right: 200px; margin-left: 200px;">
      <div class="rounded-card card-content">
        <h4 class="page-title green-text">We received your payment.</h4>
        <p>Thank you for your purchase. Your ordered items will be delivered accordingly. Please come again.</p>
        <div class="card-action" style='margin-top: 50px'>
          <a class="white-text btn" href="index.php">Return to Home Page</a>
          <a style='margin-left: 20px' class="white-text btn" href='cart.php?member_id=<?php echo($memberID); ?>'>Back to Cart</a>
        </div>
      </div>
    </div>
  </div>

</body>
<?php include "footer.php"; ?>
</html>