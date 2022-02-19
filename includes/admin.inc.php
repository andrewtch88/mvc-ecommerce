<?php

if (isset($_POST["username"]))
{
  $username = $_POST["username"];
  $pass = $_POST["pwd"];
  $repeatPass = $_POST["repeat_pwd"];
  $email = $_POST["email"];
  $privilegeLevel = $_POST["level"];

  $util = new CommonUtil;

  if (EmptyInputCreateUser($username, $pass, $repeatPass, $email, $privilegeLevel))
  {
    echo("<script>location.href = 'admin_manage_users.php?error=empty_input';</script>");
    exit();
  }
  if ($util->pwdNotMatch($pass, $repeatPass))
  {
    echo("<script>location.href = 'admin_manage_users.php?error=passwords_dont_match';</script>");
    exit();
  }
  if ($util->invalidUid($username))
  {
    echo("<script>location.href = 'admin_manage_users.php?error=invalid_uid';</script>");
    exit();
  }
  if ($util->uidExists($username, $email))
  {
    echo("<script>location.href = 'admin_manage_users.php?error=username_taken';</script>");
    exit();
  }

  $privilegeLevel -= 1;
  $util->setUser($username, $pass, $email, $privilegeLevel);
  echo("<script>location.href = 'admin_manage_users.php?error=none';</script>");
  $this->conn()->close();
}