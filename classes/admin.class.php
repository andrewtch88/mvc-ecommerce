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
}