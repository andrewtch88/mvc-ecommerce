<?php
require_once "class_autoloader.php";

$util = new CommonUtil;

function EmptyInputCreateProduct($name, $brand, $description, $category, $sellingprice, $quantityinstock, $image)
{
  return empty($name) || empty($brand) || empty($description) or
  ($category === "") || empty($sellingprice) ||
  empty($quantityinstock) || empty($image);
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
  if ($util->uidExists($username, $email))
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

  if (EmptyInputCreateProduct($name, $brand, $description, $category, $sellingprice, $quantityinstock, $image))
  {
    echo "<script>document.getElementById('message').className = 'errormsg';</script>";
    echo "<script>document.getElementById('message').innerHTML = '*Fill in all fields!';</script>";
    exit();
  }

  $util->setProduct($name, $brand, $description, $category, $sellingprice, $quantityinstock, $image);
  echo "<script>document.forms['create'].reset()</script>";
  echo "<script>document.getElementById('image').src = null;</script>";
  echo "<script>document.getElementById('message').className = 'green-text';</script>";
  echo "<script>document.getElementById('message').innerHTML = 'Added Product.';</script>";
}
