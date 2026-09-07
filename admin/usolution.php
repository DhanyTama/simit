<?php

$id        	  	= $_POST['id'];
$fjnstrouble    = addslashes($_POST['fjnstrouble']);
$fpetugas	  	= addslashes($_POST['fpetugas']);
$desckerusakan  = addslashes($_POST['desckerusakan']);
$desctindakan   = addslashes($_POST['desctindakan']);
$fghardware	  	= addslashes($_POST['fghardware']);
$krs	  	    = addslashes($_POST['krs']);
$fremote     	= addslashes($_POST['fremote']);
$ffeedback    	= addslashes($_POST['ffeedback']);
$ftanggalselesai= $_POST['ftanggalselesai'];
$ftimeselesai 	= $_POST['ftimeselesai'];
$noteperbaikan  = addslashes($_POST['noteperbaikan']);
$fstatus	  	= "Complete";

$qry = mysqli_query($connect,"SELECT * FROM pengunjung WHERE id='$id'");
$hslqry  = mysqli_fetch_array($qry);
$xtgl = $hslqry['tgllapor'];

$query = mysqli_query($connect,"UPDATE pengunjung SET kendala='$fjnstrouble', petugas='$fpetugas', status='$fstatus', kerusakan='$desckerusakan', tindakan='$desctindakan',
	hardware='$fghardware',krs='$krs', remote='$fremote', feedback='$ffeedback', tglselesai='$ftanggalselesai', jamselesai='$ftimeselesai', noteperbaikan='$noteperbaikan' WHERE id='$id'");

$query1="select count(tanggal) as jml from tb_grafik_jnstrouble where tanggal ='$xtgl'";
$tampil=mysqli_query($connect,$query1);
$data=mysqli_fetch_array($tampil);
$cek=$data['jml'];

if($cek =='0'){
if($fjnstrouble=='SOFTWARE'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_jnstrouble (tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('$xtgl','1','0','0','0','0','0')");
}
else if($fjnstrouble=='HARDWARE'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_jnstrouble (tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('$xtgl','0','1','0','0','0','0')");
}
else if($fjnstrouble=='NETWORK'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_jnstrouble (tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('$xtgl','0','0','1','0','0','0')");
}
else if($fjnstrouble=='KOMUNIKASI'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_jnstrouble (tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('$xtgl','0','0','0','1','0','0')");
}
else if($fjnstrouble=='SECURITY_SYSTEM'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_jnstrouble (tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('$xtgl','0','0','0','0','1','0')");
}
else {
$query = mysqli_query($connect,"INSERT INTO tb_grafik_jnstrouble (tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('$xtgl','0','0','0','0','0','1')");
}
}

else{
if($fjnstrouble=='SOFTWARE'){
$query = mysqli_query($connect,"UPDATE tb_grafik_jnstrouble SET SOFTWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SOFTWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fjnstrouble=='HARDWARE'){
$query = mysqli_query($connect,"UPDATE tb_grafik_jnstrouble SET HARDWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='HARDWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fjnstrouble=='NETWORK'){
$query = mysqli_query($connect,"UPDATE tb_grafik_jnstrouble SET NETWORK=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='NETWORK' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fjnstrouble=='KOMUNIKASI'){
$query = mysqli_query($connect,"UPDATE tb_grafik_jnstrouble SET KOMUNIKASI=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='KOMUNIKASI' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fjnstrouble=='SECURITY_SYSTEM'){
$query = mysqli_query($connect,"UPDATE tb_grafik_jnstrouble SET SECURITY_SYSTEM=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SECURITY SYSTEM' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else {
$query = mysqli_query($connect,"UPDATE tb_grafik_jnstrouble SET OTHER=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='OTHER' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
}

if ($query) {
	 echo "<script>window.alert('Data Tersimpan!!!');
            window.location=(href='index.php?page=data')</script>";
 }else{

	 echo "<script>window.alert('Gagal Tersimpan!!!');
            window.location=(href='index.php?page=accept&kd=$id')</script>";
}
?>
