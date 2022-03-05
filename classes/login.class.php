<?php 

class Login extends CommonUtil{
  protected function getUser($username, $pwd) {
    $row = $this->uidExists($username);

    if ($row === false)
    {
      header("location: ../login.php?error=usernotfound");
      exit();
    }

    $pwdHashed = $row["Password"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
      $loginAttempt = $row["Attempt"];
      header("location: ../login.php?error=WrongLogin");
      $loginAttempt = $loginAttempt - 1;
      $username = $row["Username"];
      $updateAttempt = "UPDATE Members SET Attempt = $loginAttempt WHERE Username = '$username'";
      $this->conn()->query($updateAttempt) or die("<p>*Unknown Error!</p>");
      $this->conn()->close();
      
      if ($loginAttempt < 1) {
        header("location: ../login.php?error=attemptReached");
  
        // wait 30 seconds
        $time = time_sleep_until(time() + 3);
        
        if (time() >= $time) {
          // resets login attempt
          $updateAttempt = "UPDATE Members SET Attempt = 3 WHERE Username = '$username'";
          $this->conn()->query($updateAttempt) or die("<p>*Unknown Error!</p>");
          $this->conn()->close();
        }
      }
    }

    if ($checkPwd === true) {
      $loginAttempt = $row["Attempt"];

      if ($loginAttempt > 0) {
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
      else {
        header("location: ../login.php?error=attemptReached");
        exit();
      }
    }
  }
}