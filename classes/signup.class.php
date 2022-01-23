<?php 

class Signup extends Dbhandler {
  protected function setUser($username, $pwd, $email, $privilegeLevel=0) {
    $sql = "INSERT INTO Members (Username, Password, Email, PrivilegeLevel)
      VALUES (?, ?, ?, ?);";
    $stmt = $this->conn()->prepare($sql);

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    if (!$stmt->execute(array($username, $hashedPwd, $email, $privilegeLevel))) {
      $stmt = null;
      header("location: ../signup.php?error=stmtfailed");
      exit();
    }

    $stmt = null;

    // get member id
    $sql = "SELECT MemberID FROM Members where Username = '$username';";
    $result = $this->conn()->query($sql) or die("<p>*MemberID error, please try again!</p>");

    $row = $result->fetch_assoc();
    $memberID = $row["MemberID"];

    // create cart
    $sql = "INSERT INTO Orders(MemberID) VALUES ($memberID);";
    $this->conn()->query($sql) or die("<p>*Cart creation error, please try again!</p>");
  }

  protected function checkUser($username, $email) {
    $sql = "SELECT Username FROM Members WHERE Username = ? 
      OR Email = ?;";
    $stmt = $this->conn()->stmt_init();

    if (!$stmt->prepare($sql))
    {
      header("location: ../login.php?error=stmtfailed");
      exit();
    }

    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    
    $resultCheck = null;

    if ($stmt->num_rows > 0) {
      $resultCheck = false;
    }
    else {
      $resultCheck = true;
    }

    return $resultCheck;
  }
}