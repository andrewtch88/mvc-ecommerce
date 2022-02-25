<?php 

require_once "class_autoloader.php";
$dbh = new Dbhandler();

// if searchMember is not set or searchMember is empty

$sql = "SELECT M.Username, M.Email, M.MemberID, O.* FROM Members M, Orders O 
  WHERE M.MemberID = O.MemberID AND O.CartFlag = 1 ORDER BY O.OrderID DESC";
$result = $dbh->conn()->query($sql) or die($dbh->conn()->error);
while ($row = $result->fetch_assoc()) 
{
  $memberID = $row["MemberID"];
  $searchMember = $row["Username"];
  $email = $row["Email"];
  $orderID = $row["OrderID"];
  $cartFlag = $row["CartFlag"];
    
    echo(
    "
    <table class='responsive-table' style='table-layout: fixed; width: 100%;' id='pagination'>
      <tbody>
        <tr>
          <td>$searchMember</td>
          <td>$email</td>
          <td style='margin-left: 100px'>$orderID</td>
          <td>$cartFlag</td>
          <td>
            <form action='admin_view_orders.php' method='GET'>
              <input type='hidden' name='username' value='$searchMember'/>
              <input type='hidden' name='member_id' value='$memberID'/>
              <button name='view_order' value=1 class='btn' type='submit'>
                <i class='material-icons'>search</i>
              </button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
    "
  );
}