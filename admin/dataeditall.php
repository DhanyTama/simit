<?php
    $query = mysqli_query($connect,"SELECT * FROM pengunjung WHERE id='$_GET[kd]'");
    $data  = mysqli_fetch_array($query) or die(mysqli_error());
?>
<!-- Select -->
            <div class="row clearfix">
                <!--  <div class="row clearfix"> -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA MAINTENANCE/TROUBLE/REQUEST IT
                            </h2>
                            
                        </div>
                            <div class="body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Start date</th>
                                            <th>Nama</th>
                                            <th>Deskripsi</th>
                                            <th>End Date</th>
                                            <th>Ip Komputer</th>
                                            <th><center>Aksi</center></th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                     <?php 
                                        $query1="SELECT * FROM pengunjung WHERE id='$_GET[kd]'";
                                        $tampil=mysqli_query($connect,$query1) or die(mysqli_error());
                                        while($datax=mysqli_fetch_array($tampil)){ 
                                        $cek_status = $datax['status'];
                                        $cekidx = $datax['id'];
                                     ?>
                                        <tr>
                                            <td><?php echo $cekidx;?></td>
                                            <td><?php echo date ('d F Y',strtotime ($datax['tgllapor']));echo" ["; echo $datax['jamlapor']; echo"]";?></td>
                                            <td><?php echo $datax['nama']; echo"<br>["; echo $datax['depart'];  echo"]";?></td>
                                            <td>
                                                <a class="waves-effect m-b-15" role="button" data-toggle="collapse" href="#<?php echo $cekidx;?>" aria-expanded="false"
                                                   aria-controls="collapseExample"><?php echo $datax['jnskendala'];?></a>

                                                <div class="collapse" id="<?php echo $cekidx;?>">
                                                  <i><br>Petugas IT : [<?php echo $datax['petugas'];?>]<br>Prioritas : [<?php echo $datax['nama_prioritas'];?>]<br>
                                                    Kategori : [<?php echo $datax['jenis'];?>]<br><br>Repair Date :<br><?php echo date ('d F Y',strtotime ($datax['tglperbaikan']));echo" ["; echo $datax['jamperbaikan']; echo"]";?></i>
                                                </div> 
                                            </td>
                                            <td><?php echo date ('d F Y',strtotime ($datax['tglselesai']));echo" ["; echo $datax['jamselesai']; echo"]";?></td>
                                            <td><?php echo $datax['ipclient'];?></td>
                                            <td align="center" style="vertical-align: middle;">
                                                <a href="index.php?page=alldata" class="btn btn-default waves-effect btn-table-back" title="Kembali">
                                                    <i class="material-icons">reply_all</i>
                                                </a>       
                                            </td>
                                        </tr>
                                    <?php   
                                    } 
                                    ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
       <!--     </div>  -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SOLUTION MRT-IT
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
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                <form id="faccept" name="fsolution" action="index.php?page=udataeditall" method="POST">
                                    <div class="form-group form-float">
                                        <label class="form-label">Kategori</label>
                                        <select name="fkategori" class="form-control show-tick" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php
                                                $isi = $data['jenis'];
                                                  $in=mysql_query("select nama from jenis order by id_jenis");
                                                  while($row1=mysql_fetch_array($in)){  
                                                    if ($isi == $row1['nama']) {
                                                        echo'<option value="'.$row1['nama'].'" selected>'.$row1['nama'].'</option>';
                                                    }else{
                                                        echo'<option value="'.$row1['nama'].'">'.$row1['nama'].'</option>';
                                                    } 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-float">
                                        <input name="id" type="hidden" value="<?php echo $data['id']; ?>">
                                        <label class="form-label">Jenis Kendala</label>
                                        <select name="fjnstrouble" class="form-control show-tick" required>
                                            <option value="">-- Pilih Jenis Kendala --</option>
                                            <?php
                                                $isi = $data['kendala'];
                                                  $in=mysql_query("select jnstrouble from tb_jnstrouble order by id");
                                                  while($row1=mysql_fetch_array($in)){  
                                                    if ($isi == $row1['jnstrouble']) {
                                                        echo'<option value="'.$row1['jnstrouble'].'" selected>'.$row1['jnstrouble'].'</option>';
                                                    }else{
                                                        echo'<option value="'.$row1['jnstrouble'].'">'.$row1['jnstrouble'].'</option>';
                                                    } 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-float">
                                        <label class="form-label">Prioritas</label>
                                        <select name="fprioritas" class="form-control show-tick" required>
                                            <option value="">-- Pilih Prioritas --</option>
                                            <?php
                                                $isi = $data['nama_prioritas'];
                                                  $in=mysql_query("select nama_prioritas from tb_prioritas order by id");
                                                  while($row1=mysql_fetch_array($in)){  
                                                    if ($isi == $row1['nama_prioritas']) {
                                                        echo'<option value="'.$row1['nama_prioritas'].'" selected>'.$row1['nama_prioritas'].'</option>';
                                                    }else{
                                                        echo'<option value="'.$row1['nama_prioritas'].'">'.$row1['nama_prioritas'].'</option>';
                                                    } 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-float">
                                        <label class="form-label">Petugas</label>
                                        <select name="fpetugas" class="form-control show-tick" required>
                                            <option value="">-- Pilih Petugas IT --</option>
                                            <?php
                                                $isi = $data['petugas'];
                                                  $in=mysql_query("select nama_petugas from tb_petugas order by id");
                                                  while($row1=mysql_fetch_array($in)){  
                                                    if ($isi == $row1['nama_petugas']) {
                                                        echo'<option value="'.$row1['nama_petugas'].'" selected>'.$row1['nama_petugas'].'</option>';
                                                    }else{
                                                        echo'<option value="'.$row1['nama_petugas'].'">'.$row1['nama_petugas'].'</option>';
                                                    } 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea name="desckerusakan" cols="30" rows="2" class="form-control no-resize" required><?php echo strtoupper ($data['kerusakan']) ?></textarea>
                                            <label class="form-label">Deskripsi Kerusakan</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea name="desctindakan" cols="30" rows="2" class="form-control no-resize" required><?php echo strtoupper ($data['tindakan']) ?></textarea>
                                            <label class="form-label">Deskripsi Tindakan</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <label class="form-label">Pergantian Hardware</label>
                                        <select name="fghardware" class="form-control show-tick" required>
                                            <option value="">-- Tentukan Pilihan --</option>
                                            <?php
                                                $isi = $data['hardware'];  
                                                    if ($isi == '1') {
                                                        echo'<option value="1" selected>Ya</option>';
                                                        echo'<option value="0">Tidak</option>';
                                                    }else{
                                                        echo'<option value="1">Ya</option>';
                                                        echo'<option value="0" selected>Tidak</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-float">
                                        <label class="form-label">Remote Komputer</label>
                                        <select name="fremote" class="form-control show-tick" required>
                                            <option value="">-- Tentukan Pilihan --</option>
                                            <?php
                                                $isi = $data['remote'];  
                                                    if ($isi == 'Ya') {
                                                        echo'<option value="Ya" selected>Ya</option>';
                                                        echo'<option value="Tidak">Tidak</option>';
                                                    }else{
                                                        echo'<option value="Ya">Ya</option>';
                                                        echo'<option value="Tidak" selected>Tidak</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-float">
                                        <label class="form-label">Feedback</label>
                                        <select name="ffeedback" class="form-control show-tick" required>
                                            <option value="">-- Tentukan Pilihan --</option>
                                            <?php
                                                $isi = $data['feedback'];  
                                                    if ($isi == 'Positif') {
                                                        echo'<option value="Positif" selected>Positif</option>';
                                                        echo'<option value="Negatif">Negatif</option>';
                                                    }else{
                                                        echo'<option value="Positif">Positif</option>';
                                                        echo'<option value="Negatif" selected>Negatif</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input name="ftanggalselesai" type="text" value="<?php echo $data['tglselesai'];?>" class="form-control" />
                                            <label class="form-label">Tanggal Selesai</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <?php date_default_timezone_set('Asia/Jakarta');?>
                                            <input name="ftimeselesai" type="text" value="<?php echo $data['jamselesai'];?>" class="form-control" />
                                            <label class="form-label">Jam Selesai</label>
                                        </div>
                                    </div>
                                     <div class="row clearfix">
                                         <div class="col-md-12">
                                             <div class="form-action-bar">
                                                 <button type="submit" class="btn btn-primary waves-effect">
                                                     <i class="material-icons">save</i> SAVE
                                                 </button>
                                                 <a href="index.php?page=alldata">
                                                     <button type="button" class="btn btn-danger waves-effect">
                                                         <i class="material-icons">close</i> CLOSE
                                                     </button>
                                                 </a>
                                             </div>
                                         </div>
                                     </div>
                                  </form>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Select -->