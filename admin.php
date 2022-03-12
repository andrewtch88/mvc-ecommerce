<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech - Admin Panel</title>
  <?php 
    include "header.php";
    include "static/pages/side_nav.html";
    include "static/pages/admin_nav.php";
    require_once "includes/class_autoloader.php";
  ?>
</head>
<body>
  <div class="grid" style="margin-top: 150px;">
    <div class="grid">
      <div>
        <div class="col s12 m6">
          <div class="card blue darken-1">
            <div class="card-content white-text">
              <span class="card-title ">SignUps</span>
              <div class="grid">
                <i class="material-icons white-text">supervisor_account</i>
                <?php 
                  $sql = "SELECT * FROM Members";
                  $conn = new Dbhandler();
                  $result = $conn->conn()->query($sql) or die($conn->conn()->error);
                  $signUpCount = $result->num_rows;
                ?>
                <div id="signup">
                  <a class='white-text'><?php echo($signUpCount); ?></a>
                </div>
              </div>
            </div>
            <div class="card-action center">
              <a href="admin_manage_users.php">View Report</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="grid">
      <div>
        <div class="col s12 m6">
          <div class="card orange darken-4">
            <div class="card-content white-text">
              <span class="card-title ">Products</span>
              <div class="grid">
                <i class="material-icons white-text">category</i>
                <?php 
                  $sql = "SELECT * FROM Items";
                  $conn = new Dbhandler();
                  $result = $conn->conn()->query($sql) or die($conn->conn()->error);
                  $productCount = $result->num_rows;
                ?>
                <p><?php echo($productCount); ?></p>
              </div>
            </div>
            <div class="card-action center">
              <a href="admin_manage_products.php">View Report</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="grid">
      <div>
        <div class="col s12 m6">
          <div class="card green darken-1">
            <div class="card-content white-text">
              <span class="card-title ">Total Orders</span>
              <div class="grid">
                <i class="material-icons white-text">add_shopping_cart</i>
                <?php 
                  $sql = "SELECT M.*, O.*, P.* FROM Members M, Orders O, Payment P
                  WHERE M.PrivilegeLevel = 0 AND P.OrderID = O.OrderID  AND M.MemberID = O.MemberID ORDER BY P.PaymentDate DESC";
                  $conn = new Dbhandler();
                  $result = $conn->conn()->query($sql) or die($conn->conn()->error);
                  $orderCount = $result->num_rows;
                ?>
                <div id="order">
                  <a class='white-text'><?php echo($orderCount); ?></a>
                </div>
              </div>
            </div>
            <div class="card-action center">
              <a href="admin_view_orders.php">View Report</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="grid">
      <div>
        <div class="col s12 m6">
          <div class="card red lighten-1">
            <div class="card-content white-text">
              <span class="card-title ">Today's Orders</span>
              <div class="grid">
                <i class="material-icons white-text">add_shopping_cart</i>
                <?php 
                  $sql = "SELECT M.*, O.*, P.* FROM Members M, Orders O, Payment P
                    WHERE M.PrivilegeLevel = 0 AND P.OrderID = O.OrderID  AND M.MemberID = O.MemberID 
                    AND P.PaymentDate = CURDATE() ORDER BY P.PaymentDate DESC";

                  $conn = new Dbhandler();
                  $result = $conn->conn()->query($sql) or die($conn->conn()->error);
                  $orderCountNew = $result->num_rows;
                ?>
                <div id="order1">
                  <?php 
                    if ($orderCountNew === 1)
                      echo("<a class='white-text' style='margin-left: 10px'>1 New ~</a>");

                    else if ($orderCountNew > 1) echo("<a class='white-text' style='margin-left: 10px'>$orderCountNew</a><a class='white-text bold' style='margin-left: 5px'>New</a>");

                    else echo("<a class='white-text' style='margin-left: 10px'>$orderCountNew</a>");
                  ?>
                </div>
              </div>
            </div>
            <div class="card-action center">
              <a href="admin_view_orders.php">Manage</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="container">
      <div class="grid">
        <div class="card amber darken-2" style="width: 800px">
          <div class="card-content white-text">
            <span class="card-title ">Product Reviews</span>
              <a href="#"><div id="bordershadow"><i class="material-icons white-text" style="margin-right: 10px">border_color</i>New Comment - 21 days ago</div></a>
            </div>
            <ul class="pagination">
              <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
              <li class="active"><a href="#!">1</a></li>
              <li class="waves-effect"><a href="#!">2</a></li>
              <li class="waves-effect"><a href="#!">3</a></li>
              <li class="waves-effect"><a href="#!">4</a></li>
              <li class="waves-effect"><a href="#!">5</a></li>
              <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<script type="text/javascript">
  $(document).ready(function(){
    autoSyncTotalOrder();
    autoSyncTodayOrder();
    autoSyncTotalSignUp();
  });

  function autoSyncTotalOrder(){
    $("#order").load(location.href + " #order", function(){
      setTimeout(autoSyncTotalOrder, 3000);
    });
  }

  function autoSyncTodayOrder(){
    $("#order1").load(location.href + " #order1", function(){
      setTimeout(autoSyncTotalOrder, 3000);
    });
  }

  function autoSyncTotalSignUp(){
    $("#signup").load(location.href + " #signup", function(){
      setTimeout(autoSyncTotalSignUp, 3000);
    });
  }
</script>
</html>