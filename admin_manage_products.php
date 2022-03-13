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

    <div class="rounded-card-parent center" style="margin-bottom: 100px">
      <div class="card rounded-card">
        <div class="card-content white-text">
          <span class="orange-text" style="font-size: 24px">Products List - Sorted by quantity
          <th>
            <button class='deep-orange btn'><a href="admin_manage_products.php"><i class='material-icons white-text'>refresh</i></a>
            </button>
          </th>
          </span>

          <!-- search product input field start -->
          <form action="admin_manage_products.php" method="POST">
            <div class="row" style="margin: 0px;">
              <div class="input-field col s3" style = "color:azure">
                <input name="search_product" id="search_product" type="text" class="validate white-text" maxlength="20">
                <label for="search_product">Search product by Name or Brand</label>
                <div id="error" class="errormsg">
                  
                </div>
                
              </div>
            </div>
          </form>
          <!-- search product input field end -->

          <!-- search product result list start -->
          <form action="" method="GET">
            <table class="responsive-table" id="pagination">
              <thead class="text-primary">
                <tr>
                  <th>Name</th><th>Brand</th><th class='center'>Quantity In Stock</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $products = new adminContr();
                  $products->productsList();
                ?>
              </tbody>
            </table>
            <div class="col-md-12 center text-center">
              <span class="left" id="total_reg"></span>
              <ul class="pagination pager white-text" id="myPager"></ul>
            </div>
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
        <table class="responsive-table center">
          <form action="admin_manage_products.php" method="GET">
            <thead class="text-primary center">
            <tr><th>Image</th><th>Name</th><th>Brand</th>
            <th>Description</th><th>Category</th><th>Selling Price</th><th>Qty In Stock</th></tr>
            </thead>
            <tbody>
              <?php
                $showInspect = new adminContr();
                $showInspect->showInspectedProduct();
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
      $dbh = new Dbhandler();
      $dbh->conn()->query($sql) or die ("<p class='red-text'>*Delete statement FAILED!</p>");
    }
  ?>
  <!-- selected member details end -->

  <!-- create product start -->
  <div class="rounded-card-parent" style="margin-top: 100px">
    <div class="card rounded-card">
      <div class="card-content">
        <span class="card-title orange-text bold">Create Product</span>
        <form id="create" name="create" action="" method="POST">
          <div class="row">
            <div class="col s6" style="padding-right: 40px;">
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">inventory_2</i>
                  <input name="name" id="name" type="text" class="validate white-text">
                  <label for="name" class="white-text">Product Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">branding_watermark</i>
                  <input name="brand" id="brand" type="text" class="validate white-text" maxlength="20">
                  <label for="brand" class="white-text">Brand</label>
                </div>
              </div>
              <div class="row">
                <div class="row">
                  <div class="input-field white-text col s12">
                    <i class="material-icons prefix">description</i>
                    <textarea name="description" id="description" class="materialize-textarea white-text" minlength="5"></textarea>
                    <label for="description" class="white-text">Description</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col s6" style="padding-right: 40px;">
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix white-text">category</i>
                  <select name="category" id="category">
                    <option value="" disabled selected>Choose category</option>
                    <option value=0>PC Packages</option>
                    <option value=1>Monitor & Audio</option>
                    <option value=2>Peripherals</option>
                  </select>
                  <label class="white-text">Category</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">attach_money</i>
                  <input name="sellingprice" id="sellingprice" type="number" step=".01" class="validate white-text" maxlength="30">
                  <label for="sellingprice" class="white-text">Selling Price</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix white-text">production_quantity_limits</i>
                  <input name="quantityinstock" id="quantityinstock" type="number" class="validate white-text" maxlength="30">
                  <label for="quantityinstock" class="white-text">Quantity In Stock</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="file-field col s6">
                <div class="btn">
                  <span>File</span>
                  <input type="file" id="product_image">
                </div>
              </a>
              <div class="file-path-wrapper">
                <input name="image" id="product_image" class="file-path validate white-text" type="text"
                  placeholder="Choose Image" onchange="update_image(this)">
              </div>
            </div>
            <img class="shadow-img" id="image" src="" style="width: 300px;">
          </div>

          <div id="message" class="errormsg">
            
          </div>
          <input class="btn orange btn-block z-depth-5" type="submit" name="submit_product" id="submit_product" value="Create Product">
        </form>
      </div>
    </div> 
  </div>
  <!-- create product end -->
  </div>
</body>
<script>

  $(document).ready(function(){
    $('select').formSelect();

    $("#create").submit(function(e) {
      event.preventDefault();
      var productName = $("#name").val();
      var brand = $("#brand").val();
      var description = $("#description").val();
      var category = $("#category").val();
      var sellingprice = $("#sellingprice").val();
      var quantityinstock = $("#quantityinstock").val();
      var image = $("#product_image").val().replace(/C:\\fakepath\\/, '');
      var submit_product = $("#submit_product").val();
      $("#message").load("includes/admin.inc.php", {
        productName: productName,
        brand: brand,
        description: description,
        category: category,
        sellingprice: sellingprice,
        quantityinstock: quantityinstock,
        image: image,
        submit_product: submit_product
      });
    })

  });

  function update_image(path)
  {
    var image = document.getElementById("image");
    image.src = `product_images/${path.value}`;
  }
</script>

<?php include "footer.php"; ?>
</html>