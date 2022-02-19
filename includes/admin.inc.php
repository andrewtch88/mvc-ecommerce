<?php
require_once "class_autoloader.php";
if (isset($_POST["submit"]))
{
  $username = $_POST["username"];
  $pass = $_POST["pwd"];
  $repeatPass = $_POST["repeat_pwd"];
  $email = $_POST["email"];
  $privilegeLevel = $_POST["level"];

  $util = new CommonUtil;

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