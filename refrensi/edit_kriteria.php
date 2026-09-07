<?php
include "koneksi.php";
$query=mysql_query("select * from tbskeluar order by id_penawaran");
function format1($tgl_surat){
$th=substr($tgl_surat,0,4);
$bl=substr($tgl_surat,5,2);
$tg=substr($tgl_surat,8,2);
if($bl=="01"){ $ket="JANUARI"; }
elseif($bl=="02"){ $ket="FEBRUARI"; }
elseif($bl=="03"){ $ket="MARET"; }
elseif($bl=="04"){ $ket="APRIL"; }
elseif($bl=="05"){ $ket="MEI"; }
elseif($bl=="06"){ $ket="JUNI"; }
elseif($bl=="07"){ $ket="JULI"; }
elseif($bl=="08"){ $ket="AGUSTUS"; }
elseif($bl=="09"){ $ket="SEPTEMBER"; }
elseif($bl=="10"){ $ket="OKTOBER"; }
elseif($bl=="11"){ $ket="NOVEMBER"; }
elseif($bl=="12"){ $ket="DESEMBER"; }
return $tg." ".$ket." ".$th;
}
$id = $_GET['no']; //get the no which will updated
$query = "select * from tbskeluar where id_penawaran = $id"; //get the data that will be updated
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
?>

  <!-- Panels Start -->
<?php
include "koneksi.php";
$id = $_GET['no'];
$query=mysql_query("select * from tbskeluar where id_penawaran = $id");
?>
  <div class="mws-panel grid_8">
    <div class="mws-panel-header"> <span><i class="icon-table"></i> Data Surat Keluar</span> </div>
    <div class="mws-panel-body no-padding">
      <table class="mws-datatable-fn mws-table">
        <thead>
         <tr>
            <th>No</th>
            <th>No. Surat Keluar</th>
            <th>Penerima</th>
            <th>Tanggal Surat</th>
			<th>No. RM</th>
            <th>Perihal</th>
            <th>Petugas</th>
			<th>Unit</th>
			<th>Aksi</th>
          </tr>
        </thead>
         <?php
 			$no=0;
			while ($b=mysql_fetch_array($query)){
			$no++;
 ?>
      <tr>
        <td align="center"><?php echo $no?></td>
        <td align="center"><?php echo $b['nosrt'] ?></td>
        <td><?php echo strtoupper ($b['penerima'])?></td>
        <td><?=format1($b['tgl_surat']);?></td>
		<td align="center"><?php echo strtoupper ($b['norm'])?></td>
        <td><?php echo strtoupper ($b['perihal'])?></td>
		<td><?php echo strtoupper ($b['petugas'])?></td>      
		<td><?php echo strtoupper ($b['unit'])?></td> 
        <td align="center"> <div class="btn-group">
        <a href="index.php?page=p_alternatif"><div rel="tooltip" data-placement="top" class="btn btn-small" value="Top" title="Back" id="back">   <i class="icon-bended-arrow-left"></i></div></a>
      	</div>
        </td>
      </tr>
      
      
<?php
}
?>  
      </table>
    </div>
  </div>
  
 
 
  <div class="mws-panel grid_8">
    <div class="mws-panel-header"> <span><i class="icon-google-plus"></i> Update Data Surat Keluar</span></div>
    <div class="mws-panel-body no-padding">
      <form id="mws-validate" class="mws-form" action="update_kriteria.php" method="post">
	  <input type="hidden" name="id_surat" value="<?php echo "$id" ?>" />
        <div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
        <div class="mws-form-inline">
          <div class="mws-form-row">
            <label class="mws-form-label">No. Surat <span class="required"> *</span></label>
            <div class="mws-form-item">
              <input name="txt_nosurat" type="text" class="required" value="<?php echo $data['nosrt']; ?>" readonly>
            </div>
          </div>
		  
		  <div class="mws-form-row">
            <label class="mws-form-label">Peneima <span class="required"> *</span></label>
            <div class="mws-form-item">
              <input name="txt_penerima" type="text" class="required small" value="<?php echo strtoupper ($data['penerima']) ?>"> <em> Harus diisi</em>
            </div>
          </div>
								
		  <div class="mws-form-row">
            <label class="mws-form-label">Tanggal Pembuatan Surat <span class="required"> *</span></label>
            <div class="mws-form-item">
              <input name="txt_tglsrt" type="text" class="mws-datepicker" value="<?php echo strtoupper ($data['tgl_surat']) ?>"> <em> Harus diisi</em>
            </div>
          </div>
		  
		  <div class="mws-form-row">
            <label class="mws-form-label">No. RM <span class="required"> *</span></label>
            <div class="mws-form-item">
              <input name="txt_norm" type="text" class="required" value="<?php echo strtoupper ($data['norm']) ?>"> <em> Harus diisi</em>
            </div>
          </div>
		  
		  <div class="mws-form-row">
            <label class="mws-form-label">Perihal <span class="required"> *</span></label>
            <div class="mws-form-item">
			<textarea name="txt_perihal" rows="" cols="" class="required small"><?php echo strtoupper ($data['perihal']) ?></textarea>
            </div>
          </div>
		  
		  <div class="mws-form-row">
            <label class="mws-form-label">Petugas <span class="required"> *</span></label>
            <div class="mws-form-item">
              <input name="txt_petugas" type="text" class="required" value="<?php echo strtoupper ($data['petugas']) ?>"> <em> Harus diisi</em>
            </div>
          </div>
          
          <div class="mws-form-row">
            <label class="mws-form-label">Unit <span class="required"> *</span></label>
            <div class="mws-form-item">
			  <select name="txt_unit" id="txt_unit">
				<option></option>
                 <?php
				 	//class="mws-select2 small"
					$isi = $data['unit'];
						
					  $in=mysql_query("select id_kriteria,nama from kriteria order by nama");
					  while($row1=mysql_fetch_array($in)){	
					    if ($isi == $row1['nama']) {
					  	
                			echo'<option value="'.$row1['nama'].'" selected>'.$row1['nama'].'</option>';
                		
						} else {
						
                			echo'<option value="'.$row1['nama'].'">'.$row1['nama'].'</option>';
                		
					  	}
					}
					  ?>
	            </select>	
            </div>
          </div>
         
            
        <div class="mws-button-row">
           <button type="submit" class="btn btn-samll" name="simpan" id="simpan"><i class="icon-database"></i> Update</button>
        </div>
      </form>
    </div>

  </div>
   
   


  
  <!-- Panels End -->
