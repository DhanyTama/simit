<?php

$id        	  	= $_POST['id'];
$fjnstrouble    = addslashes($_POST['fjnstrouble']);
$fpetugas	  	= addslashes($_POST['fpetugas']);
$desckerusakan  = addslashes($_POST['desckerusakan']);
$desctindakan   = addslashes($_POST['desctindakan']);
$fghardware	  	= addslashes($_POST['fghardware']);
$fremote     	= addslashes($_POST['fremote']);
$ffeedback    	= addslashes($_POST['ffeedback']);
$fkategori    	= addslashes($_POST['fkategori']);
$fprioritas	  	= addslashes($_POST['fprioritas']);
$ftanggalselesai= $_POST['ftanggalselesai'];
$ftimeselesai 	= $_POST['ftimeselesai'];
$fstatus	  	= "Complete";

$qry = mysqli_query($connet,"SELECT * FROM pengunjung WHERE id='$id'");
$hslqry  = mysqli_fetch_array($qry) or die(mysql_error());
$xtgl = $hslqry['tgllapor'];

$query = mysqli_query($connet,"UPDATE pengunjung SET nama_prioritas='$fprioritas', jenis='$fkategori', kendala='$fjnstrouble', petugas='$fpetugas', kerusakan='$desckerusakan', tindakan='$desctindakan', hardware='$fghardware', remote='$fremote', feedback='$ffeedback', tglselesai='$ftanggalselesai', jamselesai='$ftimeselesai' WHERE id='$id'");

$query1="select count(tanggal) as jml from tb_grafik_jnstrouble where tanggal ='$xtgl'";
$tampil=mysqli_query($connet,$query1);
$data=mysqli_fetch_array($tampil);
$cek=$data['jml'];

$query3="select count(tanggal) as jml from tb_grafik_prioritas where tanggal ='$xtgl'";
$tampil=mysqli_query($connect,$query3) or die(mysql_error());
$data=mysqli_fetch_array($tampil);
$cek=$data['jml'];

$query2="select count(tanggal) as jml from tb_grafik_jenis where tanggal ='$xtgl'";
$tampil2=mysqli_query($query2) or die(mysql_error());
$data2=mysqli_fetch_array($tampil2);
$cek2=$data2['jml'];

if($cek =='0'){
if($fjnstrouble=='SOFTWARE'){
$query = mysqli_query("INSERT INTO tb_grafik_jnstrouble (id,tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('','$xtgl','1','0','0','0','0','0')");
}
else if($fjnstrouble=='HARDWARE'){
$query = mysqli_query("INSERT INTO tb_grafik_jnstrouble (id,tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('','$xtgl','0','1','0','0','0','0')");
}
else if($fjnstrouble=='NETWORK'){
$query = mysqli_query("INSERT INTO tb_grafik_jnstrouble (id,tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('','$xtgl','0','0','1','0','0','0')");
}
else if($fjnstrouble=='KOMUNIKASI'){
$query = mysqli_query("INSERT INTO tb_grafik_jnstrouble (id,tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('','$xtgl','0','0','0','1','0','0')");
}
else if($fjnstrouble=='SECURITY_SYSTEM'){
$query = mysqli_query("INSERT INTO tb_grafik_jnstrouble (id,tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('','$xtgl','0','0','0','0','1','0')");
}
else {
$query = mysqli_query("INSERT INTO tb_grafik_jnstrouble (id,tanggal,SOFTWARE,HARDWARE,NETWORK,KOMUNIKASI,SECURITY_SYSTEM,OTHER) VALUES ('','$xtgl','0','0','0','0','0','1')");
}
}

else{
if($fjnstrouble=='SOFTWARE'){
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SOFTWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SOFTWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET HARDWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='HARDWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET NETWORK=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='NETWORK' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET KOMUNIKASI=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='KOMUNIKASI' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SECURITY_SYSTEM=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SECURITY SYSTEM' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET OTHER=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='OTHER' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fjnstrouble=='HARDWARE'){
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SOFTWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SOFTWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET HARDWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='HARDWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET NETWORK=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='NETWORK' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET KOMUNIKASI=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='KOMUNIKASI' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SECURITY_SYSTEM=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SECURITY SYSTEM' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET OTHER=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='OTHER' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fjnstrouble=='NETWORK'){
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SOFTWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SOFTWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET HARDWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='HARDWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET NETWORK=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='NETWORK' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET KOMUNIKASI=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='KOMUNIKASI' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SECURITY_SYSTEM=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SECURITY SYSTEM' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET OTHER=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='OTHER' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fjnstrouble=='KOMUNIKASI'){
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SOFTWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SOFTWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET HARDWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='HARDWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET NETWORK=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='NETWORK' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET KOMUNIKASI=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='KOMUNIKASI' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SECURITY_SYSTEM=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SECURITY SYSTEM' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET OTHER=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='OTHER' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fjnstrouble=='SECURITY_SYSTEM'){
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SOFTWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SOFTWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET HARDWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='HARDWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET NETWORK=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='NETWORK' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET KOMUNIKASI=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='KOMUNIKASI' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SECURITY_SYSTEM=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SECURITY SYSTEM' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET OTHER=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='OTHER' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else {
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SOFTWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SOFTWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET HARDWARE=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='HARDWARE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET NETWORK=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='NETWORK' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET KOMUNIKASI=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='KOMUNIKASI' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET SECURITY_SYSTEM=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='SECURITY SYSTEM' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jnstrouble SET OTHER=(SELECT COUNT(kendala) FROM pengunjung WHERE kendala='OTHER' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
}

if($cek =='0'){
if($fprioritas=='EMERGANCY'){
$query = mysqli_query("INSERT INTO tb_grafik_prioritas (id,tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('','$xtgl','1','0','0','0','0')");
}
else if($fprioritas=='URGENT'){
$query = mysqli_query("INSERT INTO tb_grafik_prioritas (id,tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('','$xtgl','0','1','0','0','0')");
}
else if($fprioritas=='HIGH'){
$query = mysqli_query("INSERT INTO tb_grafik_prioritas (id,tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('','$xtgl','0','0','1','0','0')");
}
else if($fprioritas=='MEDIUM'){
$query = mysqli_query("INSERT INTO tb_grafik_prioritas (id,tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('','$xtgl','0','0','0','1','0')");
}
else {
$query = mysqli_query("INSERT INTO tb_grafik_prioritas (id,tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('','$xtgl','0','0','0','0','1')");
}
}

else{
if($fprioritas=='EMERGANCY'){
$query = mysqli_query("UPDATE tb_grafik_prioritas SET EMERGANCY=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='EMERGANCY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET URGENT=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='URGENT' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET HIGH=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='HIGH PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET MEDIUM=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='MEDIUM PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET LOW=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='LOW PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fprioritas=='URGENT'){
$query = mysqli_query("UPDATE tb_grafik_prioritas SET EMERGANCY=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='EMERGANCY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET URGENT=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='URGENT' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET HIGH=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='HIGH PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET MEDIUM=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='MEDIUM PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET LOW=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='LOW PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fprioritas=='HIGH'){
$query = mysqli_query("UPDATE tb_grafik_prioritas SET EMERGANCY=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='EMERGANCY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET URGENT=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='URGENT' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET HIGH=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='HIGH PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET MEDIUM=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='MEDIUM PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET LOW=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='LOW PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fprioritas=='MEDIUM'){
$query = mysqli_query("UPDATE tb_grafik_prioritas SET EMERGANCY=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='EMERGANCY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET URGENT=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='URGENT' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET HIGH=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='HIGH PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET MEDIUM=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='MEDIUM PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET LOW=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='LOW PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else {
$query = mysqli_query("UPDATE tb_grafik_prioritas SET EMERGANCY=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='EMERGANCY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET URGENT=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='URGENT' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET HIGH=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='HIGH PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET MEDIUM=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='MEDIUM PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_prioritas SET LOW=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='LOW PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
}

if($cek2 =='0'){
if($fkategori=='TROUBLE'){
$query = mysqli_query("INSERT INTO tb_grafik_jenis (id,tanggal,TROUBLE,REQUEST) VALUES ('','$xtgl','1','0')");
}
else{
$query = mysqli_query("INSERT INTO tb_grafik_jenis (id,tanggal,TROUBLE,REQUEST) VALUES ('','$xtgl','0','1')");
}
}

else{
if ($fkategori=='TROUBLE'){
$query = mysqli_query("UPDATE tb_grafik_jenis SET TROUBLE=(SELECT COUNT(jenis) FROM pengunjung WHERE jenis='TROUBLE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jenis SET REQUEST=(SELECT COUNT(jenis) FROM pengunjung WHERE jenis='REQUEST' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else{
$query = mysqli_query("UPDATE tb_grafik_jenis SET TROUBLE=(SELECT COUNT(jenis) FROM pengunjung WHERE jenis='TROUBLE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
$query = mysqli_query("UPDATE tb_grafik_jenis SET REQUEST=(SELECT COUNT(jenis) FROM pengunjung WHERE jenis='REQUEST' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
}

if ($query) {
	 echo "<script>window.alert('Data Tersimpan!!!');
            window.location=(href='index.php?page=dataedit&kd=$id')</script>";
 }else{
	 
	 echo "<script>window.alert('Gagal Tersimpan!!!');
            window.location=(href='index.php?page=dataedit&kd=$id')</script>"; 
}
?>