<?php 
$orderItemID = $_GET["review_item"];

function checkRating($orderItemID, $conn){
  $sql = "SELECT Rating FROM OrderItems WHERE OrderItemID = $orderItemID";
  $result = $conn->conn()->query($sql) or die($conn->conn()->error);
  $row = $result->fetch_assoc();
  $rating = $row["Rating"];

  if ($rating != NULL) { return $rating; } 
  else { return 0; }
}

function checkReviewExists($conn, $orderItemID)
{
  $sql = "SELECT Feedback FROM OrderItems WHERE OrderItemID = $orderItemID";
  $result = $conn->conn()->query($sql) or die($conn->conn()->error);
  $row = $result->fetch_assoc();
  $feedback = $row["Feedback"];

  if ($feedback != NULL) { return $feedback; } 
  else return "Share your experience and help others make better choices!";
}

function EmptyInputReview($rating, $review)
{ return empty($rating) || (empty($review)); }

if (isset($_GET["redirect"])) header("refresh:2.5;url=cart.php?member_id=$memberID");

if (isset($_POST["submit"]))
{
  $review = $_POST["review"];
  $rating = $_POST["rating_star"];

  $conn = new Dbhandler();

  if (EmptyInputReview($rating, $review))
  {
    echo("<script>location.href = 'review.php?error=empty_input&review_item=$orderItemID';</script>");
    exit();
  } 
  else
  {
    $sql = "UPDATE OrderItems SET Feedback = \"$review\", Rating = $rating, RatingDateTime = CURRENT_TIME
      WHERE OrderItemID = $orderItemID";
    $conn->conn()->query($sql) or die($conn->conn()->error);
    echo("<script>location.href = 'review.php?error=none&review_item=$orderItemID&redirect=1';</script>");
    exit();
  }
}