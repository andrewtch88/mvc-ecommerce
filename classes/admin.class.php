<?php

class Admin extends Dbhandler{

  protected function searchMember(){
    function EmptyInputSelectUser($value) { return empty($value); }

    function EmptyInputCreateUser($username, $pwd, $repeatPwd, $privilegeLevel, $email)
    { return empty($username) || (empty($pwd)) || (empty($repeatPwd)) or ($privilegeLevel === "") || (empty($email));}

    if (isset($_POST["search_member"]))
    {
      $searchMember = $_POST["search_member"];
      
      if (EmptyInputSelectUser($searchMember))
        echo "<p style='color: yellow'>Please enter a value</p>";
      else
      {
        // limited search to prevent page overflow
        $sql = "SELECT Username, PrivilegeLevel FROM Members WHERE Username LIKE '%$searchMember%' ORDER BY Username LIMIT 20";
        $result = $this->conn()->query($sql) or die ("User does not exists!");
        while ($row = mysqli_fetch_assoc($result) ) 
        { 
          $username = $row["Username"]; 
          echo(
            "<tr>
              <td>$username</td>
              <td class='left-align'>
                <button name='inspect' value='$username' class='btn'>
                  <i class='material-icons'>search</i>
                </button>
              </td>
            </tr>"
          );
        }
      }
    }

    if (!isset($searchMember) || EmptyInputSelectUser($searchMember))
    {
      $sql = "SELECT Username, PrivilegeLevel FROM Members ORDER BY Username";
      $result = $this->conn()->query($sql) or die ($this->conn()->error);
      while ($row = mysqli_fetch_assoc($result) ) 
      { 
        $username = $row["Username"]; 
        echo(
          "<tr>
            <td>$username</td>
            <td class='left-align'>
              <button name='inspect' value='$username' class='btn'>
                <i class='material-icons'>search</i>
              </button>
            </td> 
          </tr>"
        );
      }
    }
  }

  protected function inspectUser(){
    // inspect user
    $uid = $_GET["inspect"];
    $sql = "SELECT MemberID, Username, Email, PrivilegeLevel FROM Members WHERE Username = '$uid' ORDER BY Username";
    $result = $this->conn()->query($sql) or die ("Select statement FAILED!");
    while ($row = mysqli_fetch_array($result))
    {
      $deleteid = $row["MemberID"];
      $username = $row["Username"];
      $email = $row["Email"];
      $privilegeLevel = $row["PrivilegeLevel"];
      echo(
        "<tr>
          <td>$deleteid</td>
          <td>$username</td>
          <td>$email</td>
          <td>$privilegeLevel</td>
        </tr>"
      );
    }
  }

  protected function createUser(){
    if (isset($_POST["submit_user"]))
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
  }
}