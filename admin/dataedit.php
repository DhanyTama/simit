<?php
    $query = mysqli_query($connect,"SELECT * FROM pengunjung WHERE id='$_GET[kd]'");
    $data  = mysqli_fetch_array($query);
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
                                        $tampil=mysqli_query($connect,$query1);
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
                                            <td align="center">
                                                <a href="index.php?page=data"><button type="button" class="btn btn-default waves-effect">
                                                    <i class="material-icons">reply_all</i>
                                                </button></a>       
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
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                
                                <form id="faccept" name="fsolution" action="index.php?page=udataedit" method="POST">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Kategori</label>
                                            <input type="text" value="<?php echo $data['jenis']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jenis Kendala</label>
                                            <input type="text" value="<?php echo $data['kendala']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Prioritas</label>
                                            <input type="text" value="<?php echo $data['nama_prioritas']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Petugas</label>
                                            <input type="text" value="<?php echo $data['petugas']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Deskripsi Kerusakan</label>
                                            <textarea rows="2" class="form-control " required><?php echo $data['kerusakan']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Deskripsi Tindakan</label>
                                            <textarea rows="2" class="form-control " required><?php echo $data['tindakan']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Pergantian Hardware</label>
                                            <select name="fghardware" class="form-control show-tick" required>
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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Remote Komputer</label>
                                            <select name="fremote" class="form-control show-tick" required>
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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Feedback</label>
                                            <select name="ffeedback" class="form-control show-tick" required>
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
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Selesai</label>
                                            <input type="text" value="<?php echo $data['tglselesai'];?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <?php date_default_timezone_set('Asia/Jakarta');?>
                                        <div class="form-group">
                                            <label class="form-label">Jam Selesai</label>
                                            <input type="text" value="<?php echo $data['jamselesai'];?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Note Perbaikan</label>
                                            <textarea rows="2" class="form-control"><?php echo $data['noteperbaikan']; ?></textarea>
                                        </div>
                                    </div>
                                
                                </form>   
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Select -->