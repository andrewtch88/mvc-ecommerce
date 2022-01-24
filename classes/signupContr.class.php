<?php 

class SignupContr extends Signup {

  private $username;
  private $pwd;
  private $repeatPwd;
  private $email;

  public function __construct($username, $pwd, $repeatPwd, $email)
  {
    $this->username = $username;
    $this->pwd = $pwd;
    $this->repeatPwd = $repeatPwd;
    $this->email = $email;
  }

  private function emptyInput() {
    $result = null;
    if (empty($this->username) || empty($this->pwd) || empty($this->repeatPwd) || empty($this->email)) {
      $result = false;
    }
    else{
      $result = true;
    }
    return $result;
  }

  private function invalidUid() {
    $result = null;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username) !== false) {
      $result = false;
    }
    else{
      $result = true;
    }
    return $result;
  }

  private function pwdNotMatch() {
    $result = null;
    if ($this->pwd !== $this->repeatPwd) {
      $result = false;
    }
    else{
      $result = true;
    }
    return $result;
  }

  private function uidExists() {
    $result = null;
    if ($this->checkUser($this->username, $this->email)) {
      $result = false;
    }
    else{
      $result = true;
    }
    return $result;
  }

  public function createUser() {
    if($this->emptyInput() == false) {
      header("location: ../signup.php?error=empty_input");
      exit();
    }

    if($this->invalidUid() == false) {
      header("location: ../signup.php?error=invalid_uid");
      exit();
    }

    if($this->pwdNotMatch() == false) {
      header("location: ../signup.php?error=passwords_dont_match");
      exit();
    }

    if($this->uidExists() == false) {
      header("location: ../signup.php?error=username_taken");
      exit();
    }

    $this->setUser($this->username, $this->pwd, $this->email);
  }
}