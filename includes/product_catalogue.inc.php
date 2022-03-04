<?php
  require_once "class_autoloader.php";

  const CATEGORY_NAMES = ["PC Packages", "Monitor & Audio", "Peripherals"];
  const BRAND_NAMES = ["Asus", "MSI", "Razer", "Logitech", "Viewsonic", "Acer", "HyperX", "Steelseries", "Corsair"];
  const SORT_NAMES = ["Price low to high", "Price high to low"];
  const VIEW_NAMES = ["List"];

  function searchItems($category, $brand, $sort, $view){
    $searchName = "";
    if (isset($_GET["query"])) $searchName = $_GET["query"];

    /** 
     * @var Item[] $items
     */
    $sql = "SELECT ItemID FROM Items WHERE (Name LIKE '%$searchName%')";

    // only limit to a number
    if ($category != -1) $sql .= " AND Category = $category";

    if ($brand != -1){
      $brandName = BRAND_NAMES[$brand];
      $sql .= " AND Brand = '$brandName'";
    }

    if ($sort == 0) $sql .= " ORDER BY SellingPrice ASC";
    else if ($sort == 1) $sql .= " ORDER BY SellingPrice DESC";

    $sql .= " LIMIT 50";
    $conn = new Dbhandler();
    $result = $conn->conn()->query($sql) or die($conn->conn()->error);

    $items = array();

    if ($result->num_rows < 1)
      echo "<h5 class='white-text bold center' style='padding-top: 150px'>
        0 result is returned. Please try other search result as the selected products is not available</h5>";

    while ($row = $result->fetch_assoc())
    {
      $itemID = $row["ItemID"];
      array_push($items, new Item($itemID));
    }

    generateItemList($items, $view);
  }

  /**
  * @param Item[] $items
  */
  function generateItemList($items, $view){
    $itemCount = count($items);

    $itemIdx = 0;
    while ($itemIdx < $itemCount) {
      echo("<div class='row'>");
      // generate 4 items in one row only (container)
      for ($i=0; $itemIdx < $itemCount && $i < 4; $itemIdx++){

        $item = $items[$itemIdx];

        if ($item->getQuantityInStock() <= 0){
          echo("No stock available, please try other filter options");
          continue;
        }

        $i++;

        $itemID = $item->getItemID();
        $image = $item->getImage();
        $name = $item->getName();
        $brand = $item->getBrand();
        $price = $item->getSellingPrice();
        $price = "RM" . number_format($price, 2);
        $avgRating = $item->getAvgRatings();

        echo(
          "
          <div class='col s3'>
            <a href='product.php?item_id=$itemID'>
              <div class='selectable-card' style='height: 480px; min-width: 300px'>
                <img class='shadow-img center' src='product_images/$image' style='max-height: 200px; max-width: 300px; display: block; margin: 0 auto;'>
                <p class='center bold white-text'>$name</p>
                <table class='center'>
                  <tbody class='center'>
                    <tr><th>Brand: </th><td>$brand</td></tr>
                    <tr><th>Price: </th><td>$price</td></tr>
                    <tr>
                      <th>Avg Rating: </th>
                      <td>
                        $avgRating/5
                      </td>
                    <tr>
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