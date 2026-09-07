<?php
include "conn.php";
//$id         = $_POST['id'];
$jenis      = $_POST['jenis'];
$nama       = $_POST['nama'];
$departemen	= $_POST['depart'];
$kendala 	= $_POST['kendala'];
$jnskendala = $_POST['jnskendala'];
$tgllapor 	= $_POST['tgllapor'];
$jamlapor	= $_POST['jamlapor'];
$intxt		= "Open";

//if( empty($nama) || empty($jk) || empty($kelas) || empty($perlu) || empty($cari) || empty($saran) ){
    //echo "<b>Data Harus Di isi.!!!</b>";
//}else{


$query3 = mysql_query("INSERT INTO pengunjung (id, jenis, nama, depart, kendala, jnskendala, tgllapor, jamlapor, petugas, status) VALUES ('','$jenis', '$nama', '$departemen', '$kendala', '$jnskendala', '$tgllapor', '$jamlapor', '$intxt', '$intxt')");


$query1="select count(tanggal) as jml from grafik where tanggal ='$tgllapor'";
$tampil=mysql_query($query1) or die(mysql_error());
$data=mysql_fetch_array($tampil);
$cek=$data['jml'];
//echo $cek;
if($cek =='0'){
if($kendala=='Komputer'){
$query = mysql_query("INSERT INTO grafik (id,tanggal,Komputer,
Internet,Wifi,Sim,Printer,Telepon,Iphone,Lainnya) VALUES ('','$tgllapor','1','0','0','0','0','0','0','0')");
}
else if($kendala=='Internet'){
$query = mysql_query("INSERT INTO grafik (id,tanggal,Komputer,
Internet,Wifi,Sim,Printer,Telepon,Iphone,Lainnya) VALUES ('','$tgllapor','0','1','0','0','0','0','0','0')");
}
else if($kendala=='Wifi'){
$query = mysql_query("INSERT INTO grafik (id,tanggal,Komputer,
Internet,Wifi,Sim,Printer,Telepon,Iphone,Lainnya) VALUES ('','$tgllapor','0','0','1','0','0','0','0','0')");
}
else if($kendala=='Sim'){
$query = mysql_query("INSERT INTO grafik (id,tanggal,Komputer,
Internet,Wifi,Sim,Printer,Telepon,Iphone,Lainnya) VALUES ('','$tgllapor','0','0','0','1','0','0','0','0')");
}
else if($kendala=='Printer'){
$query = mysql_query("INSERT INTO grafik (id,tanggal,Komputer,
Internet,Wifi,Sim,Printer,Telepon,Iphone,Lainnya) VALUES ('','$tgllapor','0','0','0','0','1','0','0','0')");
}
else if($kendala=='Telepon'){
$query = mysql_query("INSERT INTO grafik (id,tanggal,Komputer,
Internet,Wifi,Sim,Printer,Telepon,Iphone,Lainnya) VALUES ('','$tgllapor','0','0','0','0','0','1','0','0')");
}
else if($kendala=='Iphone'){
$query = mysql_query("INSERT INTO grafik (id,tanggal,Komputer,
Internet,Wifi,Sim,Printer,Telepon,Iphone,Lainnya) VALUES ('','$tgllapor','0','0','0','0','0','0','1','0')");
}
else {
$query = mysql_query("INSERT INTO grafik (id,tanggal,Komputer,
Internet,Wifi,Sim,Printer,Telepon,Iphone,Lainnya) VALUES ('','$tgllapor','0','0','0','0','0','0','0','1')");
}
}

else{
if($kendala=='Komputer'){
$query = mysql_query("UPDATE grafik SET komputer=(SELECT COUNT(kendala) FROM pengunjung
WHERE kendala='Komputer' AND tgllapor ='$tgllapor') WHERE tanggal='$tgllapor'");
}
else if ($kendala=='Internet'){
$query = mysql_query("UPDATE grafik SET Internet=(SELECT COUNT(kendala) FROM pengunjung
WHERE kendala='Internet' AND tgllapor ='$tgllapor') WHERE tanggal='$tgllapor'");
}
else if ($kendala=='Wifi'){
$query = mysql_query("UPDATE grafik SET Wifi=(SELECT COUNT(kendala) FROM pengunjung
WHERE kendala='Wifi' AND tgllapor ='$tgllapor') WHERE tanggal='$tgllapor'");
}
else if ($kendala=='Sim'){
$query = mysql_query("UPDATE grafik SET Sim=(SELECT COUNT(kendala) FROM pengunjung
WHERE kendala='Sim' AND tgllapor ='$tgllapor') WHERE tanggal='$tgllapor'");
}
else if ($kendala=='Printer'){
$query = mysql_query("UPDATE grafik SET Printer=(SELECT COUNT(kendala) FROM pengunjung
WHERE kendala='Printer' AND tgllapor ='$tgllapor') WHERE tanggal='$tgllapor'");
}
else if ($kendala=='Telepon'){
$query = mysql_query("UPDATE grafik SET Telepon=(SELECT COUNT(kendala) FROM pengunjung
WHERE kendala='Telepon' AND tgllapor ='$tgllapor') WHERE tanggal='$tgllapor'");
}
else if ($kendala=='Iphone'){
$query = mysql_query("UPDATE grafik SET Iphone=(SELECT COUNT(kendala) FROM pengunjung
WHERE kendala='Iphone' AND tgllapor ='$tgllapor') WHERE tanggal='$tgllapor'");
}
else {
$query = mysql_query("UPDATE grafik SET Lainnya=(SELECT COUNT(kendala) FROM pengunjung
WHERE kendala='Lainnya' AND tgllapor ='$tgllapor') WHERE tanggal='$tgllapor'");
}
}
                  
           



if ($query3){
	echo "<script>alert('Data Trouble/Maintenance IT TERSIMPAN!'); window.location = 'index.php'</script>";	
} else {
	echo "<script>alert('Data Trouble/Maintenance IT GAGAL TERSIMPAN!'); window.location = 'index.php'</script>";	
}
//}
?>