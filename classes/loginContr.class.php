<?php 

class LoginContr extends Login {

  private $username;
  private $pwd;

  public function __construct($username, $pwd)
  {
    $this->username = $username;
    $this->pwd = $pwd;
  }

  private function checkEmptyInput() {
    if (empty($this->username) || empty($this->pwd)) {
      $result = false;
    }
    else{
      $result = true;
    }
    return $result;
  }

  public function LoginUser() {
    if($this->checkEmptyInput($this->username, $this->pwd) == false) {
      header("location: ../login.php?error=empty_input");
      exit();
    }
    $this->getUser($this->username, $this->pwd); 
  }
}