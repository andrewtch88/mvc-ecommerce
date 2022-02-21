<?php

class Item {
  private $itemID;
  private $name;
  private $brand;
  private $description;
  private $category;
  private $price;
  private $quantityInStock;
  private $image;
  
  public const CATEGORY = ["PC Packages", "Monitor & Audio", "Peripherals"];
  public const CATEGORY_ICON = ["computer", "airplay headset", "mouse"];
}