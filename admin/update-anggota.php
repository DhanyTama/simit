<?php
$namafolder="gambar_anggota/"; //tempat menyimpan file

include "../conn.php";
$id         = $_POST['id'];
$petugas    = $_POST['petugas'];
$status		= $_POST['status'];
$remote     = $_POST['remote'];
$feedback   = $_POST['feedback'];
$jamselesai = $_POST['jamselesai'];
$tglselesai = $_POST['tglselesai'];
//$jampenyelesaian	= $_POST['jamselesai'];
//$tglpenyelesaian	= $_POST['tglselesai'];


$query = mysql_query("UPDATE pengunjung SET petugas='$petugas', status='$status', remote='$remote', feedback='$feedback', 
	tglselesai='$tglselesai', jamselesai='$jamselesai' WHERE id='$id'");
if ($query){
	echo "<script>alert('Update Sukses.'); window.location = 'anggota.php'</script>";	
} else {
	echo "<script>alert('Update Sukses.'); window.location = 'anggota.php'</script>";	
}
//$query4 = mysql_query("'UPDATE pengun'jung (remote, feedback) VALUES ('$remote', '$feedback')");
?>