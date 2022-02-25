<?php

class ItemContr extends Item{
  function __construct($itemID)
  {
    $this->itemID = $itemID;
    $this->initData($this->conn());
    $this->updateReviews($this->conn());
  }

  public function setItem(){
    $this->setData();
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