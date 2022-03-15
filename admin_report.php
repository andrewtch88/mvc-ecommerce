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
	$result1 = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 2 day and payment.PaymentDate< now() - INTERVAL 1 day");
	
	$result2 = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 3 day and payment.PaymentDate< now() - INTERVAL 2 day");

	$result3 = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 4 day and payment.PaymentDate< now() - INTERVAL 3 day");

	$result4 = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 5 day and payment.PaymentDate< now() - INTERVAL 4 day");

	$result5 = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 6 day and payment.PaymentDate< now() - INTERVAL 5 day");

	$result6 = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 7 day and payment.PaymentDate< now() - INTERVAL 6 day");

	$result7 = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 8 day and payment.PaymentDate< now() - INTERVAL 7 day");

	$result_tot = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 7 day");
	
	$result_month1 = mysqli_query($con,"SELECT sum(orderitems.Price * orderitems.Quantity) as Amount, payment.PaymentDate FROM ((payment INNER JOIN orders on payment.OrderID=orders.OrderID)
	INNER JOIN orderitems on orders.OrderID=orderitems.OrderID)WHERE orders.CartFlag =0 and payment.PaymentDate> now() - INTERVAL 30 day");

	?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>

<body>

<div class="container" style="margin-top:150px">
	<h3 class="page-title">Weekly report</h3>
	<div class="rounded-card-parent center" style="margin-bottom:20px">
		<h5 style="color:white">Sales graph</h5>
		<p style="color:white">Sales vs Week graph</p>
		<div>
		<canvas id="myChart" style="width:100%"></canvas>
		</div>
		
		<!--result1-->
		<?php
			while ($row=mysqli_fetch_array($result1)) {
		?>
		<?php
		$amt1=$row['Amount'];
				
		if(is_null($amt1)) {
			$amt1 = 0;
		}
		
		$date1=$row['PaymentDate'];
		}
		
		if(is_null($date1)) {
			$date1 = date('Y-m-d',strtotime("- 1 days"));
		}
		?>
		
		<!--result2-->
		<?php
			while ($row=mysqli_fetch_array($result2)) {
		?>
		<?php
		$amt2=$row['Amount'];
		
		if(is_null($amt2)) {
			$amt2 = 0;
		}
		
		$date2=$row['PaymentDate'];
		}
		
		if(is_null($date2)) {
			$date2 = date('Y-m-d',strtotime("- 2 days"));
		}
		?>
		
		<!--result3-->
		<?php
			while ($row=mysqli_fetch_array($result3)) {
		?>
		<?php
		$amt3=$row['Amount'];
				
		if(is_null($amt3)) {
			$amt3 = 0;
		}
		
		$date3=$row['PaymentDate'];
		}
				
		if(is_null($date3)) {
			$date3 = date('Y-m-d',strtotime("- 3 days"));
		}
		?>
		
		<!--result4-->
		<?php
			while ($row=mysqli_fetch_array($result4)) {
		?>
		<?php
		$amt4=$row['Amount'];
				
		if(is_null($amt4)) {
			$amt4 = 0;
		}
		
		$date4=$row['PaymentDate'];
		}
				
		if(is_null($date4)) {
			$date4 = date('Y-m-d',strtotime("- 4 days"));
		}
		?>
		
		<!--result5-->
		<?php
			while ($row=mysqli_fetch_array($result5)) {
		?>
		<?php
		$amt5=$row['Amount'];
				
		if(is_null($amt5)) {
			$amt5 = 0;
		}
		
		$date5=$row['PaymentDate'];
		}
				
		if(is_null($date5)) {
			$date5 = date('Y-m-d',strtotime("- 5 days"));
		}
		?>
		
		<!--result6-->
		<?php
			while ($row=mysqli_fetch_array($result6)) {
		?>
		<?php
		$amt6=$row['Amount'];
				
		if(is_null($amt6)) {
			$amt6 = 0;
		}
		
		$date6=$row['PaymentDate'];
		}
				
		if(is_null($date6)) {
			$date6 = date('Y-m-d',strtotime("- 6 days"));
		}
		?>
		
		<!--result7-->
		<?php
			while ($row=mysqli_fetch_array($result7)) {
		?>
		<?php
		$amt7=$row['Amount'];
				
		if(is_null($amt7)) {
			$amt7 = 0;
		}
		
		$date7=$row['PaymentDate'];
		}
				
		if(is_null($date7)) {
			$date7 = date('Y-m-d',strtotime("- 7 days"));
		}
		?>
		<?php
			while ($row=mysqli_fetch_array($result_tot)) {
				$data_tot=$row['Amount'];
			}
		?>
		
		<h4 style="color:white">Total sales of last 7 days: <?php echo $data_tot?></h4>
		<h4 style="color:white">Start Date: <?php echo $date7?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
		End Date: <?php echo $date1?></h4></h4>
	</div>
	<br><br><br>
	<h3 class="page-title">Monthly report</h3>
	<div class="rounded-card-parent center" style="margin-bottom:20px">
		<h5 style="color:white">Sales graph</h5>
		<p style="color:white">Sales vs Month graph</p>
		<div>
		<canvas id="myChart2" style="width:100%"></canvas>
		</div>
		
		<!--result_month1-->
		<?php
			while ($row=mysqli_fetch_array($result_month1)) {
		?>
		<?php
		$amt_m1=$row['Amount'];
				
		if(is_null($amt1)) {
			$amt_m1 = 0;
		}
		
		$date_m1=$row['PaymentDate'];
		}
		
		if(is_null($date_m1)) {
			$date_m1 = date('Y-m-d',strtotime("- 30 days"));
		}
		?>
		
	</div>
	<h5><a href="admin_report.php">Back</a></h5>
</div>
<script>
var amt = [<?php echo json_encode($amt7);?>,<?php echo json_encode($amt6);?>,<?php echo json_encode($amt5);?>
,<?php echo json_encode($amt4);?>,<?php echo json_encode($amt3);?>,<?php echo json_encode($amt2);?>
,<?php echo json_encode($amt1);?>];

var date = [<?php echo json_encode($date7);?>,<?php echo json_encode($date6);?>,<?php echo json_encode($date5);?>
,<?php echo json_encode($date4);?>,<?php echo json_encode($date3);?>,<?php echo json_encode($date2);?>
,<?php echo json_encode($date1);?>];

var xValues = date;
var yValues = amt;

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

var amt2 = [0,<?php echo json_encode($amt_m1);?>];
var date2 = [0,<?php echo json_encode($date_m1);?>];

var yValues_m = amt2;
var xValues_m = date2;
var barColors = "rgba(0,255,0,0.4)";

new Chart("myChart2", {
	type: "bar",
	data: {
		labels: xValues_m,
		datasets: [{
		backgroundColor: barColors,
		data: yValues_m
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
					fontColor: "#00FFd0",
					fontSize: 18,
				}
			}],
			xAxes: [{
				gridLines: {
					display: true,
					color: "rgba(0,255,0,0.4)",
				},
				ticks: {
					fontColor: "#00FFd0",
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