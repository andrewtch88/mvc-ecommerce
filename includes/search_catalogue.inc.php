<?php
  require_once "class_autoloader.php";

  const CATEGORY_NAMES = ["PC Packages", "Monitor & Audio", "Peripherals"];
  const SORT_NAMES = ["Price low to high", "Price high to low", "Rating high to low"];

  function searchItems($category, $sort){
    $searchName = "";
    if (isset($_GET["search_name"])) $searchName = $_GET["search_name"];

    /** 
     * @var Item[] $items
     */
    $sql = "SELECT ItemID FROM Items WHERE (Name LIKE '%$searchName%' OR Brand LIKE '%$searchName%')";

    // only limit to a number
    if ($category != -1) $sql .= " AND Category = $category";

    if ($sort == 0) $sql .= " ORDER BY SellingPrice ASC";
    else if ($sort == 1) $sql .= " ORDER BY SellingPrice DESC";

    $sql .= " LIMIT 50";
    $conn = new Dbhandler();
    $result = $conn->conn()->query($sql) or die($conn->conn()->error);

    $items = array();
    while ($row = $result->fetch_assoc())
    {
      $itemID = $row["ItemID"];
      array_push($items, new Item($itemID));
    }

    generateItemList($items);
  }

  /**
  * @param Item[] $items
  */
  function generateItemList($items){
    $itemCount = count($items);

    $itemIdx = 0;
    while ($itemIdx < $itemCount) {
      echo("<div class='row'>");
      // generate 4 items in one row only (container)
      for ($i=0; $itemIdx < $itemCount && $i < 4; $itemIdx++){

        $item = $items[$itemIdx];

        if ($item->GetQuantityInStock() <= 0) continue;
        $i++;

        $itemID = $item->getItemID();
        $image = $item->getImage();
        $name = $item->getName();
        $brand = $item->getBrand();
        $price = $item->getSellingPrice();
        $price = "RM" . number_format($price, 2);
        $category = $item->getCategory();
        $category = Item::CATEGORY_ICON[(int)$category];
        $avgRating = $item->getAvgRatings();
        echo(
          "<div class='col s3'>
            <a href='item_page.php?item_id=$itemID'>
              <div class='selectable-card' style='height: 480px; min-width: 300px'>
                <img class='shadow-img' src='product_images/$image' style='max-height: 200px; max-width: 250px;'>
                <p class='center bold white-text'>$name</p>
                <table class='center'>
                  <tbody class='center'>
                    <tr><th>Brand: </th><td>$brand</td></tr>
                    <tr><th>Price: </th><td>$price</td></tr>
                    <tr><th>Category: </th><td><i class='material-icons prefix'>$category</i></td></tr>
                    <tr><th>Avg Rating: </th><td>$avgRating</td><tr>
                  </tbody>
                </table>
              </div>
            </a>
          </div>"
        );
      }
      // closing div tag
      echo("</div>");
    }
  }