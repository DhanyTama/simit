
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="ilmu-detil.blogspot.com">
	<title>Bootstrap Graph Using Highcharts </title>
	<!-- Bagian css -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/ilmudetil.css">
	
	<script src="assets/js/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
		$(function () {
			var chart;
			$(document).ready(function() {
				$.getJSON("dataline.php", function(json) {
				
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'mygraph',
							type: 'line'
							
						},
						title: {
							text: 'Comparison of computer, internet, wifi, sim, printer, telepon, iphone and other'
							
						},
						subtitle: {
							text: ''
						
						},
						xAxis: {
							categories: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12']
						},
						yAxis: {
							title: {
								text: 'Jumlah'
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}]
						},
						tooltip: {
							formatter: function() {
									return '<b>'+ this.series.name +'</b><br/>'+
									this.x +': '+ this.y;
							}
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'top',
							x: -10,
							y: 120,
							borderWidth: 0
						},
						series: 
							<?php
							$con=mysqli_connect("localhost","root","","eit");
							$tgl=date('Y-m');
							if (!$con) {
							  die('Could not connect: ' . mysql_error());
							}

							
							// Data for Sugar
							$query = mysqli_query($con,"SELECT Komputer FROM grafik where tanggal like'%$tgl%'");
							$rows1 = array();
							$rows1['name'] = 'Komputer';
							while($tmp= mysqli_fetch_array($query)) {
								$rows1['data'][] = $tmp['Komputer'];
							}

							// Data for Rice
							$query = mysqli_query($con,"SELECT Internet FROM grafik where tanggal like'%$tgl%'");
							$rows2 = array();
							$rows2['name'] = 'Internet';
							while($tmp = mysqli_fetch_array($query)) {
								$rows2['data'][] = $tmp['Internet'];
							}

							// Data for Wheat Flour
							$query = mysqli_query($con,"SELECT Wifi FROM grafik where tanggal like'%$tgl%'");
							$rows3 = array();
							$rows3['name'] = 'Wifi';
							while($tmp = mysqli_fetch_array($query)) {
								$rows3['data'][] = $tmp['Wifi'];
							}

							// Data for Wheat Flour
							$query = mysqli_query($con,"SELECT Sim FROM grafik where tanggal like'%$tgl%'");
							$rows4 = array();
							$rows4['name'] = 'Sim';
							while($tmp = mysqli_fetch_array($query)) {
								$rows4['data'][] = $tmp['Sim'];
							}

							// Data for Wheat Flour
							$query = mysqli_query($con,"SELECT Printer FROM grafik where tanggal like'%$tgl%'");
							$rows5 = array();
							$rows5['name'] = 'Printer';
							while($tmp = mysqli_fetch_array($query)) {
								$rows5['data'][] = $tmp['Printer'];
							}

							// Data for Wheat Flour
							$query = mysqli_query($con,"SELECT Telepon FROM grafik where tanggal like'%$tgl%'");
							$rows6 = array();
							$rows6['name'] = 'Telepon';
							while($tmp = mysqli_fetch_array($query)) {
								$rows6['data'][] = $tmp['Telepon'];
							}

							// Data for Wheat Flour
							$query = mysqli_query($con,"SELECT Iphone FROM grafik where tanggal like'%$tgl%'");
							$rows7 = array();
							$rows7['name'] = 'Iphone';
							while($tmp = mysqli_fetch_array($query)) {
								$rows7['data'][] = $tmp['Iphone'];
							}

							// Data for Wheat Flour
							$query = mysqli_query($con,"SELECT Lainnya FROM grafik where tanggal like'%$tgl%'");
							$rows8 = array();
							$rows8['name'] = 'Lainnya';
							while($tmp = mysqli_fetch_array($query)) {
								$rows8['data'][] = $tmp['Lainnya'];
							}



							$result = array();
							array_push($result,$rows1);
							array_push($result,$rows2);
							array_push($result,$rows3);
							array_push($result,$rows4);
							array_push($result,$rows5);
							array_push($result,$rows6);
							array_push($result,$rows7);
							array_push($result,$rows8);

							print json_encode($result, JSON_NUMERIC_CHECK);

							mysqli_close($con);
							?> 
					});
				});
			
			});
			
		});
		</script>
	<script src="assets/js/highcharts.js"></script>
	<script src="assets/js/exporting.js"></script>
        
</head>
<body>
<!--- Bagian Judul-->	
<div class="container" style="margin-top:20px">
	<div class="col-md-8">
		<div class="panel panel-primary">
			<div class="panel-heading">Maintance IT Graphs <?php echo $tgl;?></div>
				<div class="panel-body">
					<div id ="mygraph"></div>
				</div>
		</div>
	</div>
</div>
<script src="assets/js/highcharts.js"></script>
<script src="assets/js/jquery-1.10.1.min.js"></script>
</body>
</html>
