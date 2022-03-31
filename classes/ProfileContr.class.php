<?php

class ProfileContr extends CommonUtil{
  private $username;
  private $pwd;
  private $repeatPwd;
  private $email;
  private $memberID;

  public function __construct($username, $pwd, $repeatPwd, $email, $memberID)
  {
    $this->username = $username;
    $this->pwd = $pwd;
    $this->repeatPwd = $repeatPwd;
    $this->email = $email;
    $this->memberID = $memberID;
  }

  private function setUserAccount($username, $pwd, $email, $memberID) {
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "UPDATE Members SET Username = ?, Password=?, Email = ? where MemberID = ?;";
    $stmt = $this->conn()->stmt_init();
    if (!$stmt->prepare($sql)) {
      header("location: ../manage_profile.php?error=Statementfailed");
      exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    $stmt->bind_param("sssi", $username, $hashedPwd, $email, $memberID);
    $stmt->execute();
    $stmt->close();

    session_start();
    /** @var Member $member */
    $member = $_SESSION["Member"];
    $member->setUsername($username);
    $member->setEmail($email);
    $_SESSION["Member"] = $member;
  }

  public function updateUserAccount() {
    if ($this->pwdNotMatch($this->pwd, $this->repeatPwd))
    {
      header("location: ../manage_profile.php?error=passwords_dont_match");
      exit();
    }

    if ($this->emptyInput($this->username, $this->pwd, $this->repeatPwd, $this->email))
    {
      header("location: ../manage_profile.php?error=empty_input");
      exit();
    } 

    if ($this->invalidUid($this->username))
    {
      header("location: ../manage_profile.php?error=invalid_uid");
      exit();
    }

    if (!$this->uidExists($this->username, $this->email))
    {
      header("location: ../manage_profile.php?error=invalid_uid");
      exit();
    } 

    $this->setUserAccount($this->username, $this->pwd, $this->email, $this->memberID);

    header("location: ../manage_profile.php?error=none");
    exit();
  }
}