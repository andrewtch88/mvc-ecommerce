<?php

class Item extends Dbhandler{
  private $itemID;
  private $name;
  private $brand;
  private $description;
  private $category;
  private $price;
  private $quantityInStock;
  private $image;
  
  /** @var Review[] $reviews */
  private $reviews;
  /** @var float $avgRating */
  private $avgRating;

  public const CATEGORY = ["PC Packages", "Monitor & Audio", "Peripherals"];
  public const CATEGORY_ICON = ["computer", "airplay headset", "mouse"];

  protected function initData(){
    $sql = "SELECT * FROM Items WHERE ItemID = $this->itemID";
    $result = $this->conn()->query($sql) or die($this->conn()->error);

    $row = $result->fetch_assoc();
    $this->name = $row["Name"];
    $this->brand = $row["Brand"];
    $this->description = $row["Description"];
    $this->category = $row["Category"];
    $this->sellingPrice = $row["SellingPrice"];
    $this->quantityInStock = $row["QuantityInStock"];
    $this->image = $row["Image"];
  }

  // copy reviews and ratings from database
  protected function updateReviews(){
    $this->reviews = array();
    $sql = "SELECT OI.Feedback, OI.Rating, O.MemberID FROM OrderItems OI, Orders O
      WHERE OI.ITEMID = $this->itemID AND OI.OrderID = O.OrderID";
    $result = $this->conn()->query($sql) or die($this->conn()->error);

    $this->avgRating = 0;
    $totalRatings = 0;
    while ($row = $result->fetch_assoc()) {
      $feedback = $row["Feedback"];
      $rating = $row["Rating"];
      $memberID = $row["MemberID"];
      $nameResult = $this->conn()->query("SELECT Username FROM Members M WHERE MemberID = $memberID") or die($this->conn()->error);
      $username = $nameResult->fetch_array()[0];
      // check to see if a review has been made or not
      if ($rating != NULL)
      {
        // if feedback is empty, we assign it as empty string
        if ($feedback != NULL) array_push($this->reviews, new Review($username, $rating, $feedback));
        else array_push($this->reviews, new Review($username, $rating, ""));
        $this->avgRating += $rating;
        $totalRatings++;
      }
    }
  }

  // check whether this item has any reviews
  protected function HasReviews()
  {
    if (isset($this->reviews) && count($this->reviews) > 0) return true;
    return false;
  }

  // copy object data to database
  protected function setData()
  {
    $sql = "UPDATE Items SET
      Name = '$this->name',
      Brand = '$this->brand',
      Description = '$this->description',
      Category = $this->category,
      SellingPrice = $this->sellingPrice,
      QuantityInStock = $this->quantityInStock
      WHERE ItemID = $this->itemID";

    $this->conn()->query($sql) or die($this->conn()->error);
  }
}