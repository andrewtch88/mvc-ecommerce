<?php 

class Login extends CommonUtil{
  protected function getUser($username, $pwd) {
    $row = $this->uidExists($username);

    if ($row === false)
    {
      header("location: ../login.php?error=WrongLogin");
      exit();
    }

    $pwdHashed = $row["Password"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
      header("location: ../login.php?error=WrongLogin");
      exit();
    }
    if ($checkPwd === true) {

      session_start();
      require_once "../includes/class_autoloader.php";
      $member = new Member(
        $row["MemberID"],
        $row["Username"],
        $row["Email"],
        $row["PrivilegeLevel"]
      );

      $_SESSION["Member"] = $member;
      header("location: ../index.php");
      exit();
    }
  }
}