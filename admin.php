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
                <p>11</p>
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
                <p>100</p>
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
                <p>1000</p>
              </div>
            </div>
            <div class="card-action">
              <a href="#">Learn More</a>
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
              <span class="card-title ">Emails</span>
              <div class="grid">
                <i class="material-icons white-text">email</i>
                <p>0</p>
              </div>
            </div>
            <div class="card-action">
              <a href="#">Learn More</a>
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