<?php

$id        	  = $_POST['id'];
$fkategori    = addslashes($_POST['fkategori']);
$fprioritas	  = addslashes($_POST['fprioritas']);
$fpetugas     = addslashes($_POST['fpetugas']);
$noteperbaikan     = addslashes($_POST['noteperbaikan']);
$ftanggalacpt = $_POST['ftanggalacpt'];
$ftimeacpt 	  = $_POST['ftimeacpt'];
$fstatus	  = "In Progress";

$qry = mysqli_query($connect,"SELECT * FROM pengunjung WHERE id='$id'");
$hslqry  = mysqli_fetch_array($qry);
$xtgl = $hslqry['tgllapor'];

$query = mysqli_query($connect,"UPDATE pengunjung SET noteperbaikan='$noteperbaikan', nama_prioritas='$fprioritas', petugas='$fpetugas', jenis='$fkategori', status='$fstatus', tglperbaikan='$ftanggalacpt', jamperbaikan='$ftimeacpt' WHERE id='$id'");

$query1="select count(tanggal) as jml from tb_grafik_prioritas where tanggal ='$xtgl'";
$tampil=mysqli_query($connect,$query1);
$data=mysqli_fetch_array($tampil);
$cek=$data['jml'];

$query2="select count(tanggal) as jml from tb_grafik_jenis where tanggal ='$xtgl'";
$tampil2=mysqli_query($connect,$query2);
$data2=mysqli_fetch_array($tampil2);
$cek2=$data2['jml'];

if($cek =='0'){
if($fprioritas=='EMERGANCY'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_prioritas (tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('$xtgl','1','0','0','0','0')");
}
else if($fprioritas=='URGENT'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_prioritas (tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('$xtgl','0','1','0','0','0')");
}
else if($fprioritas=='HIGH'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_prioritas (tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('$xtgl','0','0','1','0','0')");
}
else if($fprioritas=='MEDIUM'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_prioritas (tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('$xtgl','0','0','0','1','0')");
}
else {
$query = mysqli_query($connect,"INSERT INTO tb_grafik_prioritas (tanggal,EMERGANCY,URGENT,HIGH,MEDIUM,LOW) VALUES ('$xtgl','0','0','0','0','1')");
}
}

else{
if($fprioritas=='EMERGANCY'){
$query = mysqli_query($connect,"UPDATE tb_grafik_prioritas SET EMERGANCY=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='EMERGANCY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fprioritas=='URGENT'){
$query = mysqli_query($connect,"UPDATE tb_grafik_prioritas SET URGENT=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='URGENT' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fprioritas=='HIGH'){
$query = mysqli_query($connect,"UPDATE tb_grafik_prioritas SET HIGH=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='HIGH PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else if ($fprioritas=='MEDIUM'){
$query = mysqli_query($connect,"UPDATE tb_grafik_prioritas SET MEDIUM=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='MEDIUM PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else {
$query = mysqli_query($connect,"UPDATE tb_grafik_prioritas SET LOW=(SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='LOW PRIORITY' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
}

if($cek2 =='0'){
if($fkategori=='TROUBLE'){
$query = mysqli_query($connect,"INSERT INTO tb_grafik_jenis (tanggal,TROUBLE,REQUEST) VALUES ('$xtgl','1','0')");
}
else{
$query = mysqli_query($connect,"INSERT INTO tb_grafik_jenis (tanggal,TROUBLE,REQUEST) VALUES ('$xtgl','0','1')");
}
}

else{
if ($fkategori=='TROUBLE'){
$query = mysqli_query($connect,"UPDATE tb_grafik_jenis SET TROUBLE=(SELECT COUNT(jenis) FROM pengunjung WHERE jenis='TROUBLE' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
}
else{
$query = mysqli_query($connect,"UPDATE tb_grafik_jenis SET REQUEST=(SELECT COUNT(jenis) FROM pengunjung WHERE jenis='REQUEST' AND tgllapor ='$xtgl') WHERE tanggal='$xtgl'");
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