<?php
include "koneksi.php";

$idp=$_POST['idperusahaan'];
echo "$idp";
$query = "update tbperusahaan set nmperusahaan='".addslashes($_POST['perusahaan'])."',alamat='".addslashes($_POST['alamatp'])."',penanggungjwb='".addslashes($_POST['jawabp'])."',kantor='".$_POST['kantorp']."',kantorlain='".$_POST['kantorlainp']."',fax='".$_POST['faxp']."',faxlain='".$_POST['faxlainp']."',hp='".$_POST['hpp']."',hplain='".$_POST['hplainp']."' where id='$idp'";
$hasil = mysql_query($query);
 
 if ($hasil) {
	 echo "<script>window.alert('Data Sudah Terupdate!');
            window.location=(href='index.php?page=dataedit&no=$idp')</script>";
 }else{
	 
	 echo "<script>window.alert('Data Gagal di Update');
            window.location=(href='index.php?page=dataedit')</script>";
}
//&no=$idp
?>