<?php
require_once "class_autoloader.php";

$util = new CommonUtil;
$dbh = new Dbhandler;

// This page handles admin forms only

function uidExists($username, $email, $util) {
  $sql = "SELECT * FROM Members WHERE Username = ? 
    OR Email = ?;";
  $stmt = $util->conn()->stmt_init();

  if (!$stmt->prepare($sql))
  {
    header("location: ../login.php?error=stmtfailed");
    exit();
  }

  $stmt->bind_param("ss", $username, $email);
  $stmt->execute();
  
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) return $row;
  else return false;

  $stmt->close();
}

// Manage User
if (isset($_POST["submit"]))
{
  $username = $_POST["username"];
  $pass = $_POST["pwd"];
  $repeatPass = $_POST["repeat_pwd"];
  $email = $_POST["email"];
  $privilegeLevel = $_POST["level"];

  if ($util->EmptyInputCreateUser($username, $pass, $repeatPass, $email, $privilegeLevel))
  {
    echo "<script>document.getElementById('message').className = 'errormsg';</script>";
    echo "<script>document.getElementById('message').innerHTML = '*Fill in all fields!';</script>";
    exit();
  }
  if ($util->pwdNotMatch($pass, $repeatPass))
  {
    echo "<script>document.getElementById('message').className = 'errormsg';</script>";
    echo "<script>document.getElementById('message').innerHTML = '*Passwords doesn't match!';</script>";
    exit();
  }
  if ($util->invalidUid($username))
  {
    echo "<script>document.getElementById('message').className = 'errormsg';</script>";
    echo "<script>document.getElementById('message').innerHTML = '*Choose a proper username!';</script>";
    exit();
  }
  if (uidExists($username, $email, $util))
  {
    echo "<script>document.getElementById('message').className = 'errormsg';</script>";
    echo "<script>document.getElementById('message').innerHTML = '*Username/Email already taken!';</script>";
    exit();
  }

  $privilegeLevel -= 1;
  $util->setUser($username, $pass, $email, $privilegeLevel);
  echo "<script>document.forms['create'].reset()</script>";
  echo "<script>document.getElementById('message').className = 'green-text';</script>";
  echo "<script>document.getElementById('message').innerHTML = 'Added User.';</script>";
}

// Manage Products
if (isset($_POST["submit_product"]))
{
  $name = $_POST["productName"];
  $brand = $_POST["brand"];
  $description = $_POST["description"];
  $category = $_POST["category"];
  $sellingprice = $_POST["sellingprice"];
  $quantityinstock = $_POST["quantityinstock"];
  $image = $_POST["image"];

  if ($util->EmptyInputCreateProduct($name, $brand, $description, $category, $sellingprice, $quantityinstock, $image))
  {
    echo "<script>document.getElementById('message').className = 'errormsg';</script>";
    echo "<script>document.getElementById('message').innerHTML = '*Fill in all fields!';</script>";
    exit();
  }

  if ($util->productExists($image)) {
    echo "<script>document.getElementById('message').className = 'errormsg';</script>";
    echo "<script>document.getElementById('message').innerHTML = '*Product exists! Please try another image.';</script>";
    exit();
  }

  $util->setProduct($name, $brand, $description, $category, $sellingprice, $quantityinstock, $image);
  echo "<script>document.forms['create'].reset()</script>";
  echo "<script>document.getElementById('image').src = null;</script>";
  echo "<script>document.getElementById('message').className = 'green-text';</script>";
  echo "<script>document.getElementById('message').innerHTML = 'Added Product.';</script>";
}

// Edit products
// get item id from url and fetch product
if (isset($_GET['item_id']))
{
  $itemID = $_GET['item_id'];
  $sql = "SELECT ItemID, Name, Brand, Description, Category, SellingPrice, QuantityInStock, Image
    FROM Items WHERE ItemID = $itemID";

  $result = $dbh->conn()->query($sql) or die ($dbh->conn()->error);

  list($item_id, $name, $brand, $description, $category, $sellingprice, $quantityinstock, $image)
    = $result->fetch_array();

  echo "<p style='visibility: hidden' id='category_id'>$category</p>";
}

if (isset($_POST["update"]))
{
  $name = $_POST['name'];
  $brand = $_POST["brand"];
  $description = $_POST["description"];
  $category = $_POST["category"];
  $sellingprice = $_POST["sellingprice"];
  $quantityinstock = $_POST["quantityinstock"];
  $image = $_POST['image'];
  
  if ($util->EmptyInputCreateProduct($name, $brand, $description, $category, $sellingprice, $quantityinstock, $image))
  {
    echo '<META HTTP-EQUIV="Refresh" Content="2; URL=admin_edit_products.php?error=empty_input">';
    exit();
  }

  $sql = "UPDATE Items SET Name='$name', Brand='$brand', Description='$description',
    Category=$category, SellingPrice='$sellingprice', QuantityInStock=$quantityinstock,
    Image='$image' WHERE ItemID=$itemID;";

  $dbh->conn()->query($sql) or die($dbh->conn()->error);
  $dbh->conn()->close();
}


