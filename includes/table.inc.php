<?php 

require_once "class_autoloader.php";
$dbh = new Dbhandler();

// Admin manage orders (autosync table only)
// if searchMember is not set or searchMember is empty
// only non admin users payment is shown

$sql = "SELECT M.*, O.*, P.* FROM Members M, Orders O, Payment P
  WHERE M.PrivilegeLevel = 0 AND P.OrderID = O.OrderID  AND M.MemberID = O.MemberID ORDER BY P.PaymentDate DESC";
$result = $dbh->conn()->query($sql) or die($dbh->conn()->error);
while ($row = $result->fetch_assoc()) 
{
  $memberID = $row["MemberID"];
  $searchMember = $row["Username"];
  $email = $row["Email"];
  $orderID = $row["OrderID"];
  $paymentDate = $row["PaymentDate"];
    
    echo(
    "
    <table class='responsive-table' style='table-layout: fixed; width: 100%;' id='pagination'>
      <tbody>
        <tr>
          <td>$searchMember</td>
          <td>$email</td>
          <td>$orderID</td>
          <td>$paymentDate</td>
          <td
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