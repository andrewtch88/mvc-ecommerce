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
                <p><?php echo($signUpCount); ?></p>
              </div>
            </div>
            <div class="card-action">
              <a href="admin_manage_users.php">Learn More</a>
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
            <div class="card-action">
              <a href="admin_manage_products.php">Learn More</a>
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
              <span class="card-title ">Orders</span>
              <div class="grid">
                <i class="material-icons white-text">add_shopping_cart</i>
                <?php 
                  $sql = "SELECT * FROM Orders WHERE CartFlag = 0";
                  $conn = new Dbhandler();
                  $result = $conn->conn()->query($sql) or die($conn->conn()->error);
                  $orderCount = $result->num_rows;
                ?>
                <p><?php echo($orderCount); ?></p>
              </div>
            </div>
            <div class="card-action">
              <a href="admin_view_orders.php">Learn More</a>
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
              <span class="card-title ">Report</span>
              <div class="grid">
                <i class="material-icons white-text">email</i>
                <p>0</p>
              </div>
            </div>
            <div class="card-action">
              <a href="admin_report.php">Learn More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="container">
      <div class="grid">
        <div class="card amber darken-2" style="width: 770px">
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
</html>