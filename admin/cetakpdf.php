<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan</title>
</head>

<body onLoad="javascript:window.print()">

  <!-- Panels Start -->
<?php
include "../conn.php";
$nama1 = $_POST['tahun'];
$nama2 = $_POST['bulan'];
$nama3 = $_POST['depart'];
$query1="SELECT tgllapor, nama, jnskendala, kendala, petugas, kerusakan, tindakan, tglperbaikan, jamperbaikan, status
							FROM pengunjung
							WHERE tgllapor like '%$nama1-$nama2%' 
							AND depart='$nama3'";
                    
                    $tampil=mysql_query($query1) or die(mysql_error());
					
?>
	  <table width="979" border="0" align="center">
	  	<tr>
			<td align="center"><font size="+2">LAPORAN MAINTENANCE IT</font></td>
		</tr>
		<tr>
			<td align="center"><font size="+2">RSU ANWAR MEDIKA</font><hr /></td>
		</tr>
		<tr>
			<td align="right"><font size="4">Departemen &nbsp; : &nbsp;<?php echo $nama3; ?> </font><br /><br /></td>
		</tr>
	  </table>
      <table width="979" border="1" align="center">
          <tr bgcolor="#0099FF">
            <td width="60"><div align="center">Tgl Lapor</div></td>
            <td width="70"><div align="center">Nama</div></td>
            <td width="100"><div align="center">Deskripsi Kendala</div></td>
			<td width="50"><div align="center">Jenis Kendala</div></td>
			<td width="100"><div align="center">Petugas</div></td>
			<td width="100"><div align="center">Kerusakan</div></td>
			<td width="100"><div align="center">Tindakan</div></td>
			<td width="60"><div align="center">Tgl Perbaikan</div></td>
			<td width="60"><div align="center">Jam Perbaikan</div></td>
			<td width="50"><div align="center">Status</div></td>								
          </tr>
          <?php
 		$no=0;
			while ($data=mysql_fetch_array($tampil)){
			$no++;
 ?>
      <tr>
        <td><?php echo $data['tgllapor']; ?></td>
					<td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['jnskendala'];?></td>
                    <td><?php echo $data['kendala'];?></td>
                    <td><?php echo $data['petugas'];?></td>
					<td><?php echo $data['kerusakan'];?></td>
					<td><?php echo $data['tindakan'];?></td>
					<td><?php echo $data['tglperbaikan'];?></td>
                    <td><?php echo $data['jamperbaikan'];?></td>
					<td><?php echo $data['status'];?></td>
    
      </tr>
      
      
<?php
}
?>  
</table><br /><br />
<div>
	<div style="width:200px;float:right">
		Sidoarjo, <?php echo "".date("Y/m/d").""; ?>
		<br/>Departemen IT
	  <p><br /><br />______________________<br/>
	</div>
	<div style="clear:both"></div>
</div>
</body>
</html>