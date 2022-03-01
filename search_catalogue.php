<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech PC - Search Catalogue</title>
  <?php 
    require_once "header.php";
    require_once "includes/search_catalogue.inc.php";
  ?>
</head>
<body id="stop-autocomplete">
  <div class="container" style="padding-top: 15px;">
    <div class="selectable-card tint-glass-cyan" id="rgb_hover" style="min-height: 80px; z-index: 5050; position: fixed; top: 10; min-width: 1300px">
      <form id="form-filter" action="" method="GET">
      <input type="hidden" name="search_name" value="<?php if(isset($_GET["search_name"])) 
        echo($_GET["search_name"]); ?>">

      <div class="row">
        <div class="col s4"  style="padding-top: 15px">
          <div class="col white-text bold">
            <h6>Filter by:</h6>
          </div>
        

          <div class="col unglow">
            <ul id="filter_dropdown" class="dropdown-content black">
              <li><a class="cyan-text page-title" onclick="select_category(this)">Clear</a></li>
              <li><a class="cyan-text page-title" onclick="select_category(this)">PC Packages</a></li>
              <li><a class="cyan-text page-title" onclick="select_category(this)">Monitor & Audio</a></li>
              <li><a class="cyan-text page-title" onclick="select_category(this)">Peripherals</a></li>
            </ul>
            <a class="btn dropdown-trigger cyan" data-target="filter_dropdown" style="margin-top: 5px;">
              <?php
                $category = -1;
                if (isset($_GET["category"])) $category = $_GET["category"];

                if ($category != -1) echo(CATEGORY_NAMES[$category]);
                else echo("Select Category");
                echo("<input type='hidden' name='category' value=$category>");
              ?>
              <i class="material-icons right">arrow_drop_down</i>
            </a>
          </div>
        </div>

        <div class="col s4"  style="padding-top: 15px">
          <div class="col white-text bold">
            <h6>Choose:</h6>
          </div>
        

          <div class="col unglow">
            <ul id="choose_dropdown" class="dropdown-content black">
              <li><a class="cyan-text page-title" onclick="select_brand(this)">Clear</a></li>
              <li><a class="cyan-text page-title" onclick="select_brand(this)">Asus</a></li>
              <li><a class="cyan-text page-title" onclick="select_brand(this)">MSI</a></li>
              <li><a class="cyan-text page-title" onclick="select_brand(this)">Razer</a></li>
              <li><a class="cyan-text page-title" onclick="select_brand(this)">Logitech</a></li>
              <li><a class="cyan-text page-title" onclick="select_brand(this)">Viewsonic</a></li>
              <li><a class="cyan-text page-title" onclick="select_brand(this)">Acer</a></li>
              <li><a class="cyan-text page-title" onclick="select_brand(this)">HyperX</a></li>
              <li><a class="cyan-text page-title" onclick="select_brand(this)">Corsair</a></li>
            </ul>
            <a class="btn dropdown-trigger cyan" data-target="choose_dropdown" style="margin-top: 5px;">
              <?php
                $brand = -1;
                if (isset($_GET["brand"])) $brand = $_GET["brand"];

                if ($brand != -1) echo(BRAND_NAMES[$brand]);
                else echo("Select Brand");
                echo("<input type='hidden' name='brand' value=$brand>");
              ?>
              <i class="material-icons right">arrow_drop_down</i>
            </a>
          </div>
        </div>

        <div class="col s4"  style="padding-top: 15px">
          <div class="col white-text bold">
            <h6>Sort by:</h6>
          </div>

          <div class="col unglow">
            <ul id="sort_dropdown" class="dropdown-content black">
              <li><a class="page-title" onclick="select_sort(this)">Clear</a></li>
              <li><a class="page-title" onclick="select_sort(this)">Price low to high</a></li>
              <li><a class="page-title" onclick="select_sort(this)">Price high to low</a></li>
            </ul>
            <a class="btn dropdown-trigger" data-target="sort_dropdown" style="margin-top: 5px;">
              <?php
                $sort = -1;
                if (isset($_GET["sort"])) $sort = $_GET["sort"];
                if ($sort != -1) echo(SORT_NAMES[$sort]);
                else echo("Select Sort Type");
                echo("<input type='hidden' name='sort' value=$sort>");
              ?>
              <i class="material-icons right">arrow_drop_down</i>
            </a>
          </div>
        </div>
      </div>
      </form>
    </div>
    <!-- filter products attributes end -->

     <!-- item list start -->
    <div style="margin-top: 150px;">
      <?php
        searchItems($category, $brand, $sort);
      ?>
    </div>
    <!-- item list end -->
  </div>
</body>
<script>
  $(document).ready(() =>
  {
    form = document.getElementById("form-filter");
    category = document.getElementsByName("category")[0];
    brand = document.getElementsByName("brand")[0];
    sort = document.getElementsByName("sort")[0];
  });

  // dropdown
  var form, category, brand, sort;

  var categoryBy = {
    "Clear": -1,
    "PC Packages": 0,
    "Monitor & Audio": 1,
    "Peripherals": 2
  };

  var brandBy = {
    "Clear": -1,
    "Asus": 0,
    "MSI": 1,
    "Razer": 2,
    "Logitech": 3,
    "Viewsonic": 4,
    "Acer": 5,
    "HyperX": 6,
    "Corsair": 7,
  }

  var sortBy = {
    "Clear": -1,
    "Price low to high": 0,
    "Price high to low": 1
  };

  function select_category(selectedItem)
  {
    // get current onclick event index
    var categoryID = categoryBy[selectedItem.textContent];
    // assign current mapped index and output to url with GET method to handle form
    category.value = categoryID;
    form.submit();
  }

  function select_brand(selectedItem)
  {
    // get current onclick event index
    var brandID = brandBy[selectedItem.textContent];
    // assign current mapped index and output to url with GET method to handle form
    brand.value = brandID;
    form.submit();
  }

  function select_sort(sortItem)
  {
    // get current onclick event index
    var sortID = sortBy[sortItem.textContent];
    // assign current mapped index and output to url with GET method to handle form
    sort.value = sortID;
    form.submit();
  }
</script>
<?php include_once "footer.php"; ?>
</html>