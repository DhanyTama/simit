<?php
    $query = mysqli_query($connect,"SELECT * FROM pengunjung WHERE id='$_GET[kd]'");
    $data  = mysqli_fetch_array($query);
?>
<!-- Select -->
<div class="row clearfix">
    <!-- <div class="row clearfix"> -->
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
                            <th>Repair Date</th>
                            <th>Ip Komputer</th>
                            <th>
                                <center>Aksi</center>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $noteperbaikan = "";
                                        $query1="SELECT * FROM pengunjung WHERE id='$_GET[kd]'";
                                        $tampil=mysqli_query($connect,$query1);
                                        while($datax=mysqli_fetch_array($tampil)){
                                        $cek_status = $datax['status'];
                                        $cekidx = $datax['id'];
                                        $noteperbaikan = $datax['noteperbaikan'];
                                        $petugas = $datax['petugas'];
                                     ?>
                        <tr>
                            <td><?php echo $cekidx;?></td>
                            <td><?php echo date ('d F Y',strtotime ($datax['tgllapor']));echo" ["; echo $datax['jamlapor']; echo"]";?></td>
                            <td><?php echo $datax['nama']; echo"<br>["; echo $datax['depart'];  echo"]";?></td>
                            <td>
                                <?php echo nl2br($datax['jnskendala']);?>

                                <div class="collapse" id="<?php echo $cekidx;?>">
                                    <i><br>Petugas IT : [<?php echo $datax['petugas'];?>]<br>Prioritas : [<?php echo $datax['nama_prioritas'];?>]<br>Kategori : [<?php echo $datax['jenis'];?>]</i>
                                </div>
                            </td>
                            <td><?php echo date ('d F Y',strtotime ($datax['tglperbaikan']));echo" ["; echo $datax['jamperbaikan']; echo"]";?></td>
                            <td><?php echo $datax['ipclient'];?></td>
                            <td align="center">
                                <a href="index.php?page=data">
                                    <button type="button" class="btn btn-default waves-effect">
                                        <i class="material-icons">reply_all</i>
                                    </button>
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
    <!-- </div> -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    SOLUTION MRT-IT
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a
                            href="javascript:void(0);"
                            class="dropdown-toggle"
                            data-toggle="dropdown"
                            role="button"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="javascript:void(0);">Action</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Another action</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Something else here</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-12">

                        <form
                            id="faccept"
                            name="fsolution"
                            action="index.php?page=usolution"
                            method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <input name="id" type="hidden" value="<?php echo $data['id']; ?>">
                                        <label class="form-label">Jenis Kendala</label>
                                        <select name="fjnstrouble" class="form-control show-tick" required="required">
                                            <option value="">-- Pilih Jenis Trouble --</option>
                                            <?php
                                                $in=mysqli_query($connect,"select jnstrouble from tb_jnstrouble order by id");
                                                while($row1=mysqli_fetch_array($in)){?>
                                            <option value="<?php echo $row1['jnstrouble'];?>"><?php echo $row1['jnstrouble'];?></option><?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group form-float">
                                        <label class="form-label">Petugas</label>
                                        <select name="fpetugas" class="form-control show-tick" required="required">
                                            <option value="">-- Pilih Petugas IT --</option>
                                            <?php
                                                $in=mysqli_query($connect,"select nama_petugas from tb_petugas order by id");
                                                while($row1=mysqli_fetch_array($in)){?>
                                            <option value="<?php echo $row1['nama_petugas'];?>" <?php if($row1['nama_petugas'] == $petugas){ echo 'selected'; } ?>><?php echo $row1['nama_petugas'];?></option><?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <label class="form-label">Deskripsi Kerusakan</label>
                                        <div class="form-line">
                                            <textarea
                                                name="desckerusakan"
                                                cols="30"
                                                rows="2"
                                                class="form-control no-resize"
                                                required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group form-float">
                                        <label class="form-label">Deskripsi Tindakan</label>
                                        <div class="form-line">
                                            <textarea
                                                name="desctindakan"
                                                cols="30"
                                                rows="2"
                                                class="form-control no-resize"
                                                required="required"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">

                            <div class="form-group form-float">
                                <label class="form-label">Status Pasien KRS</label>
                                <select name="krs" class="form-control show-tick" required="required">
                                    <option value="">-- Tentukan Pilihan --</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-md-6">

                            <div class="form-group form-float">
                                <label class="form-label">Pergantian Hardware</label>
                                <select name="fghardware" class="form-control show-tick" required="required">
                                    <!-- <option value="">-- Tentukan Pilihan --</option> -->
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                            <div class="form-group form-float">
                                <label class="form-label">Remote Komputer</label>
                                <select name="fremote" class="form-control show-tick" required="required">
                                    <!-- <option value="">-- Tentukan Pilihan --</option> -->
                                    <option value="Tidak">Tidak</option>
                                    <option value="Ya">Ya</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-md-6">

                            <div class="form-group form-float">
                                <label class="form-label">Feedback</label>
                                <select name="ffeedback" class="form-control show-tick" required="required" readonly>
                                    <!-- <option value="">-- Tentukan Pilihan --</option> -->
                                    <option value="Positif">Positif</option>
                                    <!-- <option value="Negatif">Negatif</option> -->
                                </select>
                            </div>
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <label class="form-label">Tanggal Selesai</label>
                                        <div class="form-line">
                                            <input
                                                name="ftanggalselesai"
                                                type="text"
                                                value="<?php echo "".date("Y-m-d").""; ?>"
                                                class="form-control"
                                                />
                                            <!-- <label class="form-label">Tanggal Selesai</label> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group form-float">
                                        <label class="form-label">Jam Selesai</label>
                                        <div class="form-line">
                                            <?php date_default_timezone_set('Asia/Jakarta');?>
                                            <input
                                                name="ftimeselesai"
                                                type="text"
                                                value="<?php echo "".date("H:i:s").""?>"
                                                class="form-control"
                                                />
                                            <!-- <label class="form-label">Jam Selesai</label> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <label class="form-label">Note Perbaikan</label>
                                        <div class="form-line" style="background-color: pink;">
                                            <textarea name="noteperbaikan" class="form-control" rows="3" style="background-color: pink;" required><?php echo $noteperbaikan; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-line">
                                <button type="submit" class="btn btn-link waves-effect">SAVE</button>
                                <a href="index.php?page=data">
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>