<?php 
require_once "class_autoloader.php";

if (isset($_POST["submit"])) {
  
  $username = $_POST["username"];
  $pwd = $_POST["pwd"];

  $login = new LoginContr($username, $pwd);

  $login->LoginUser();
} else
{
  header("location: ../login.php");
  exit();
}