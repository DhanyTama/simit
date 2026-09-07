<?php
include "conn.php";
date_default_timezone_set('Asia/Jakarta');
$pelapor	= $_POST['pelapor'];
$departemen	= $_POST['depart'];
$desc 		= $_POST['description'];
$nohp 		= $_POST['nohp'];

$query3 = mysqli_query($connect,"INSERT INTO tb_laporan (id, nama, unit, keterangan,nohp) 
				VALUES ('', '$pelapor', '$departemen', '$desc','$nohp')");
if ($query3){
	echo "<script>alert('DATA MASUKAN DAN SARAN SIMRS NEW TERSIMPAN!'); window.location = 'index.php'</script>";	
} else {
	echo "<script>alert('DATA MASUKAN DAN SARAN SIMRS NEW GAGAL TERSIMPAN!'); window.location = 'index.php'</script>";	
}
?>