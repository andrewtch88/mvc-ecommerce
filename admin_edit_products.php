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
    include "includes/admin.inc.php";
    $dbh = new Dbhandler();
    $util = new CommonUtil();
  ?>
</head>
<body>
  <div class="rounded-card-parent container" style="margin-top: 150px">
  <div class="card rounded-card">
    <a class="btn blue darken-2" href='admin_manage_products.php' style="margin-bottom: 10px;">< BACK TO MANAGE PRODUCTS</a>
    <span class="card-title orange-text bold center" style="padding-left: 100px;">Edit Product - <?php echo $name; ?></span>
    <form action="" method="POST" style="padding-left: 10px;">
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
            <div class="row">
              <div class="input-field white-text col s12">
                <i class="material-icons prefix">description</i>
                <textarea name="description" id="description" class="materialize-textarea white-text" minlength="5">
                  <?php echo $description;?>
                </textarea>
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
          if ($_GET["error"] == "empty_input")
            echo "<p>*Fill in all fields!<p>";

          else if ($_GET["error"] == "none")
            echo "<p class='green-text bold'>Successfully edited product.</p>";
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