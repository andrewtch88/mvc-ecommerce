<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech PC - Manage Products Panel</title>
  <?php
    include "header.php"; 
    include "static/pages/side_nav.html";
    include "static/pages/admin_nav.php";
  ?>
</head>
<body>
  <div class="container" style="margin-top: 150px">
    <h3 class="page-title">Manage Products</h3>

    <div class="blue darken-4 rounded-card-parent center" style="margin-bottom: 100px">
      <div class="card rounded-card">
        <div class="card-content black-text">
          <span class="orange-text bold" style="font-size: 24px">Products List</span>

          <!-- search product input field start -->
          <form action="admin_manage_products.php" method="POST">
            <div class="row" style="margin: 0px;">
            <div class="input-field col s3" style = "color:azure">
                <input name="search_product" id="search_product" type="text" class="validate white-text" maxlength="20">
                <label for="search_product">Search product</label>
                <div class="errormsg">
                  <?php
                    if (isset($_GET["error"]))
                    {
                      if ($_GET["error"] == "empty_search")
                      echo "<p>Empty Input!</p>";
                    }
                    ?>
                </div>
              </div>
            </div>
          </form>
          <!-- search product input field end -->

          <!-- search product result list start -->
          <form action="" method="GET">
            <table class="responsive-table">
              <thead class="text-primary">
                <tr><th>Name</th><th>Brand</th><th></th></tr>
              </thead>
              <tbody>
                <?php
                  $products = new adminContr();
                  // $products->productsList();
                ?>
              </tbody>
            </table>
          </form>
          <!-- search product result list end -->
        </div>
      </div>
    </div>
    <!-- products table end -->

    <!-- selected product details start -->
  <?php if (isset($_GET["inspect_product"])) { ?>
  <div class="rounded-card-parent">
    <div class="card rounded-card">
      <div class="card-content white-text">
        <span class="card-title orange-text bold">Selected Product Details</span>
        <table class="responsive-table">
          <form action="admin_manage_products.php" method="GET">
            <thead class="text-primary">
            <tr><th>Image</th><th>Name</th><th>Brand</th>
            <th>Description</th><th>Category</th><th>Selling Price</th><th>Qty In Stock</th></tr>
            </thead>
            <tbody>
              <?php
                $showInspect = new adminContr();
                // $showInspect->showInspectedProduct();
              ?>
            </tbody>
          </form>
        </table>
      </div>
    </div>
  </div>
  <?php }
    // delete product
    if (isset($_GET["delete_product"]))
    {
      $id = $_GET["delete_product"];
      $sql =  "DELETE FROM Items WHERE ItemID = $id";
      $conn->query($sql) or die ("<p class='red-text'>*Delete statement FAILED!</p>");
    }
  ?>
  <!-- selected member details end -->

  <!-- create product start -->
  <div class="rounded-card-parent">
    <div class="card rounded-card">
      <div class="card-content">
        <span class="card-title orange-text bold">Create Product</span>
        <form action="admin_manage_products.php" method="POST">
          <div class="row">
            <div class="col s6" style="padding-right: 40px;">
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">inventory_2</i>
                  <input name="name" type="text" class="validate white-text" maxlength="30">
                  <label for="name" class="white-text">Product Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">branding_watermark</i>
                  <input name="brand" type="text" class="validate white-text" maxlength="20">
                  <label for="brand" class="white-text">Brand</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">description</i>
                  <input name="description" type="text" class="validate white-text" minlength="5" maxlength="100">
                  <label for="description" class="white-text">Description</label>
                </div>
              </div>
            </div>
            <div class="col s6" style="padding-right: 40px;">
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix white-text">category</i>
                  <select name="category">
                    <option value="" disabled selected>Choose your option</option>
                    <option value=0>Dog</option>
                    <option value=1>Food</option>
                    <option value=2>Accessory</option>
                  </select>
                  <label class="white-text">Category</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">attach_money</i>
                  <input name="sellingprice" type="number" step=".01" class="validate white-text" maxlength="30">
                  <label for="sellingprice" class="white-text">Selling Price</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix white-text">production_quantity_limits</i>
                  <input name="quantityinstock" type="number" class="validate white-text" maxlength="30">
                  <label for="quantityinstock" class="white-text">Quantity In Stock</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="file-field col s8">
              <a class="waves-effect waves-light btn cyan">
                <i class="material-icons prefix">image</i>
                <input type="file">
              </a>
              <div class="file-path-wrapper">
                <input name="image" class="file-path validate white-text" type="text"
                  placeholder="Choose Image" onchange="update_image(this)">
              </div>
            </div>
            <img class="shadow-img" id="image" src="" style="width: 300px;">
          </div>

          <div class="errormsg">
            <?php
              if (isset($_GET["create_product"]))
              {
                if ($_GET["create_product"] == "empty_input")
                  echo "<p>*Fill in all fields!<p>";

                else if ($_GET["create_product"] == "successful")
                  echo "<p class='green-text'>Added Product.</p>";
              }
            ?>
          </div>
          <input class="btn orange btn-block z-depth-5" type="submit" name="submit_product" value="Create Product">
        </form>
      </div>
    </div> 
  </div>
  <!-- create product end -->
  </div>
</body>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, options);
  });

  $(document).ready(function(){
    $('select').formSelect();
  });

  function update_image(path)
  {
    var image = document.getElementById("image");
    image.src = `images/${path.value}`;
  }
</script>

<?php include "footer.php"; ?>
</html>