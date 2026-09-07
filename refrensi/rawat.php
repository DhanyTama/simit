<?php
	#### Penggunaan key
	$key = "rs anwar medika";
?>

<div class="row-fluid">
<div class="span12">
<?php
$page = $_GET['page'];
$tambah 		= isset($_GET['act']) ? $_GET['act'] : '';
$cpass	 		= isset($_GET['act']) ? $_GET['act'] : '';
$edit	 		= isset($_GET['act']) ? $_GET['act'] : '';
$biaya	 		= isset($_GET['act']) ? $_GET['act'] : '';
$edit_biaya	 	= isset($_GET['act']) ? $_GET['act'] : '';
$kesehatan 		= isset($_GET['act']) ? $_GET['act'] : '';
$edit_kesehatan	= isset($_GET['act']) ? $_GET['act'] : '';
$kuasa	 		= isset($_GET['act']) ? $_GET['act'] : '';
$edit_kuasa 	= isset($_GET['act']) ? $_GET['act'] : '';
$mode 			= isset($_GET['mode']) ? $_GET['mode'] : '';

	
if($edit=="edit"){
$id_en			=base64_decrypt($_GET['id'],$key);
$e 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_pasien WHERE id_pasien='$id_en'"));
$id_pasien 		= $e['id_pasien'];
?>
<div class="header">

<?php
		if (isset($_POST['simpan'])){
			
		  	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	  		$tipe_file      = $_FILES['fupload']['type'];
	  		$nama_file      = $_FILES['fupload']['name'];
	  		$acak           = rand(1,99);
	  		$foto = $acak.$nama_file;
			
			$biday = new DateTime($_POST['tgl_lahirpasien']);
			$today = new DateTime();
			$diff = $today->diff($biday);

			if (!empty($lokasi_file)){
				UploadUser($foto);
				$ft = getValue("foto_pasien","tb_pasien","id_pasien='$_POST[id_pasien]'");
				if (!$ft==""){
					unlink("foto_user/$ft");
				}

				$q = mysqli_query($connect,"UPDATE tb_pasien SET nik_pasien='$_POST[nik_pasien]',nama_pasien='$_POST[nama_pasien]',kelamin_pasien='$_POST[kelamin_pasien]',
								alamat_pasien='$_POST[alamat_pasien]',lahir_pasien='$_POST[lahir_pasien]',tgl_lahirpasien='$_POST[tgl_lahirpasien]',
								telpon_pasien='$_POST[telpon_pasien]',pekerjaan_pasien='$_POST[pekerjaan_pasien]',tgl_laka_pasien='$_POST[tgl_laka_pasien]',
								tkp_pasien='$_POST[tkp_pasien]',diagnosa_awal_pasien='$_POST[diagnosa_awal_pasien]',ruang_perawatan_pasien='$_POST[ruang_perawatan_pasien]',
												foto_pasien='$foto'
			                                 WHERE id_pasien='$id_pasien'
			                    ");

			}else{
				$q = mysqli_query($connect,"UPDATE tb_pasien SET nik_pasien='$_POST[nik_pasien]',nama_pasien='$_POST[nama_pasien]',kelamin_pasien='$_POST[kelamin_pasien]',
								alamat_pasien='$_POST[alamat_pasien]',lahir_pasien='$_POST[lahir_pasien]',tgl_lahirpasien='$_POST[tgl_lahirpasien]',
								telpon_pasien='$_POST[telpon_pasien]',pekerjaan_pasien='$_POST[pekerjaan_pasien]',tgl_laka_pasien='$_POST[tgl_laka_pasien]',
								tkp_pasien='$_POST[tkp_pasien]',diagnosa_awal_pasien='$_POST[diagnosa_awal_pasien]',ruang_perawatan_pasien='$_POST[ruang_perawatan_pasien]'
			                                 WHERE id_pasien='$id_pasien'
			                    ");
								
								$q1 = mysqli_query($connect,"UPDATE tb_kuasa SET nama='$_POST[nama_pasien]',jenis_kelamin='$_POST[kelamin_pasien]',umur='$diff->y',
								alamat='$_POST[alamat_pasien]',telpon='$_POST[telpon_pasien]',pekerjaan='$_POST[pekerjaan_pasien]'
			                                 WHERE id_pasien='$id_pasien'
			                    ");
								
								$q2 = mysqli_query($connect,"UPDATE tb_kesehatan SET nama_korban='$_POST[nama_pasien]',jenis_kelamin='$_POST[kelamin_pasien]',
								alamat_korban='$_POST[alamat_pasien]' WHERE id_pasien='$id_pasien'
			                    ");
			}
		  	
			if ($q){
			echo "<script>
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1500)
			      </script>";
				    ?>
					<div class="alert alert-success">
						<strong>Selamat!</strong> Data berhasil disimpan.
					</div>
					<?php
			}else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Terismpan,pastikan data yang diinput telah benar ..!!
					</div>
					<?php
			}
		}
	?>

<!-- FORM -->
		<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="form_validation">
		<h2>
									EDIT PENGAJUAN PASIEN
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);">Action</a></li>
											<li><a href="javascript:void(0);">Another action</a></li>
											<li><a href="javascript:void(0);">Something else here</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<br>
							
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo $id_pasien;?>" readonly required>
                                            <label class="form-label">ID Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nik_pasien" name="nik_pasien" value="<?php echo $e['nik_pasien'];?>" required>
                                            <label class="form-label">NIK Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo $e['nama_pasien'];?>" required>
                                            <label class="form-label">Nama Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="demo-radio-button">
										<input class="form-control" name="kelamin_pasien" type="radio" id="radio_30" value="PRIA" class="with-gap radio-col-red"
										<?php if ($e['kelamin_pasien']=='PRIA'){echo"checked";}else{echo"";}?>/>
										<label for="radio_30">PRIA</label>
										<input class="form-control" name="kelamin_pasien" type="radio" id="radio_31" value="WANITA"  class="with-gap radio-col-pink"
										<?php if ($e['kelamin_pasien']=='WANITA'){echo"checked";}else{echo"";}?>/>
										<label for="radio_31">WANITA</label>
										</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="alamat_pasien" name="alamat_pasien" value="<?php echo $e['alamat_pasien'];?>" required>
                                            <label class="form-label">Alamat Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="lahir_pasien" name="lahir_pasien" value="<?php echo $e['lahir_pasien'];?>" required>
                                            <label class="form-label">Tempat Lahir</label>
                                        </div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_lahirpasien" value="<?php echo $e['tgl_lahirpasien'];?>" name="tgl_lahirpasien"   required>
                                            <label class="form-label">Tanggal Lahir</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="telpon_pasien" name="telpon_pasien" value="<?php echo $e['telpon_pasien'];?>" required>
                                            <label class="form-label">Telepon Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="pekerjaan_pasien" name="pekerjaan_pasien" value="<?php echo $e['pekerjaan_pasien'];?>" required>
                                            <label class="form-label">Pekerjaan Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_laka_pasien" name="tgl_laka_pasien" value="<?php echo $e['tgl_laka_pasien'];?>"   required>
                                            <label class="form-label">Tanggal Laka</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tkp_pasien" name="tkp_pasien" value="<?php echo $e['tkp_pasien'];?>" required>
                                            <label class="form-label">TKP</label>
                                        </div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="diagnosa_awal_pasien" name="diagnosa_awal_pasien" value="<?php echo $e['diagnosa_awal_pasien'];?>" required>
                                            <label class="form-label">Diagnosa Awal</label>
                                        </div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="ruang_perawatan_pasien" name="ruang_perawatan_pasien" value="<?php echo $e['ruang_perawatan_pasien'];?>" required>
                                            <label class="form-label">Ruang Perawatan</label>
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">image</i>
                                            </span>
                                            <div class="form-line">
												
												<?php
													$ptol = "Anda belum menginput gambar, ukuran file gambar tidak boleh lebih 1MB";
													if (!empty($e['foto_pasien'])){
														$gbrx ="<div class='span2'>
																<img class='pull-left' src='foto_user/$e[foto_pasien]' width='20%' margin='5px' data-rel='tooltip' data-placement='right' data-original-title='Foto Sekarang'>
																</div>";
														$ptol = "Abaikan jika gambar tidak diganti, ukuran file gambar tidak boleh lebih 1MB";
														echo"$e[foto_pasien]";
														echo $gbrx;
													}else{
													echo"upload gambar pasien";
													}						
												?>
												
                                            </div>
                                        </div>
                                    </div>
								<div class="col-sm-12">
									<b>Foto Pasien</b>
												<div class="form-group form-float">
													<div id="foto">
														<div class="span2" data-rel="tooltip" data-placement="right" data-original-title="Ukuran File Gambar Tidak Boleh Lebih 1MB">
															<input type="file" name="fupload"> 
														</div>
													</div>
												</div>
									</div>
											
				<div class="form-actions">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="btn btn-info" type="submit" name="simpan">
						<i class="icon-save bigger-110"></i>Simpan
					</button>
					<a class="btn" href="media.php?page=<?php echo $page;?>">
						<i class="icon-undo bigger-110"></i>Batal
					</a>
				</div>
				<br>
			</form>
	<!-- FORM -->

	

<?php
}elseif($biaya=="biaya"){
$id_en			=base64_decrypt($_GET['id'],$key);
$e 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_pasien WHERE id_pasien='$id_en'"));
$id_pasien 		= $e['id_pasien'];
?>
<div class="header">

<?php


		if (isset($_POST['simpan'])){
		
		$cek_entri		= mysqli_fetch_array(mysqli_query($connect,"SELECT count(*) as jumlah FROM tb_biaya WHERE id_pasien='$id_en'"));
		$cek_entri_fix	= $cek_entri['jumlah'];
		
		
		if($cek_entri_fix<>1){
			
				$q = mysqli_query($connect,"insert into tb_biaya values('','$_POST[id_pasien]','$_POST[biaya_ambulan]','$_POST[biaya_p3k]','$_POST[biaya_perawatan]','$_POST[ts_insert]')
			                    ");


		  	
			if ($q){
			echo "<script>
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1500)
			      </script>";
				    ?>
					<div class="alert alert-success">
						<strong>Selamat!</strong> Data berhasil disimpan.
					</div>
					<?php
			}else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,pastikan data yang diinput telah benar ..!!
					</div>
					<?php
			}
			}
			else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,Data Biaya Sudah Diisi ..!!
					</div>
					<?php
			
			}
			
		}
	?>

<!-- FORM -->
		<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="form_validation">
		<h2>
									PENGAJUAN BIAYA
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);">Action</a></li>
											<li><a href="javascript:void(0);">Another action</a></li>
											<li><a href="javascript:void(0);">Something else here</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<br>
							
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="hidden" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo $id_pasien;?>" readonly required>
											<input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo $e['nama_pasien'];?>" readonly required>
											<input type="hidden" class="form-control" id="ts_insert" name="ts_insert" value="<?php echo $e['ts_insert'];?>" readonly required>
                                            <label class="form-label">Nama Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_ambulan" name="biaya_ambulan" required>
                                            <label class="form-label">Biaya Ambulan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_p3k" name="biaya_p3k" required>
                                            <label class="form-label">Biaya P3K</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_perawatan" name="biaya_perawatan" required>
                                            <label class="form-label">Biaya Perawatan</label>
                                        </div>
                                    </div>
                                </div>
								
								
											
				<div class="form-actions">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="btn btn-info" type="submit" name="simpan">
						<i class="icon-save bigger-110"></i>Simpan
					</button>
					<a class="btn" href="media.php?page=<?php echo $page;?>">
						<i class="icon-undo bigger-110"></i>Batal
					</a>
				</div>
				<br>
			</form>
	<!-- FORM -->
	
	

	

<?php
}elseif($biaya=="edit_biaya"){
$id_en			=base64_decrypt($_GET['id'],$key);
$e 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_biaya WHERE id_pasien='$id_en'"));
$f 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_pasien WHERE id_pasien='$id_en'"));
$id_pasien 		= $e['id_pasien'];
?>
<div class="header">

<?php


		if (isset($_POST['simpan'])){
		
	
			
				$q = mysqli_query($connect,"update tb_biaya set biaya_ambulan='$_POST[biaya_ambulan]',biaya_p3k='$_POST[biaya_p3k]',
											biaya_perawatan='$_POST[biaya_perawatan]' where id_pasien='$_POST[id_pasien]' and ts_insert='$_POST[ts_insert]'
			                    ");
								
								$q1 = mysqli_query($connect,"update tb_kuasa set biaya_ambulan='$_POST[biaya_ambulan]',biaya_p3k='$_POST[biaya_p3k]',
											biaya_perawatan='$_POST[biaya_perawatan]' where id_pasien='$_POST[id_pasien]'
			                    ");


		  	
			if ($q){
			echo "<script>
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1500)
			      </script>";
				    ?>
					<div class="alert alert-success">
						<strong>Selamat!</strong> Data berhasil disimpan.
					</div>
					<?php
			}else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,pastikan data yang diinput telah benar ..!!
					</div>
					<?php
			}
			
			
		}
	?>

<!-- FORM -->
		<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="form_validation">
		<h2>
									EDIT PENGAJUAN BIAYA
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);">Action</a></li>
											<li><a href="javascript:void(0);">Another action</a></li>
											<li><a href="javascript:void(0);">Something else here</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<br>
							
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="hidden" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo $id_pasien;?>" readonly required>
											<input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo $f['nama_pasien'];?>" readonly required>
											<input type="hidden" class="form-control" id="ts_insert" name="ts_insert" value="<?php echo $e['ts_insert'];?>" readonly required>
                                            <label class="form-label">Nama Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_ambulan" name="biaya_ambulan" value="<?php echo $e['biaya_ambulan'];?>" required>
                                            <label class="form-label">Biaya Ambulan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_pasien" name="biaya_p3k" value="<?php echo $e['biaya_p3k'];?>" required>
                                            <label class="form-label">Biaya P3K</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_perawatan" name="biaya_perawatan" value="<?php echo $e['biaya_perawatan'];?>" required>
                                            <label class="form-label">Biaya Perawatan</label>
                                        </div>
                                    </div>
                                </div>
								
								
											
				<div class="form-actions">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="btn btn-info" type="submit" name="simpan">
						<i class="icon-save bigger-110"></i>Simpan
					</button>
					<a class="btn" href="media.php?page=<?php echo $page;?>">
						<i class="icon-undo bigger-110"></i>Batal
					</a>
				</div>
				<br>
			</form>
	<!-- FORM -->
		
	
	



<?php
}elseif($kesehatan=="kesehatan"){
$id_en			=base64_decrypt($_GET['id'],$key);
$e 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_pasien WHERE id_pasien='$id_en'"));
$id_pasien 		= $e['id_pasien'];
?>
<div class="header">

<?php


		if (isset($_POST['simpan'])){
		
		$cek_entri		= mysqli_fetch_array(mysqli_query($connect,"SELECT count(*) as jumlah FROM tb_kesehatan WHERE id_pasien='$id_en'"));
		$cek_entri_fix	= $cek_entri['jumlah'];
		
		
		if($cek_entri_fix<>1){
			
				$q = mysqli_query($connect,"insert into tb_kesehatan values('','$_POST[id_pasien]','$_POST[nama_petugas]','$_POST[rumah_sakit]','$_POST[milik_rs]',
				'$_POST[alamat_rs]','$_POST[tgl_pemeriksaan]','$_POST[nama_korban]',
				'$_POST[jenis_kelamin]','$_POST[alamat_korban]','$_POST[keadaan_korban]','$_POST[cedera]',
				'$_POST[diagnosa]','$_POST[tolong_pertama]','$_POST[tolong_tanggal1]','$_POST[tolong_tanggal2]',
				'$_POST[tindakan_operasi]','$_POST[operasi_tanggal1]','$_POST[operasi_tanggal2]','$_POST[perawatan]',
				'$_POST[perawatan_tanggal1]','$_POST[perawatan_tanggal2]','$_POST[obat_jalan]','$_POST[jalan_tanggal1]',
				'$_POST[jalan_tanggal2]','$_POST[dirujuk]','$_POST[rujuk_tanggal]','$_POST[penjelasan_operasi]',
				'$_POST[tempat_surat]','$_POST[yang_menyatakan]')
			                    ");


		  	
			if ($q){
			echo "<script>
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1500)
			      </script>";
				    ?>
					<div class="alert alert-success">
						<strong>Selamat!</strong> Data berhasil disimpan.
					</div>
					<?php
			}else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,pastikan data yang diinput telah benar ..!!
					</div>
					<?php
			}
			}
			else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,Data Kesehatan Sudah Diisi ..!!
					</div>
					<?php
			
			}
			
		}
	?>

<!-- FORM -->
		<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="form_validation">
		<h2>
									SURAT KETERANGAN SEHAT
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);">Action</a></li>
											<li><a href="javascript:void(0);">Another action</a></li>
											<li><a href="javascript:void(0);">Something else here</a></li>
										</ul>
									</li>
								</ul>
							</div>
							
								<div class="col-sm-12"><br />
									<h5>
										DATA RUMAH SAKIT
									</h5>
								<hr>
								</div>
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="hidden" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo $id_pasien;?>" readonly required>
											<input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo $e['nama_pasien'];?>" readonly required>
                                            <label class="form-label">Nama Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_petugas" name="nama_petugas" required>
                                            <label class="form-label">Nama Petugas</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="rumah_sakit" name="rumah_sakit" value="RSU ANWAR MEDIKA" required>
                                            <label class="form-label">Rumah Sakit</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                <div class="demo-radio-button">
                                <input class="form-control" name="milik_rs" type="radio" id="radio_30" value="PEMERINTAH" class="with-gap radio-col-red" />
                                <label for="radio_30">PEMERINTAH</label>
                                <input class="form-control" name="milik_rs" type="radio" id="radio_31" value="SWASTA" checked class="with-gap radio-col-pink" />
                                <label for="radio_31">SWASTA</label>
								</div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="alamat_rs" name="alamat_rs" value="Jl.RAYA BY PASS KM 33 BALONGBENDO KRIAN SIDOARJO" required>
                                            <label class="form-label">Alamat</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_pemeriksaan" name="tgl_pemeriksaan" required>
                                            <label class="form-label">Tanggal Pemeriksaan</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								<div class="col-sm-12"><br />
									<h5>
										IDENTITAS KORBAN
									</h5>
								<hr>
								</div>
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_korban" name="nama_korban" value="<?php echo $e['nama_pasien'] ?>" readonly required>
                                            <label class="form-label">Nama Korban</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $e['kelamin_pasien'] ?>" readonly required>
                                            <label class="form-label">Jenis Kelamin</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="alamat_korban" name="alamat_korban" value="<?php echo $e['alamat_pasien'] ?>"readonly required>
                                            <label class="form-label">Alamat</label>
                                        </div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-12">
								<small>Keadaan Korban</small>
                                <div class="demo-radio-button">
                                <input class="form-control" name="keadaan_korban" type="radio" id="radio_34" value="MENINGGAL DUNIA" class="with-gap radio-col-red" />
                                <label for="radio_34">MENINGGAL DUNIA</label>
                                <input class="form-control" name="keadaan_korban" type="radio" id="radio_35" value="LUKA BERAT"  class="with-gap radio-col-pink" />
                                <label for="radio_35">LUKA BERAT</label>
								<input class="form-control" name="keadaan_korban" type="radio" id="radio_36" value="LUKA RINGAN"  class="with-gap radio-col-pink" />
                                <label for="radio_36">LUKA RINGAN</label>
								<input class="form-control" name="keadaan_korban" type="radio" id="radio_37" value="CACAT TETAP"  class="with-gap radio-col-pink" />
                                <label for="radio_37">CACAT TETAP</label>
								</div>
                                </div>
								
								<div class="col-sm-12"><br /><br />
									<h5>
										PENJELASAN KEADAAN KORBAN
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="cedera" name="cedera"required>
                                            <label class="form-label">Cedera yang dialami korban</label>
                                        </div>
                                    </div>
                                </div>
									
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="diagnosa" name="diagnosa"required>
                                            <label class="form-label">Diagnosa</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12"><br /><br />
									<h5>
										TINDAKAN PERTOLONGAN YANG TELAH AKAN DILAKUKAN TERHADAP KORBAN
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tolong_pertama" name="tolong_pertama"required>
                                            <label class="form-label">Pertolongan Pertama</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tolong_tanggal1" name="tolong_tanggal1"   required>
                                            <label class="form-label">Tanggal</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tolong_tanggal2" name="tolong_tanggal2"   required>
                                            <label class="form-label">S/D</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tindakan_operasi" name="tindakan_operasi"required>
                                            <label class="form-label">Tindakan Operasi</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="operasi_tanggal1" name="operasi_tanggal1"   required>
                                            <label class="form-label">Tanggal</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="operasi_tanggal2" name="operasi_tanggal2"   required>
                                            <label class="form-label">S/D</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="perawatan" name="perawatan"required>
                                            <label class="form-label">Perawatan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="perawatan_tanggal1" name="perawatan_tanggal1"   required>
                                            <label class="form-label">Tanggal</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="perawatan_tanggal2" name="perawatan_tanggal2"   required>
                                            <label class="form-label">S/D</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="obat_jalan" name="obat_jalan"required>
                                            <label class="form-label">Berobat Jalan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jalan_tanggal1" name="jalan_tanggal1"   required>
                                            <label class="form-label">Tanggal</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jalan_tanggal2" name="jalan_tanggal2"   required>
                                            <label class="form-label">S/D</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="dirujuk" name="dirujuk"required>
                                            <label class="form-label">Dirujuk</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="rujuk_tanggal" name="rujuk_tanggal"   required>
                                            <label class="form-label">Tanggal Rujuk</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="penjelasan_operasi" name="penjelasan_operasi"required>
                                            <label class="form-label">Penjelasan Tindakan Operasi</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tempat_surat" name="tempat_surat"required>
                                            <label class="form-label">Tempat Surat Dibuat</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="yang_menyatakan" name="yang_menyatakan"required>
                                            <label class="form-label">Yang Menyatakan</label>
                                        </div>
                                    </div>
                                </div>
								
								
											
				<div class="form-actions">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="btn btn-info" type="submit" name="simpan">
						<i class="icon-save bigger-110"></i>Simpan
					</button>
					<a class="btn" href="media.php?page=<?php echo $page;?>">
						<i class="icon-undo bigger-110"></i>Batal
					</a>
				</div>
				<br>
			</form>
	<!-- FORM -->
	



<?php
}elseif($edit_kesehatan=="edit_kesehatan"){
$id_en			=base64_decrypt($_GET['id'],$key);
$e 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_pasien WHERE id_pasien='$id_en'"));
$f 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_kesehatan WHERE id_pasien='$id_en'"));
$id_pasien 		= $e['id_pasien'];
?>
<div class="header">

<?php


		if (isset($_POST['simpan'])){
		

				$q = mysqli_query($connect,"update tb_kesehatan set nama_petugas='$_POST[nama_petugas]',rumah_sakit='$_POST[rumah_sakit]',
				milik_rs='$_POST[milik_rs]',alamat_rs='$_POST[alamat_rs]',tgl_pemeriksaan='$_POST[tgl_pemeriksaan]',nama_korban='$_POST[nama_korban]',
				jenis_kelamin='$_POST[jenis_kelamin]',alamat_korban='$_POST[alamat_korban]',keadaan_korban='$_POST[keadaan_korban]',
				cedera='$_POST[cedera]',diagnosa='$_POST[diagnosa]',tolong_pertama='$_POST[tolong_pertama]',tolong_tanggal1='$_POST[tolong_tanggal1]',
				tolong_tanggal2='$_POST[tolong_tanggal2]',tindakan_operasi='$_POST[tindakan_operasi]',operasi_tanggal1='$_POST[operasi_tanggal1]',
				operasi_tanggal2='$_POST[operasi_tanggal2]',perawatan='$_POST[perawatan]',perawatan_tanggal1='$_POST[perawatan_tanggal1]',
				perawatan_tanggal2='$_POST[perawatan_tanggal2]',obat_jalan='$_POST[obat_jalan]',jalan_tanggal1='$_POST[jalan_tanggal1]',
				jalan_tanggal2='$_POST[jalan_tanggal2]',dirujuk='$_POST[dirujuk]',rujuk_tanggal='$_POST[rujuk_tanggal]',penjelasan_operasi='$_POST[penjelasan_operasi]',
				tempat_surat='$_POST[tempat_surat]',yang_menyatakan='$_POST[yang_menyatakan]' where id_pasien='$_POST[id_pasien]'
			                    ");
		  	
			if ($q){
			echo "<script>
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1500)
			      </script>";
				    ?>
					<div class="alert alert-success">
						<strong>Selamat!</strong> Data berhasil disimpan.
					</div>
					<?php
			}else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,pastikan data yang diinput telah benar ..!!
					</div>
					<?php
			}
			
			
		}
	?>

<!-- FORM -->
		<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="form_validation">
		<h2>
									SURAT KETERANGAN SEHAT
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);">Action</a></li>
											<li><a href="javascript:void(0);">Another action</a></li>
											<li><a href="javascript:void(0);">Something else here</a></li>
										</ul>
									</li>
								</ul>
							</div>
							
								<div class="col-sm-12"><br />
									<h5>
										DATA RUMAH SAKIT
									</h5>
								<hr>
								</div>
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="hidden" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo $id_pasien;?>" readonly required>
											<input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo $e['nama_pasien'];?>" readonly required>
                                            <label class="form-label">Nama Pasien</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_petugas" name="nama_petugas" value="<?php echo $f['nama_petugas'];?>"  required>
                                            <label class="form-label">Nama Petugas</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="rumah_sakit" name="rumah_sakit" value="<?php echo $f['rumah_sakit'];?>" required>
                                            <label class="form-label">Rumah Sakit</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                <div class="demo-radio-button">
                                <input class="form-control" name="milik_rs" type="radio" id="radio_30" value="PEMERINTAH" class="with-gap radio-col-red"
								<?php if ($f['milik_rs']=='PEMERINTAH'){echo"checked";}else{echo"";}?>/>
                                <label for="radio_30">PEMERINTAH</label>
                                <input class="form-control" name="milik_rs" type="radio" id="radio_31" value="SWASTA" class="with-gap radio-col-pink"
								<?php if ($f['milik_rs']=='SWASTA'){echo"checked";}else{echo"";}?>/>
                                <label for="radio_31">SWASTA</label>
								</div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="alamat_rs" name="alamat_rs" value="<?php echo $f['alamat_rs'];?>" required>
                                            <label class="form-label">Alamat</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_pemeriksaan" name="tgl_pemeriksaan" value="<?php echo $f['tgl_pemeriksaan'];?>" required>
                                            <label class="form-label">Tanggal Pemeriksaan</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								<div class="col-sm-12"><br />
									<h5>
										IDENTITAS KORBAN
									</h5>
								<hr>
								</div>
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_korban" name="nama_korban" value="<?php echo $f['nama_korban'] ?>" readonly required>
                                            <label class="form-label">Nama Korban</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $f['jenis_kelamin'] ?>"readonly required>
                                            <label class="form-label">Jenis Kelamin</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="alamat_korban" name="alamat_korban" value="<?php echo $f['alamat_korban'] ?>"readonly required>
                                            <label class="form-label">Alamat</label>
                                        </div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-12">
								<small>Keadaan Korban</small>
                                <div class="demo-radio-button">
                                <input class="form-control" name="keadaan_korban" type="radio" id="radio_34" value="MENINGGAL DUNIA" class="with-gap radio-col-red"
								<?php if ($f['keadaan_korban']=='MENINGGAL DUNIA'){echo"checked";}else{echo"";}?>/>
                                <label for="radio_34">MENINGGAL DUNIA</label>
                                <input class="form-control" name="keadaan_korban" type="radio" id="radio_35" value="LUKA BERAT"  class="with-gap radio-col-pink"
								<?php if ($f['keadaan_korban']=='LUKA BERAT'){echo"checked";}else{echo"";}?>/>
                                <label for="radio_35">LUKA BERAT</label>
								<input class="form-control" name="keadaan_korban" type="radio" id="radio_36" value="LUKA RINGAN"  class="with-gap radio-col-pink"
								<?php if ($f['keadaan_korban']=='LUKA RINGAN'){echo"checked";}else{echo"";}?>/>
                                <label for="radio_36">LUKA RINGAN</label>
								<input class="form-control" name="keadaan_korban" type="radio" id="radio_37" value="CACAT TETAP"  class="with-gap radio-col-pink"
								<?php if ($f['keadaan_korban']=='CACAT TETAP'){echo"checked";}else{echo"";}?>/>
                                <label for="radio_37">CACAT TETAP</label>
								</div>
                                </div>
								
								<div class="col-sm-12"><br /><br />
									<h5>
										PENJELASAN KEADAAN KORBAN
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="cedera" name="cedera" value="<?php echo $f['cedera'] ?>"required>
                                            <label class="form-label">Cedera yang dialami korban</label>
                                        </div>
                                    </div>
                                </div>
									
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="diagnosa" value="<?php echo $f['diagnosa'] ?>" name="diagnosa"required>
                                            <label class="form-label">Diagnosa</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12"><br /><br />
									<h5>
										TINDAKAN PERTOLONGAN YANG TELAH AKAN DILAKUKAN TERHADAP KORBAN
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tolong_pertama" name="tolong_pertama" value="<?php echo $f['tolong_pertama'] ?>"required>
                                            <label class="form-label">Pertolongan Pertama</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tolong_tanggal1" name="tolong_tanggal1" value="<?php echo $f['tolong_tanggal1'] ?>" required>
                                            <label class="form-label">Tanggal</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tolong_tanggal2" name="tolong_tanggal2" value="<?php echo $f['tolong_tanggal2'] ?>" required>
                                            <label class="form-label">S/D</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tindakan_operasi" name="tindakan_operasi" value="<?php echo $f['tindakan_operasi'] ?>"required>
                                            <label class="form-label">Tindakan Operasi</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="operasi_tanggal1" name="operasi_tanggal1"  value="<?php echo $f['operasi_tanggal1'] ?>" required>
                                            <label class="form-label">Tanggal</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="operasi_tanggal2" name="operasi_tanggal2" value="<?php echo $f['operasi_tanggal2'] ?>" required>
                                            <label class="form-label">S/D</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="perawatan" name="perawatan" value="<?php echo $f['perawatan'] ?>" required>
                                            <label class="form-label">Perawatan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="perawatan_tanggal1" name="perawatan_tanggal1" value="<?php echo $f['perawatan_tanggal1'] ?>" required>
                                            <label class="form-label">Tanggal</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="perawatan_tanggal2" name="perawatan_tanggal2" value="<?php echo $f['perawatan_tanggal2'] ?>" required>
                                            <label class="form-label">S/D</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="obat_jalan" name="obat_jalan" value="<?php echo $f['obat_jalan'] ?>" required>
                                            <label class="form-label">Berobat Jalan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jalan_tanggal1" name="jalan_tanggal1"  value="<?php echo $f['jalan_tanggal1'] ?>" required>
                                            <label class="form-label">Tanggal</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jalan_tanggal2" name="jalan_tanggal2" value="<?php echo $f['jalan_tanggal2'] ?>" required>
                                            <label class="form-label">S/D</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="dirujuk" name="dirujuk" value="<?php echo $f['dirujuk'] ?>" required>
                                            <label class="form-label">Dirujuk</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="rujuk_tanggal" name="rujuk_tanggal" value="<?php echo $f['rujuk_tanggal'] ?>" required>
                                            <label class="form-label">Tanggal Rujuk</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="penjelasan_operasi" name="penjelasan_operasi" value="<?php echo $f['penjelasan_operasi'] ?>" required>
                                            <label class="form-label">Penjelasan Tindakan Operasi</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tempat_surat" name="tempat_surat" value="<?php echo $f['tempat_surat'] ?>" required>
                                            <label class="form-label">Tempat Surat Dibuat</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="yang_menyatakan" name="yang_menyatakan" value="<?php echo $f['yang_menyatakan'] ?>" required>
                                            <label class="form-label">Yang Menyatakan</label>
                                        </div>
                                    </div>
                                </div>
								
								
											
				<div class="form-actions">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="btn btn-info" type="submit" name="simpan">
						<i class="icon-save bigger-110"></i>Simpan
					</button>
					<a class="btn" href="media.php?page=<?php echo $page;?>">
						<i class="icon-undo bigger-110"></i>Batal
					</a>
				</div>
				<br>
			</form>
	<!-- FORM -->
	
	
	
	
	

<?php
}elseif($kuasa=="kuasa"){
$id_en			=base64_decrypt($_GET['id'],$key);
$e 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_pasien WHERE id_pasien='$id_en'"));
$id_pasien 		= $e['id_pasien'];

$f 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_biaya WHERE id_pasien='$id_en'"));
// Convert Ke Date Time
			$biday 		= new DateTime($e['tgl_lahirpasien']);
			$today 		= new DateTime();
			$diff 		= $today->diff($biday);
			$umur		=$diff->y;

?>
<div class="header">

<?php


		if (isset($_POST['simpan'])){
		
		$cek_entri		= mysqli_fetch_array(mysqli_query($connect,"SELECT count(*) as jumlah FROM tb_kuasa WHERE id_pasien='$id_en'"));
		$cek_entri_fix	= $cek_entri['jumlah'];
		
		
		if($cek_entri_fix<>1){
			
				$q = mysqli_query($connect,"insert into tb_kuasa values('','$_POST[id_pasien]','$_POST[nama]','$_POST[umur]','$_POST[jenis_kelamin]',
				'$_POST[pekerjaan]','$_POST[alamat]','$_POST[telpon]',
				'$_POST[nama_wali]','$_POST[umur_wali]','$_POST[jenis_kelamin_wali]','$_POST[pekerjaan_wali]',
				'$_POST[alamat_wali]','$_POST[telpon_wali]','$_POST[tgl_laka]','$_POST[tkp]',
				'$_POST[tgl_mrs]','$_POST[tgl_krs]','$_POST[biaya_ambulan]','$_POST[biaya_p3k]',
				'$_POST[biaya_perawatan]','$_POST[nama_pihak]','$_POST[jabatan_pihak]','$_POST[rumah_sakit]')
			                    ");


		  	
			if ($q){
			echo "<script>
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1500)
			      </script>";
				    ?>
					<div class="alert alert-success">
						<strong>Selamat!</strong> Data berhasil disimpan.
					</div>
					<?php
			}else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,pastikan data yang diinput telah benar ..!!
					</div>
					<?php
			}
			}
			else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,Data Kuasa Sudah Diisi ..!!
					</div>
					<?php
			
			}
			
		}
	?>


<!-- FORM -->
		<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="form_validation">
		<h2>
									SURAT KUASA
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);">Action</a></li>
											<li><a href="javascript:void(0);">Another action</a></li>
											<li><a href="javascript:void(0);">Something else here</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<br>
							
								<div class="col-sm-12" align="center">
									<h5>
										IDENTITAS KORBAN
									</h5>
								<hr>
								</div>
							
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="hidden" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo $id_pasien;?>" readonly required>
											<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $e['nama_pasien'];?>" readonly required>
                                            <label class="form-label">Nama</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="umur" name="umur" value="<?php echo $umur;?>" readonly required>
                                            <label class="form-label">Umur</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $e['kelamin_pasien'];?>" readonly required>
                                            <label class="form-label">Jenis Kelamin</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?php echo $e['pekerjaan_pasien'];?>" readonly required>
                                            <label class="form-label">Pekerjaan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $e['alamat_pasien'];?>" readonly required>
                                            <label class="form-label">Alamat</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="telpon" name="telpon" value="<?php echo $e['telpon_pasien'];?>" readonly required>
                                            <label class="form-label">Telpon</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12" align="center">
									<h5>
										IDENTITAS WALI / ORANG TUA KORBAN
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_wali" name="nama_wali" required>
                                            <label class="form-label">Nama Wali</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="umur_wali" name="umur_wali" required>
                                            <label class="form-label">Umur Wali</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jenis_kelamin_wali" name="jenis_kelamin_wali" required>
                                            <label class="form-label">Jenis Kelamin Wali</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="pekerjaan_wali" name="pekerjaan_wali" required>
                                            <label class="form-label">Pekerjaan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="alamat_wali" name="alamat_wali" required>
                                            <label class="form-label">Alamat</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="telpon_wali" name="telpon_wali" required>
                                            <label class="form-label">Telpon</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12" align="center">
									<h5>
										DATA LAKA LANTAS
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_laka" name="tgl_laka" value="<?php echo $e['tgl_laka_pasien'];?>" readonly  required>
                                            <label class="form-label">Tanggal Laka</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tkp" name="tkp" value="<?php echo $e['tkp_pasien'];?>" readonly required>
                                            <label class="form-label">TKP</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12" align="center">
									<h5>
										DATA PERAWATAN
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_mrs" name="tgl_mrs"    required>
                                            <label class="form-label">Tanggal MRS</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_krs" name="tgl_krs"    required>
                                            <label class="form-label">Tanggal KRS</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_ambulan" name="biaya_ambulan" value="<?php echo $f['biaya_ambulan'];?>" readonly required>
                                            <label class="form-label">Biaya Ambulan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_p3k" name="biaya_p3k" value="<?php echo $f['biaya_p3k'];?>" readonly required>
                                            <label class="form-label">Biaya P3K</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_perawatan" name="biaya_perawatan" value="<?php echo $f['biaya_perawatan'];?>" readonly required>
                                            <label class="form-label">Biaya Perawatan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12" align="center">
									<h5>
										DATA PIHAK KEDUA/ PENERIMA KUASA
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_pihak" name="nama_pihak" required>
                                            <label class="form-label">Nama</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jabatan_pihak" name="jabatan_pihak" required>
                                            <label class="form-label">Jabatan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="rumah_sakit" name="rumah_sakit" value="RSU Anwar Medika" required>
                                            <label class="form-label">Rumah Sakit</label>
                                        </div>
                                    </div>
                                </div>
					
				<div class="form-actions">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="btn btn-info" type="submit" name="simpan">
						<i class="icon-save bigger-110"></i>Simpan
					</button>
					<a class="btn" href="media.php?page=<?php echo $page;?>">
						<i class="icon-undo bigger-110"></i>Batal
					</a>
				</div>
				<br>
			</form>
	<!-- FORM -->
	
	
	
<?php
}elseif($edit_kuasa=="edit_kuasa"){
$id_en			=base64_decrypt($_GET['id'],$key);
$e 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_pasien WHERE id_pasien='$id_en'"));
$id_pasien 		= $e['id_pasien'];

$f 				= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_kuasa WHERE id_pasien='$id_en'"));
// Convert Ke Date Time
			$biday 		= new DateTime($e['tgl_lahirpasien']);
			$today 		= new DateTime();
			$diff 		= $today->diff($biday);
			$umur		=$diff->y;

?>
<div class="header">

<?php


		if (isset($_POST['simpan'])){
		
			
				$q = mysqli_query($connect,"update tb_kuasa set nama='$_POST[nama]',umur='$_POST[umur]',jenis_kelamin='$_POST[jenis_kelamin]',
				pekerjaan='$_POST[pekerjaan]',alamat='$_POST[alamat]',telpon='$_POST[telpon]',
				nama_wali='$_POST[nama_wali]',umur_wali='$_POST[umur_wali]',jenis_kelamin_wali='$_POST[jenis_kelamin_wali]',pekerjaan_wali='$_POST[pekerjaan_wali]',
				alamat_wali='$_POST[alamat_wali]',telpon_wali='$_POST[telpon_wali]',tgl_laka='$_POST[tgl_laka]',tkp='$_POST[tkp]',
				tgl_mrs='$_POST[tgl_mrs]',tgl_krs='$_POST[tgl_krs]',biaya_ambulan='$_POST[biaya_ambulan]',biaya_p3k='$_POST[biaya_p3k]',
				biaya_perawatan='$_POST[biaya_perawatan]',nama_pihak='$_POST[nama_pihak]',jabatan_pihak='$_POST[jabatan_pihak]',rumah_sakit='$_POST[rumah_sakit]'
				where id_pasien='$_POST[id_pasien]'
			                    ");


		  	
			if ($q){
			echo "<script>
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1500)
			      </script>";
				    ?>
					<div class="alert alert-success">
						<strong>Selamat!</strong> Data berhasil disimpan.
					</div>
					<?php
			}else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,pastikan data yang diinput telah benar ..!!
					</div>
					<?php
			}

		}
	?>


<!-- FORM -->
		<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="form_validation">
		<h2>
									SURAT KUASA
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);">Action</a></li>
											<li><a href="javascript:void(0);">Another action</a></li>
											<li><a href="javascript:void(0);">Something else here</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<br>
							
								<div class="col-sm-12" align="center">
									<h5>
										IDENTITAS KORBAN
									</h5>
								<hr>
								</div>
	
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="hidden" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo $id_pasien;?>" readonly required>
											<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $f['nama'];?>" readonly required>
                                            <label class="form-label">Nama</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="umur" name="umur" value="<?php echo $f['umur'];?>" readonly required>
                                            <label class="form-label">Umur</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $f['jenis_kelamin'];?>" readonly required>
                                            <label class="form-label">Jenis Kelamin</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?php echo $f['pekerjaan'];?>" readonly required>
                                            <label class="form-label">Pekerjaan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $f['alamat'];?>" readonly required>
                                            <label class="form-label">Alamat</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="telpon" name="telpon" value="<?php echo $f['telpon'];?>"  readonly required>
                                            <label class="form-label">Telpon</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12" align="center">
									<h5>
										IDENTITAS WALI / ORANG TUA KORBAN
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_wali" name="nama_wali" value="<?php echo $f['nama_wali'];?>" required>
                                            <label class="form-label">Nama Wali</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="umur_wali" name="umur_wali"  value="<?php echo $f['umur_wali'];?>" required>
                                            <label class="form-label">Umur Wali</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jenis_kelamin_wali" name="jenis_kelamin_wali" value="<?php echo $f['jenis_kelamin_wali'];?>" required>
                                            <label class="form-label">Jenis Kelamin Wali</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="pekerjaan_wali" name="pekerjaan_wali" value="<?php echo $f['pekerjaan_wali'];?>"  required>
                                            <label class="form-label">Pekerjaan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="alamat_wali" name="alamat_wali" value="<?php echo $f['alamat_wali'];?>" required>
                                            <label class="form-label">Alamat</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="telpon_wali" name="telpon_wali" value="<?php echo $f['telpon_wali'];?>" required>
                                            <label class="form-label">Telpon</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12" align="center">
									<h5>
										DATA LAKA LANTAS
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_laka" name="tgl_laka" value="<?php echo $f['tgl_laka'];?>" readonly  required>
                                            <label class="form-label">Tanggal Laka</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tkp" name="tkp" value="<?php echo $f['tkp'];?>"  readonly required>
                                            <label class="form-label">TKP</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12" align="center">
									<h5>
										DATA PERAWATAN
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_mrs" name="tgl_mrs"  value="<?php echo $f['tgl_mrs'];?>"   required>
                                            <label class="form-label">Tanggal MRS</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="tgl_krs" name="tgl_krs" value="<?php echo $f['tgl_krs'];?>"   required>
                                            <label class="form-label">Tanggal KRS</label>
                                        </div>
										<div class="help-info">[YYYY-MM-DD][Ex: 2016-07-03]</div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_ambulan" name="biaya_ambulan" value="<?php echo $f['biaya_ambulan'];?>" readonly required>
                                            <label class="form-label">Biaya Ambulan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_p3k" name="biaya_p3k" value="<?php echo $f['biaya_p3k'];?>" readonly required>
                                            <label class="form-label">Biaya P3K</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="biaya_perawatan" name="biaya_perawatan" value="<?php echo $f['biaya_perawatan'];?>" readonly required>
                                            <label class="form-label">Biaya Perawatan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12" align="center">
									<h5>
										DATA PIHAK KEDUA/ PENERIMA KUASA
									</h5>
								<hr>
								</div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="nama_pihak" name="nama_pihak" value="<?php echo $f['nama_pihak'];?>" required>
                                            <label class="form-label">Nama</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="jabatan_pihak" name="jabatan_pihak" value="<?php echo $f['jabatan_pihak'];?>" required>
                                            <label class="form-label">Jabatan</label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
											<input type="text" class="form-control" id="rumah_sakit" name="rumah_sakit" value="<?php echo $f['rumah_sakit'];?>"  required>
                                            <label class="form-label">Rumah Sakit</label>
                                        </div>
                                    </div>
                                </div>
					
				<div class="form-actions">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="btn btn-info" type="submit" name="simpan">
						<i class="icon-save bigger-110"></i>Simpan
					</button>
					<a class="btn" href="media.php?page=<?php echo $page;?>">
						<i class="icon-undo bigger-110"></i>Batal
					</a>
				</div>
				<br>
			</form>
	<!-- FORM -->
	
	
	


	
	
<?php
}else{
?>
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;	
	<?php
		if ($mode=="pulang"){
			$id_en = base64_decrypt($_GET['id'],$key);
			$q=mysqli_query($connect,"update tb_pasien set status_pulang='1' WHERE id_pasien='$id_en'");
			
			if ($q){
			echo "<script>
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1500)
			      </script>";
				    ?>
					<div class="alert alert-success">
						<strong>Selamat!</strong> Data berhasil disimpan.
					</div>
					<?php
			}else{
			echo "<script>
			  		setTimeout(function() { history.go(-1); }, 1500);
			      </script>";
				   ?>
					<div class="alert alert-danger">
						<strong>Gagal!!</strong> Data Gagal Tersimpan,pastikan data yang diinput telah benar ..!!
					</div>
					<?php
			}
			
		}
		
	?>
	

		<div class="header">
                            <h2>
                               PASIEN PERAWATAN
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
		</div>
		<div class="body">
		<div id="tabel_user">
		<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead>
	    <tr>
	    <th class="center">No</th>
	    <th class='center'>NIK</th>
	    <th class="center">Nama</th>
	    <th class="center">Alamat</th>
		<th class="center">Diagnosa Awal</th>
		<th class="center">Jr</th>
		<th class="center">Biaya</th>
		<th class="center">Kesehatan</th>
		<th class="center">Kuasa</th>
	    <th class="center" width="40px">Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	    $qry = mysqli_query($connect,"SELECT * FROM tb_pasien ORDER BY id_pasien desc");
		$no=0;
		while ($d = mysqli_fetch_array($qry)){
	      $no++;
		  $id_pasien	=base64_encrypt($d['id_pasien'],$key);
		  $cek_jr		=$d['status_jr'];	
	
			// Convert Ke Date Time
			$biday = new DateTime($d['tgl_lahirpasien']);
			$today = new DateTime();
			$diff = $today->diff($biday);
			
			$biaya			= mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM tb_biaya WHERE id_pasien='$d[id_pasien]'"));
			$biaya_ambulan	= number_format($biaya['biaya_ambulan'],0);
			$biaya_p3k		= number_format($biaya['biaya_p3k'],0);
			$biaya_perawatan= number_format($biaya['biaya_perawatan'],0);
			
			
			$cek_biaya		= mysqli_fetch_array(mysqli_query($connect,"SELECT count(*) as jumlah FROM tb_biaya WHERE id_pasien='$d[id_pasien]'"));
			$cek_biaya_fix	= $cek_biaya['jumlah'];
			
			
			$cek_kesehatan		= mysqli_fetch_array(mysqli_query($connect,"SELECT count(*) as jumlah FROM tb_kesehatan WHERE id_pasien='$d[id_pasien]'"));
			$cek_kesehatan_fix	= $cek_kesehatan['jumlah'];
			
			$cek_kuasa			= mysqli_fetch_array(mysqli_query($connect,"SELECT count(*) as jumlah FROM tb_kuasa WHERE id_pasien='$d[id_pasien]'"));
			$cek_kuasa_fix		= $cek_kuasa['jumlah'];
			
		
	      echo "
	      <tr>
	      <td align='center'>$no</td>
	      <td class='center'>$d[nik_pasien]</td>
	      <td>
							<a class='waves-effect m-b-15' role='button' data-toggle='collapse' href='#$d[nik_pasien]' aria-expanded='false'
                               aria-controls='collapseExample'>$d[nama_pasien]</a>
							<br>[$diff->y THN] [$d[kelamin_pasien]]
							<br>[$d[pekerjaan_pasien]]
						
                            <div class='collapse' id='$d[nik_pasien]'>
                              <i><br>AMB : <br>$biaya_ambulan <br>P3K : <br>$biaya_p3k <br>PRWT : <br>$biaya_perawatan
                              </i>
                            </div>        
		 
		
							
		  </td>
	      <td class='center'>$d[alamat_pasien]</td>
		  <td align='center'>$d[diagnosa_awal_pasien]<br>[$d[ruang_perawatan_pasien]]</td>
		  <td align='center'>";?>
		  <?php
		  if($cek_jr==1){
			echo"<i class='material-icons'>check_box</i>";
			}else{
			echo"<i class='material-icons'>check_box_outline_blank</i>";
			}
		  ?>
		  <?php echo"
		  </td>
		   <td align='center'>";?>
		  <?php
		  if($cek_biaya_fix==1){
			echo"<a href='?page=$page&act=edit_biaya&id=$id_pasien'><i class='material-icons'>check_box</i></a>";
			}else{
			echo"<i class='material-icons'>check_box_outline_blank</i>";
			}
		  ?>
		  <?php echo"
		  </td>
		   <td align='center'>";?>
		  <?php
		  if($cek_kesehatan_fix==1){
			echo"<a href='?page=$page&act=edit_kesehatan&id=$id_pasien'><i class='material-icons'>check_box</i></a>";
			}else{
			echo"<i class='material-icons'>check_box_outline_blank</i>";
			}
		  ?>
		  <?php echo"
		  </td>
		   <td align='center'>";?>
		  <?php
		  if($cek_kuasa_fix==1){
			echo"<a href='?page=$page&act=edit_kuasa&id=$id_pasien'><i class='material-icons'>check_box</i></a>";
			}else{
			echo"<i class='material-icons'>check_box_outline_blank</i>";
			}
		  ?>
		  <?php echo"
		  </td>
	      <td align='center'>
           <div class='btn-group' role='group'>
                                   
                                    <div class='btn-group' role='group'>
										<button type='button' class='btn btn-success waves-effect dropdown-toggle' data-toggle='dropdown'>
											<i class='material-icons'>settings</i>
										</button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a href='?page=$page&act=biaya&id=$id_pasien'><i class='material-icons'>payment</i>Biaya</a></li>										
                                            <li><a href='?page=$page&act=kesehatan&id=$id_pasien'><i class='material-icons'>content_paste</i>S.Kesehatan</a></li>                                       										 
                                            <li><a href='?page=$page&act=kuasa&id=$id_pasien'><i class='material-icons'>description</i>S.Kuasa</a></li>                                        										 
                                            <li><a href='?page=$page&act=edit&id=$id_pasien'><i class='material-icons'>edit</i>Edit Pasien</a></li>                                        										 
											";?>
											<?php echo "<li><a data-toggle='modal' data-target='#konfirmasi_pulang' data-href='?page=$page&mode=pulang&id=$id_pasien'><i class='material-icons'>transfer_within_a_station</i>Pulang</a></li>"; ?>
											<?php echo "
											</li>
                                        </ul>
                                    </div>
                                </div>
	      </td>";
	      ?>
	     </tr>
		
	    <?php
	       }
	    ?>
								
	</tbody>
	</table>
	
	
	</div>
	
	
	
			  <div class="modal fade" id="konfirmasi_pulang" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Delete Konfirmasi</h4>
                        </div>
                        <div class="modal-body ">
                           Apakah Anda yakin untuk memulangkan Pasien berikut??
                        </div>
                        <div class="modal-footer ">
                            <a class="btn btn-danger btn-ok"> Pulang</a>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
			
	
		
			
			
	
<?php
}
?>
</div>

</div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    //Hapus Data
    $(document).ready(function() {
        $('#konfirmasi_pulang').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });

  </script>
