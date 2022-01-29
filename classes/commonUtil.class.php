<?php 

class CommonUtil extends Dbhandler{

  public function uidExists($loginName) {
    $sql = "SELECT * FROM Members where Username = ? OR Email = ?;";
    $stmt = $this->conn()->stmt_init();
    
    if (!$stmt->prepare($sql))
    {
      header("location: ../login.php?error=stmtfailed");
      exit();
    }
    
    $stmt->bind_param("ss", $loginName, $loginName);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) return $row;
    else return false;

    $stmt->close();
  }

  public function setUser($username, $pwd, $email, $privilegeLevel=0) {
    // create member
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Members(Username, Password, Email, PrivilegeLevel)
      VALUES ('$username', '$hashedPwd', '$email', $privilegeLevel);";
    $this->conn()->query($sql) or die("<p>*User creation error, please try again!</p>");

    // get member id
    $sql = "SELECT MemberID FROM Members where Username = '$username';";
    $result = $this->conn()->query($sql) or die("<p>*MemberID error, please try again!</p>");

    $row = $result->fetch_assoc();
    $memberID = $row["MemberID"];

    // create cart
    $sql = "INSERT INTO Orders(MemberID) VALUES ($memberID);";
    $result = $this->conn()->query($sql) or die("<p>*Cart creation error, please try again!</p>");
  }

  public function emptyInput($username, $pwd, $repeatPwd, $email)
  { return empty($username) || (empty($pwd)) || (empty($repeatPwd)) || (empty($email)); }

  public function invalidUid($username)
  { return !preg_match("/^[a-zA-Z0-9]*$/", $username); }

  public function pwdNotMatch($pwd, $repeatPwd)
  { return $pwd !== $repeatPwd; }
}
