<?php 
/**
 * @param mysqli $this->connect()
*/

class CommonUtil extends Dbhandler{

  function uidExists($loginName) {
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
}
