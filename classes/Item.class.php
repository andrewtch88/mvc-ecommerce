<?php

class Item extends Dbhandler{
  /** @var int $itemID */
  private $itemID;
  private $name;
  private $brand;
  private $description;
  private $category;
  private $quantityInStock;
  private $image;
  
  /** @var Review[] $reviews */
  private $reviews;
  /** @var float $avgRating */
  private $avgRating;

  public const CATEGORY = ["PC Packages", "Monitor & Audio", "Peripherals"];
  public const CATEGORY_ICON = ["computer", "airplay headset", "mouse"];

  function __construct($itemID)
  {
    /** @var int $itemID */
    $this->itemID = $itemID;
    $this->initData();
    $this->updateReviews();
  }

  public function setItem(){
    $this->setData();
  }

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
      WHERE OI.ITEMID = '$this->itemID' AND OI.OrderID = O.OrderID";
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
  public function HasReviews()
  {
    if (isset($this->reviews) && count($this->reviews) > 0) return true;
    return false;
  }

  public function checkSoldCount()
  {
    $sql = "SELECT SUM(OI.Quantity), O.CartFlag FROM OrderItems OI, Orders O
      WHERE ItemID = $this->itemID AND OI.OrderID = O.OrderID AND CartFlag = 0";

    $result = $this->conn()->query($sql) or die($this->conn()->error);

    while ($row = $result->fetch_assoc())
    
    return $row["SUM(OI.Quantity)"];
  }

  // copy object data to database
  public function setData()
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

  public function setSellingPrice($sellingPrice) { $this->sellingPrice = $sellingPrice; }
  public function setQuantityInStock($quantityInStock) { $this->quantityInStock = $quantityInStock; }

  public function getItemID() { return $this->itemID; }
  public function getName() { return $this->name; }
  public function getBrand() { return $this->brand; }
  public function getDescription() { return $this->description; }
  public function getCategory() { return $this->category; }
  public function getSellingPrice() { return $this->sellingPrice; }
  public function getQuantityInStock() { return $this->quantityInStock; }
  public function getImage() { return $this->image; }
  public function getReviews() { return $this->reviews; }
  public function getAvgRatings() { return $this->avgRating / 5 * 100; }
}