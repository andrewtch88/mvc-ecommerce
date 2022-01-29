<?php 

include_once "class_autoloader.php";

if (isset($_POST["update"])) 
{
  $username = $_POST["username"];
  $pwd = $_POST["pwd"];
  $repeatPwd = $_POST["repeat_pwd"];
  $email = $_POST["email"];
  $memberID = $_POST["id"];

  $setAcc = new ProfileContr($username, $pwd, $repeatPwd, $email, $memberID);
  $setAcc->updateUserAccount();
}
else
{
  header("location: ../manage_profile.php");
  exit();
}