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

<!--
<style>
	canvas#myChart {
		font-color: #808080;
	}
</style>
-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>

<body>
<div class="container" style="margin-top:150px">
	<h3 class="page-title">Report</h3>
	<div class="rounded-card-parent center" style="margin-bottom: 100px">
		<h5 style="color:white">Sales graph</h5>
		<p style="color:white">Sales vs Week graph</p>
		<canvas id="myChart" style="width:100%"></canvas>
	</div>
</div>

<script>
var xValues = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
var yValues = [712,1228,458,2394,1229,990,3345,6880];

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

</html>

