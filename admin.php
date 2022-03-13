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
  <div class="grid" style="margin-top: 100px;">
    <div class="grid">
      <div style="width: 198px; height: 238px">
        <div class="col s12 m6">
          <div class="card blue darken-1">
            <div class="card-content white-text" style="width: 198px; height: 160px">
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
      <div style="width: 198px; height: 238px">
        <div class="col s12 m6">
          <div class="card amber darken-4">
            <div class="card-content white-text" style="width: 198px; height: 160px">
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
      <div style="width: 198px; height: 238px">
        <div class="col s12 m6">
          <div class="card green darken-1">
            <div class="card-content white-text" style="width: 198px; height: 160px">
              <span class="card-title ">Total Orders</span>
              <div class="grid">
                <i class="material-icons white-text">shopping_cart</i>
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
              <span class="card-title">Today's Orders</span>
              <div class="grid">
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
                      echo("
                        <a class='btn-floating cyan pulse'><i class='material-icons'>add_shopping_cart</i></a>
                        <a class='white-text' style='margin-left: 10px'>1 New ~</a>
                        ");

                    else if ($orderCountNew > 1) echo(
                      "<a class='btn-floating cyan pulse'><i class='material-icons'>add_shopping_cart</i></a>
                      <a class='white-text' style='margin-left: 10px'>$orderCountNew</a><a class='white-text bold' style='margin-left: 5px'>New</a>
                      ");

                    else echo("
                      <i class='material-icons white-text'>add_shopping_cart</i>
                      <a class='white-text' style='margin-left: 10px'>$orderCountNew</a>");
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
        <div class="rounded-card-parent">
          <div class="rounded-card amber darken-2" style="width: 910px">
            <div class="card-content white-text">
              <table class="responsive-table center" id="pagination">
                <thead class="text-primary center">
                  <tr>
                    <h5 class="white-text bold" style="padding-bottom: 20px">Product Reviews</h5>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $oper = new adminContr;
                    $oper->showReviews();
                  ?>
                </tbody>
              </table>
              <div class="col-md-12 center text-center">
                <span class="left" id="total_reg"></span>
                <ul class="pagination pager" id="myPager"></ul>
              </div>
            </div>
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

    $('#pagination').pageMe({
      pagerSelector:'#myPager',
      activeColor: 'blue',
      prevText:'Previous',
      nextText:'Next',
      showPrevNext:true,
      hidePageNumbers:false,
      perPage:5
    });
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