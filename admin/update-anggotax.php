<?php
$namafolder="gambar_anggota/"; //tempat menyimpan file

include "../conn.php";
$id         = $_POST['id'];
$petugas    = $_POST['petugas'];
$status		= $_POST['status'];
$kerusakan	= $_POST['kerusakan'];
$tindakan	= $_POST['tindakan'];
$tglperbaikan	= $_POST['tglperbaikan'];
$jamperbaikan	= $_POST['jamperbaikan'];

$query = mysql_query("UPDATE pengunjung SET petugas='$petugas', status='$status', kerusakan='$kerusakan', tindakan='$tindakan', tglperbaikan='$tglperbaikan', jamperbaikan='$jamperbaikan' WHERE id='$id'");
if ($query){
	echo "<script>alert('Update Sukses.'); window.location = 'anggota.php'</script>";	
} else {
	echo "<script>alert('Update Sukses.'); window.location = 'anggota.php'</script>";	
}
?>