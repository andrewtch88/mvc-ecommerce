<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Make your review</title>
  <?php
    include "header.php";
    require_once "includes/class_autoloader.php";
    require_once "includes/review.inc.php";

    $orderItemID = $_GET["review_item"];

    $conn = new Dbhandler();

    if (isset($orderItemID))
    {
      $sql = "SELECT I.Image, I.Name from Items I, OrderItems O, Items WHERE O.OrderItemID = $orderItemID AND I.ItemID = O.ItemID";
      $result = $conn->conn()->query($sql) or die($conn->conn()->error);
      $row = $result->fetch_assoc();
      $image = $row["Image"];
      $name = $row["Name"];
    }
  ?>
</head>
<body>
  <div class="container" style="margin-top: 50px;">
    <div class="rounded-card-parent">
      <div class="card rounded-card">
        <div class="row">
          <div class="col s9">
            <div class="grid left">
              <a href='cart.php?member_id=<?php echo($memberID); ?>' class="grid">
                <i class="material-icons white-text" style='font-size: 45px'>arrow_back</i>
              </a>
              <h4 class="amber-text bold grid">Rate Product</h4>
            </div>
          </div>
        </div>

        <div class="row">
          <div class='col s4 center'>
            <img class="shadow-img" src="product_images/<?php echo($image); ?>"
              style="max-height: 300px; max-width: 300px;">
          </div>
          <div class="col s8 left">
            <h5 class="white-text bold"><?php echo($name) ?></h5>
            <form action="review.php?review_item=<?php echo($orderItemID); ?>" method="POST" style="padding-left: 10px;">
              <?php
                $rating = checkRating($orderItemID, $conn);
                echo("<input type='hidden' id='rating' name='rating' value=$rating>");
              ?>
              <div class="row grid" style="padding-top: 80px;">
                <div class="rate center">
                  <input class='center' type="radio" id="star5" name="rating_star" value=5 onclick="ratingChanged();"/>
                  <label for="star5" title="5 Stars">5 stars</label>
                  <input class='center' type="radio" id="star4" name="rating_star" value=4 onclick="ratingChanged();"/>
                  <label for="star4" title="4 Stars">4 stars</label>
                  <input class='center' type="radio" id="star3" name="rating_star" value=3 onclick="ratingChanged();"/>
                  <label for="star3" title="3 Stars">3 stars</label>
                  <input class='center' type="radio" id="star2" name="rating_star" value=2 onclick="ratingChanged();"/>
                  <label for="star2" title="2 Stars">2 stars</label>
                  <input class='center' type="radio" id="star1" name="rating_star" value=1 onclick="ratingChanged();"/>
                  <label for="star1" title="1 Star">1 star</label>
                </div>
              </div>
          </div>
          <div class="row">
            <div class="input-field col s12 white-text">
              <i class="material-icons prefix">rate_review</i>
              <textarea id="review" class="materialize-textarea white-text" data-length="250"
                name="review"><?php echo(checkReviewExists($conn, $orderItemID)); ?></textarea>
            </div>
            <div class="errormsg">
              <?php
                if (isset($_GET["error"]))
                {
                  if ($_GET["error"] == "empty_input")
                    echo "<p>*Fill in all fields!<p>";
                }
              ?>
            </div>
            <?php
              if (isset($_GET["error"]))
              {
                if ($_GET["error"] == "none")
                  echo "<p style='color: green; font-weight: bold'>Thanks for rating! Redirecting to cart page...</p>";
              }
            ?>
          </div>
          <div class="container center-align">
            <input class="btn orange" type="submit" name="submit" value="Submit Review">
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

<script>
  var STARS;
  var RATING;
  var STAR_COUNT;

  $(document).ready(function() 
  {
    STARS = document.getElementsByName("rating_star");
    RATING = document.getElementById("rating");
    STAR_COUNT = STARS.length
    
    // initial condition of rating (from database)
    for (var i=0; i < RATING.value; i++) 
    {
      document.getElementById(`star${i+1}`).checked = true;
    }
    $("textarea#review").characterCounter();
  });

  function ratingChanged()
  {
    for (var i=0; i < STAR_COUNT; i++) 
    {
      if (STARS[i].checked == true) 
      {
        RATING.value = STARS[i].value;
        break;
      }
    }
  }
</script>

<?php include "footer.php"; ?>
</html>