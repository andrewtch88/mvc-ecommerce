<?php 

class CommonUtil extends Dbhandler{

  public function productExists($image){
    $sql = "SELECT * FROM Items where Image = ?;";
    $stmt = $this->conn()->stmt_init();
    if (!$stmt->prepare($sql))
    {
      header("location: ../<script>window.location.href</script>?error=stmtfailed");
      exit();
    }

    $stmt->bind_param("s", $image);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) return $row;
    else return false;

    $stmt->close();
  }

  public function uidExists($loginName) {
    $sql = "SELECT * FROM Members WHERE Username = ? 
      OR Email = ?";
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

  // create member
  public function setUser($username, $pwd, $email, $privilegeLevel=0, $attempt=3) {
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Members(Username, Password, Email, PrivilegeLevel, Attempt, RegisteredDate)
      VALUES ('$username', '$hashedPwd', '$email', $privilegeLevel, $attempt, CURRENT_TIME);";
    $this->conn()->query($sql) or die("<p>*User creation error, please try again!</p>");

    // get member id
    $sql = "SELECT MemberID FROM Members where Username = '$username';";
    $result = $this->conn()->query($sql) or die("<p>*MemberID error, please try again!</p>");

    $row = $result->fetch_assoc();
    $memberID = $row["MemberID"];

    // create cart
    $sql = "INSERT INTO Orders(MemberID) VALUES ($memberID);";
    $result = $this->conn()->query($sql) or die("<p>*Cart creation error, please try again!</p>");
    $this->conn()->close();
  }

  // create product
  public function setProduct($name, $brand, $description, $category, $sellingprice, $quantityinstock, $image)
  {
    $sql = "INSERT INTO Items(Name, Brand, Description, Category, SellingPrice, QuantityInStock, Image)
      VALUES ('$name', '$brand', '$description', $category, $sellingprice, $quantityinstock, '$image');";
    $this->conn()->query($sql) or die("<p>*Product creation error, please try again!</p>");
  }

  function EmptyInputCreateProduct($name, $brand, $description, $category, $sellingprice, $quantityinstock, $image)
  {
    return empty($name) || empty($brand) || empty($description) or
    ($category === "") || empty($sellingprice) ||
    empty($quantityinstock) || empty($image);
  }

  public function emptyInput($username, $pwd, $repeatPwd, $email)
  { return empty($username) || (empty($pwd)) || (empty($repeatPwd)) || (empty($email)); }

  public function invalidUid($username) { return !preg_match("/^[a-zA-Z0-9]*$/", $username); }

  public function pwdNotMatch($pwd, $repeatPwd) { return $pwd !== $repeatPwd; }

  public function EmptyInputCreateUser($username, $pwd, $repeatPwd, $privilegeLevel, $email)
    { return empty($username) || (empty($pwd)) || (empty($repeatPwd)) or ($privilegeLevel === "") || (empty($email));}

  public function EmptyInputSelect($value) { return empty($value); }
}
