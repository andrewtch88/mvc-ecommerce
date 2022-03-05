<?php

// This class handles search and display table only

class Admin extends Dbhandler{

  protected function searchMember(){
    $util = new CommonUtil();
    function EmptyInputCreateUser($username, $pwd, $repeatPwd, $privilegeLevel, $email)
    { return empty($username) || (empty($pwd)) || (empty($repeatPwd)) or ($privilegeLevel === "") || (empty($email));}

    if (isset($_POST["search_member"]))
    {
      $searchMember = $_POST["search_member"];

      if ($util->EmptyInputSelect($searchMember))
        echo "<p style='color: yellow'>Please enter a value</p>";
      else
      {
        // limited search to prevent page overflow
        $sql = "SELECT Username, PrivilegeLevel FROM Members WHERE Username LIKE '%$searchMember%' ORDER BY Username LIMIT 20";
        $result = $this->conn()->query($sql) or die ("User does not exists!");
        while ($row = mysqli_fetch_assoc($result) ) 
        { 
          $username = $row["Username"]; 
          echo(
            "<tr>
              <td class='yellow-text'>$username</td>
              <td class='center'>
                <button name='inspect' value='$username' class='btn'>
                  <i class='material-icons'>search</i>
                </button>
              </td>
            </tr>"
          );
        }
      }
    }

    if (!isset($searchMember) || $util->EmptyInputSelect($searchMember))
    {
      $sql = "SELECT Username, MemberID FROM Members ORDER BY MemberID DESC";
      $result = $this->conn()->query($sql) or die ($this->conn()->error);
      while ($row = mysqli_fetch_assoc($result) ) 
      { 
        $username = $row["Username"];
        $memberID = $row["MemberID"];
        echo(
          "<tr>
            <td class='blue-text'>$memberID</td>
            <td class='blue-text'>$username</td>
            <td class='left-align'>
              <button name='inspect' value='$username' class='btn'>
                <i class='material-icons'>search</i>
              </button>
            </td> 
          </tr>"
        );
      }
    }
  }

  protected function inspectUser(){
    // inspect user
    $uid = $_GET["inspect"];
    $sql = "SELECT MemberID, Username, Email, PrivilegeLevel FROM Members WHERE Username = '$uid' ORDER BY Username";
    $result = $this->conn()->query($sql) or die ("Select statement FAILED!");
    while ($row = mysqli_fetch_array($result))
    {
      $deleteid = $row["MemberID"];
      $username = $row["Username"];
      $email = $row["Email"];
      $privilegeLevel = $row["PrivilegeLevel"];
      echo(
        "<tr>
          <td>$deleteid</td>
          <td>$username</td>
          <td>$email</td>
          <td>$privilegeLevel</td>
        </tr>"
      );
    }
  }

  protected function showProduct(){
    if (isset($_POST["search_product"]))
    {
      $searchProduct = $_POST["search_product"];

      $emptyInput = new CommonUtil();

      if ($emptyInput->EmptyInputSelect($searchProduct))
        echo "<p class='prompt-warning'>Please enter a value</p>";
      else
      {
        // limited search to prevent page overflow
        $sql = "SELECT ItemID, Name, Brand, QuantityInStock FROM Items
          WHERE Brand LIKE '%$searchProduct%' OR Name LIKE '%$searchProduct%' LIMIT 20";

        $result = $this->conn()->query($sql) or die ("Product does not exists!");
        while ($row = $result->fetch_assoc() ) 
        {
          $itemID = $row["ItemID"]; 
          $name = $row["Name"];
          $brand = $row["Brand"];
          $quantityinstock = $row["QuantityInStock"];
          echo(
            "<tr>
              <td class='white-text'>$name</td>
              <td class='white-text'>$brand</td>
              <td class='white-text'>$quantityinstock</td>
              <td>
                <button name='inspect_product' value='$itemID' class='btn'>
                  <i class='material-icons'>search</i>
                </button>
              </td>
            </tr>"
          );
        }
      }
    }

    if (!isset($searchProduct) || $emptyInput->EmptyInputSelect($searchProduct))
    {
      $sql = "SELECT ItemID, Name, Brand, QuantityInStock FROM Items ORDER BY QuantityInStock";
      $result = $this->conn()->query($sql) or die ($this->conn()->error);
      while ($row = mysqli_fetch_assoc($result)) 
      {
        $itemID = $row["ItemID"]; 
        $name = $row["Name"];
        $brand = $row["Brand"];
        $quantityinstock = $row["QuantityInStock"];
        
        echo(
          "<tr>
            <td class='blue-text'>$name</td>
            <td class='blue-text'>$brand</td>
            "
        );
        echo ("
            <td class='center'>"); if ($quantityinstock < 10) echo("<p class='red-text bold'>$quantityinstock</p>");
            else echo("<p class='green-text bold'>$quantityinstock</p>"); echo ("</td>");

        echo ("
            <td>
            
              <button name='inspect_product' value='$itemID' class='btn'>
                <i class='material-icons'>search</i>
              </button>
            </td> 
          </tr>"
        );
      }
      unset($_POST["search_product"]);
    }
  }

  protected function inspectProduct(){
    // inspect product
    $itemID = $_GET["inspect_product"];
    $sql = "SELECT * FROM Items where ItemID = '$itemID' ORDER BY Brand";
    $result = $this->conn()->query($sql) or die("<p> * ItemID error, please try again!</p>");
    while ($row = $result->fetch_assoc())    
    {
      $itemID = $row["ItemID"];
      $image = $row['Image'];
      $name = $row['Name'];
      $brand = $row["Brand"];
      $description = $row["Description"];
      $category = $row["Category"];
      $category = Item::CATEGORY_ICON[(int)$category];
      $sellingprice = $row["SellingPrice"];
      $sellingprice = "RM ". number_format($sellingprice, 2);
      $quantityinstock = $row["QuantityInStock"];

      echo(
        "<tr>
          <td><img class='shadow-img' src='product_images/$image' style='height:100px;'></td>
          <td>$name</td>
          <td>$brand</td>
          <td>$description</td>
          <td><i class='material-icons prefix'>$category</i></td>
          <td>$sellingprice</td>
          <td>$quantityinstock</td>
          <td><a>
            <a class='btn yellow darken-4 white-text' href='admin_edit_products.php?item_id=$itemID'>Edit</a>
            <button class='btn red darken-4' name='delete_product' value='$itemID'
            onclick=\"return confirm('Are you sure you want to delete record: \'$name, $brand\'?');\">Delete</button>
          </a></td>
        </tr>"
      );
    }
  }

  protected function searchMembers(){
    if (isset($_POST["search_members"]))
    {
      $searchMember = $_POST["search_members"];

      $util = new CommonUtil();

      if ($util->EmptyInputSelect($searchMember))
        echo "<p class='prompt-warning'>Please enter a value!<p>";
      else
      {
        $sql = "SELECT M.*, O.*, P.* FROM Members M, Orders O, Payment P
          WHERE (M.Username LIKE '%$searchMember%' OR M.Email LIKE '%$searchMember%') 
          AND M.PrivilegeLevel = 0 AND P.OrderID = O.OrderID  AND M.MemberID = O.MemberID ORDER BY P.PaymentDate DESC";

        $result = $this->conn()->query($sql) or die ("Select statement FAILED!");
        while ($row = $result->fetch_assoc()) 
        {
          $memberID = $row["MemberID"];
          $searchMember = $row["Username"];
          $email = $row["Email"];
          $orderID = $row["OrderID"];
          $paymentDate = $row["PaymentDate"];
          
          echo(
            "<table class='responsive-table' style='table-layout: fixed; width: 100%;' id='pagination'>
            <tbody>
              <tr>
                <td>$searchMember</td>
                <td>$email</td>
                <td>$orderID</td>
                <td>$paymentDate</td>
                <td>
                  <form action='admin_view_orders.php' method='GET'>
                    <input type='hidden' name='username' value='$searchMember'/>
                    <input type='hidden' name='member_id' value='$memberID'/>
                    <button name='view_order' value=1 class='btn' type='submit'>
                      <i class='material-icons'>search</i>
                    </button>
                  </form>
                </td>
              </tr>
            </tbody>
          </table>"
          );
          exit();
        }
      }
    }
  }
}