<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech PC - Edit Products</title>
  <?php
    require "header.php";
    include "static/pages/side_nav.html";
    include "static/pages/admin_nav.php";
    $dbh = new Dbhandler();
    $util = new CommonUtil();
  ?>
</head>
<body>
  <?php 
    // get item id from url and fetch product
    if (isset($_GET['item_id']))
    {
      $itemID = $_GET['item_id'];
      $sql = "SELECT ItemID, Name, Brand, Description, Category, SellingPrice, QuantityInStock, Image
        FROM Items WHERE ItemID = $itemID";

      $result = $dbh->conn()->query($sql) or die ($dbh->conn()->error);
  
      list($item_id, $name, $brand, $description, $category, $sellingprice, $quantityinstock, $image)
        = $result->fetch_array();
  
      echo "<p style='visibility: hidden' id='category_id'>$category</p>";
    }
  ?>

  <!-- update product -->
  <?php
    if (isset($_POST["update"]))
    {
      $name = $_POST['name'];
      $brand = $_POST["brand"];
      $description = $_POST["description"];
      $category = $_POST["category"];
      $sellingprice = $_POST["sellingprice"];
      $quantityinstock = $_POST["quantityinstock"];
      $image = $_POST['image'];
      
      if ($util->EmptyInputCreateProduct($name, $brand, $description, $category, $sellingprice, $quantityinstock, $image))
      {
        header("location: admin_edit_products.php?error=emptyinput");
        exit();
      }

      if ($util->productExists($image)) {
        header("location: admin_edit_products.php?error=prdexist");
        exit();
      }

      $sql = "UPDATE Items SET Name='$name', Brand='$brand', Description='$description',
        Category=$category, SellingPrice='$sellingprice', QuantityInStock=$quantityinstock,
        Image='$image' WHERE ItemID=$itemID;";
  
      $dbh->conn()->query($sql) or die($dbh->conn()->error);
      header("location: admin_edit_products.php?error=none");
      $dbh->conn()->close();
    }
  ?>
  <!-- update product end -->

  <div class="rounded-card-parent container" style="margin-top: 150px">
  <div class="card rounded-card">
    <a class="btn blue darken-2" href='admin_manage_products.php' style="margin-bottom: 10px;">< BACK TO MANAGE PRODUCTS</a>
    <span class="card-title orange-text bold center" style="padding-left: 100px;">Edit Product - <?php echo $name; ?></span>
    <form action="edit_products.php" method="POST" style="padding-left: 10px;">
      <div class="row">
        <input type="hidden" name="item_id" id="item_id" value="<?php echo $itemID;?>">
      </div>
      <div class="row">
        <div class="col s6" style="padding-right: 40px;">
          <div class="row">
            <div class="input-field white-text">
              <i class="material-icons prefix">inventory_2</i>
              <input name="name" id="name" type="text" class="validate white-text"
                value="<?php echo $name;?>">
              <label for="name" class="white-text">Product Name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field white-text">
              <i class="material-icons prefix">branding_watermark</i>
              <input name="brand" id="brand" type="text" class="validate white-text" maxlength="20"
                value="<?php echo $brand;?>">
              <label for="brand" class="white-text">Brand</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field white-text">
              <i class="material-icons prefix">description</i>
              <input name="description" id="description" type="text" class="validate white-text" minlength="5"
                value="<?php echo $description;?>">
              <label for="description" class="white-text">Description</label>
            </div>
          </div>
        </div>
        <div class="col s6" style="padding-right: 40px;">
          <div class="row">
            <div class="input-field white-text">
              <i class="material-icons prefix white-text">category</i>
              <select name="category" id="category">
                <option value="" disabled selected>Choose your option</option>
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
              <input name="sellingprice" id="sellingprice" type="number" step=".01" class="validate white-text" maxlength="30"
                value="<?php echo $sellingprice;?>">
              <label for="sellingprice" class="white-text">Selling Price</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field white-text">
              <i class="material-icons prefix white-text">production_quantity_limits</i>
              <input name="quantityinstock" id="quantityinstock" type="number" class="validate white-text" maxlength="30"
                value="<?php echo $quantityinstock;?>">
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
          <div class="file-path-wrapper">
            <input name="image" id="product_image" class="file-path validate white-text" type="text" onchange="update_image(this)"
              value="<?php echo $image;?>">
          </div>
        </div>
        <img class="shadow-img" id="image" src="product_images/<?php echo $image;?>" style="width: 300px;">
      </div>
      <div class="errormsg">
        <?php
          if (isset($_GET["error"]))
          {
            if ($_GET["error"] == "emptyinput")
              echo "<p>*Fill in all fields!<p>";

            if ($_GET["error"] == "stmtfailed")
              echo "<p>*SQL Statement Failed!<p>";

            else if ($_GET["error"] == "prdexist")
            {
              echo "<p>*Product already exist!</p>";
              exit();
            }

            else if ($_GET["error"] == "none")
            {
              echo "<p>Successfully edited product.</p>";
              exit();
            }
          }
        ?>
    </div>
    <button type="submit" id="update" name="update" class="btn">Update Product</button>
    </form>
  </div>
</div>
</body>
<script>
  $(document).ready(function () 
  {
    var categoryId = parseInt(document.getElementById("category_id").textContent);
    categoryId += 1;
    var select = document.querySelector('select');
    select.querySelectorAll('option')[categoryId].selected = true;

    $('select').formSelect();
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, options);
  });

  function update_image(path)
  {
    var image = document.getElementById("image");
    image.src = `product_images/${path.value}`;
  }
</script>

<?php include "footer.php"; ?>
</html>