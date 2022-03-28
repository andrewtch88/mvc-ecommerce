<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="static/css/magnifier.css">
  <?php 
    include "header.php";
    require_once "includes/class_autoloader.php";
    require_once "includes/buy_or_cart.inc.php";

    $conn = new Dbhandler();

    if (isset($_GET["item_id"]))
    {
      $itemID = $_GET["item_id"];
      $item = new Item($itemID);

      $name = $item->getName(); 
    }
  ?>
  <title>OG Tech PC — <?php echo htmlspecialchars($name) ?></title>
</head>
<body>

  <?php 
    if (isset($_GET["item_id"])){
      $itemID = $_GET["item_id"];
      
      $image = $item->getImage();
      $brand = $item->getBrand();
      $description = $item->getDescription();
      $quantityInStock = $item->getQuantityInStock();
      $price = $item->getSellingPrice();
      $displayPrice = "RM" . number_format($price, 2);
      $category = $item->getCategory();
      $category = Item::CATEGORY[$category];

      $hasReviews = $item->HasReviews();
      $avgRatings = $item->getAvgRatings();

      // set amount of items to add into cart
      $cartQty = 0;
      if (isset($_GET["qty"])) $cartQty = $_GET["qty"];
      
      if (isset($_GET["buy_now"])){
        buyOrCart($conn, $quantityInStock, 1, $itemID, $price, $cart);
        echo("<script>location.replace('cart.php?member_id=$memberID');</script>");
        exit();
      }
      
      if ($cartQty > 0) {
        buyOrCart($conn, $quantityInStock, $cartQty, $itemID, $price, $cart);
        echo("<script>location.replace('product.php?item_id=$itemID');</script>");
        exit();
      }

    } else die("<h5 class='container white-text page-title' style='margin-top: 50px'>No item selected...</h5>");
  ?>

<input type="hidden" id="max-quantity" value=<?php echo($quantityInStock) ?>>
<div class="container" style="margin-top: 50px;">
  <div class="rounded-card-parent">
    <div class="card rounded-card">
      <a class="btn red darken-2" href="product_catalogue.php?query=" style='margin-left: 20px'>< BACK TO CATALOGUE</a>
      <form action="product.php" method="GET" style="padding-left: 10px;">
        <input type="hidden" name="item_id" value=<?php echo($itemID) ?>>
        <div class="row">
          <div class="col s4">   
            <a class="magnifier-thumb-wrapper demo">
              <img id="thumb" style="max-height: 350px; max-width: 350px; margin-top: 30px" src="product_images/<?php echo($image); ?>"
              data-large-img-url="product_images/<?php echo($image); ?>"
              data-large-img-wrapper="preview">
            </a>
            <div class="magnifier-preview example heading" id="preview" style="width: 600px; height:450px"></div>
          </div>
          <div class="col s8">
            <div class="row">
              <table class="responsive-table">
                <tbody>
                  <tr><h4 class="white-text"><?php echo($name); ?></h4></tr>
                  <tr>
                    <!-- product details -->
                    <?php
                      if ($hasReviews)
                      {
                        $intRating = $avgRatings * 5 / 100;
                        $reviews = $item->GetReviews();
                        $reviewCount = count($reviews);

                        if ($intRating >= 10) {
                          $intRating = $intRating / $reviewCount;
                          $intRating = number_format((float)$intRating, 2, '.', '');
                          $avgRatings = $intRating * 20;
                        }
                        echo(
                          "$intRating
                          <div class='ratings' style='padding-bottom: 5px'>
                            <div class='empty-stars'></div>
                            
                            <div class='full-stars' style='width: $avgRatings%'></div>
                          </div>"
                        );
                      } else echo("-")
                    ?>
                    |
                    <?php   
                      if ($hasReviews) echo("$reviewCount Ratings");
                      else echo("No ratings yet");
                    ?>
                    |
                    <?php
                      if ($item->checkSoldCount()){
                        echo($item->checkSoldCount());
                        echo(" Sold");
                      }
                      else echo("0 Sold");
                    ?>
                    <!-- product details end -->
                  </tr>
                  <h4 class="amber-text"><?php echo($displayPrice); ?></h4>
                  <tr><th class='grey-text'>Brand: </th><td><?php echo($brand); ?></td></tr>
                  <tr><th class='grey-text'>Description: </th>
                    <td>
                      <?php 
                        $pTagDesc = explode(",", $description); 
                        foreach ($pTagDesc as $pDesc) {
                          echo "<p>$pDesc</p>";
                        }
                      ?>
                    </td>
                  </tr>
                  <tr><th class='grey-text'>Category: </th><td><?php echo($category); ?></td></tr>
                </tbody>
              </table>
            </div>

            <div class="row input-field grid">
              <a style="margin-right: 10px"><p class="grey-text">Quantity:</p></a>          
              <button type="button" class="btn-small waves-effect waves-light red"
                onclick="subtractQty()">
                <i class="material-icons">remove</i>
              </button>

              <input id="qty" class="white-text" type="number" disabled
                style="padding: 10px; width: 5%;" value=0></input>
              <input id="sync-qty" name="qty" class="white-text" type="hidden" value=0></input>

              <button type="button" class="btn-small waves-effect waves-light green"
                onclick="addQty()">
                <i class="material-icons">add</i>
              </button>
              
              <div id="qtyHolder">
                <?php 
                  if ($quantityInStock < 6) echo("<a class='red-text' style='margin-left: 10px'>$quantityInStock items left!</a>"); 
                  else echo("<a class='grey-text' style='margin-left: 10px'>$quantityInStock items left</a>");
                ?>
              </div>
            </div>
            <div class="row grid" style="margin-right: 10px">
              <button type="submit" class="btn waves-effect waves-light " onclick="return addToCart()">
                <a class="white-text">
                  <i class="material-icons right">shopping_cart</i>
                  Add To Cart
                </a>
              </button>
              <input class="btn white-text waves-effect amber darken-4" type="submit" name="buy_now" style='margin-left: 10px' value="Buy Now">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="rounded-card-parent" style="margin-top: 50px;">
    <div class="card rounded-card">
      <h4 class="white-text" style="margin-bottom: 40px;">Reviews</h4>

      <?php
        if ($hasReviews)
        {
          $reviews = $item->GetReviews();
          $reviewCount = count($reviews);
          for ($r=0; $r < $reviewCount; $r++)
          {
            $review = $reviews[$r];
            $username = $review->getUsername();
            $feedback = $review->getFeedback();
            $rating = $review->getRating();
            echo(
              "<div class='ratings'>
                <div class='empty-stars'></div>
                <div class='full-stars' style='width: $rating%'></div>
              </div>
              <div class=input-field row'>
              <i class='material-icons prefix cyan-text'>account_circle</i>
              <textarea id='icon_prefix2' disabled type='text'
                class='white-text materialize-textarea'>$feedback</textarea>
              <label for='icon_prefix2' class='white-text'>$username</label>
              </div>"
            );
          }
        } else echo("<h6 class='grey-text'>There are no reviews yet... Be the first to leave a review!</h6>")
      ?>
    </div>
  </div>
</div>
</body>

<script type="text/javascript">
  $(document).ready(function(){
    autoSyncQty();

    var evt = new Event(),
    m = new Magnifier(evt, { largeWrapper: document.getElementById('preview')});

    m.attach({
      thumb: '#thumb',
      zoomable: true
    });
  });

  function autoSyncQty(){
    $('#qtyHolder').load(location.href + " #qtyHolder", function(){
      setTimeout(autoSyncQty, 5000);
    });
  }
</script>

<script type="text/javascript" src="static/js/product_page.js"></script>
<script type="text/javascript" src="static/js/Event.js"></script>
<script type="text/javascript" src="static/js/Magnifier.js"></script>

<?php include "footer.php"; ?>
</html>