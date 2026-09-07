<?php
$con=mysqli_connect("localhost","root","","eit");

if (!$con) {
  die('Could not connect: ' . mysql_error());
}

$tgl=date('Y-m');
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
