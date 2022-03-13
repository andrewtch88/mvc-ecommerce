<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>OG Tech - Report</title>
	<?php 
	include "header.php";
	include "static/pages/side_nav.html";
	include "static/pages/admin_nav.php";
	require_once "includes/class_autoloader.php";
	?>

	<?php
	include "conn.php";
	$result = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 7 day group by payment.PaymentDate");
	?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>

<body>

<div class="container" style="margin-top:150px">
	<h3 class="page-title">Report</h3>
	<div class="rounded-card-parent center" style="margin-bottom: 100px">
		<h5 style="color:white">Sales graph</h5>
		<p style="color:white">Sales vs Week graph</p>
		<canvas id="myChart" style="width:100%"></canvas>
		<?php
			$x = 0;
			while ($row=mysqli_fetch_array($result)) {
		?>
		<h1>test : <?php echo $row['Amount']?></h1>
		<h1>test : <?php echo $row['PaymentDate']?></h1>
		<?php
		$data[$x]=$row['Amount'];
		$x = $x + 1;
		}
		?>
		<p id="js"></p>
	</div>
</div>
<?php
echo json_encode($data);
?>
<input type="text" name="test" value="<?php echo json_encode($data);?>"></input>
<script>

var result = [1255,3242,6673,3444,8888,1234];
var result = <?php echo json_encode($data);?>;

var xValues = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
var yValues = result;

new Chart("myChart", {
	type: "line",
	data: {
		labels: xValues,
		datasets: [{
			fill: false,
			lineTension: 0,
			backgroundColor: "rgba(0,255,0,1)",
			borderColor: "rgba(0,255,255,0.4)",
			data: yValues
		}]
	},
	options: {
		legend: {display: false},
		scales: {
			yAxes: [{
				gridLines: {
					display: true,
					color: "rgba(0,255,0,0.4)",
				},
				ticks: {
					fontColor: "#00ffd0",
					fontSize: 18,
					beginAtZero: true
				}
			}],
			xAxes: [{
				gridLines: {
					display: true,
					color: "rgba(0,255,0,0.4)",
				},
				ticks: {
					fontColor: "#00ffd0",
					fontSize: 18,
				}
			}],
		}
	}
});
</script>
</body>
 <?php include "footer.php"; ?>
</html>

<!--
Warning: Undefined variable $result in C:\xampp\htdocs\HotsTech\admin_report.php on line 20

Fatal error: Uncaught TypeError: mysqli_fetch_array(): Argument #1 ($result) must be of type mysqli_result, null given in C:\xampp\htdocs\HotsTech\admin_report.php:20 Stack trace: #0 C:\xampp\htdocs\HotsTech\admin_report.php(20): mysqli_fetch_array(NULL) #1 {main} thrown in C:\xampp\htdocs\HotsTech\admin_report.php on line 20
-->