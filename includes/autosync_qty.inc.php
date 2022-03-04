<?php

require_once "class_autoloader.php";

if (isset($_GET["item_id"]))
{
  $itemID = $_GET["item_id"];
  $item = new Item($itemID);

  $quantityInStock = $item->getQuantityInStock();
}