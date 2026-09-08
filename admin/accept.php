<?php
    date_default_timezone_set('Asia/Jakarta');

    // ✅ Sanitasi input untuk keamanan
    $kd = isset($_GET['kd']) ? intval($_GET['kd']) : 0;
    if ($kd <= 0) {
        echo "<script>alert('Invalid ticket ID'); window.location='index.php?page=data';</script>";
        exit;
    }

    $query = mysqli_query($connect, "SELECT * FROM pengunjung WHERE id='$kd'");
    $data  = mysqli_fetch_array($query);
    
    if (!$data) {
        echo "<script>alert('Data tidak ditemukan'); window.location='index.php?page=data';</script>";
        exit;
    }
    
    $time = date('H:i:s');
    $tanggalperbaikan = date('Y-m-d');
?>

<!-- Select -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>DATA MAINTENANCE/TROUBLE/REQUEST IT</h2>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Start date</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>IP Komputer</th>
                            <th><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query1 = "SELECT * FROM pengunjung WHERE id='$kd'";
                        $tampil = mysqli_query($connect, $query1);
                        while($datax = mysqli_fetch_array($tampil)){
                        ?>
                        <tr>
                            <td><?php echo $datax['id'];?></td>
                            <td><?php echo date('d F Y', strtotime($datax['tgllapor']))." [".$datax['jamlapor']."]";?></td>
                            <td><?php echo $datax['nama']."<br>[".$datax['depart']."]";?></td>
                            <td><?php echo nl2br(trim($datax['jnskendala']));?></td>
                            <td><?php echo $datax['ipclient'];?></td>
                            <td align="center" style="vertical-align: middle;">
                                <a href="index.php?page=data" class="btn btn-default waves-effect btn-table-back" title="Kembali">
                                    <i class="material-icons">reply_all</i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FORM KONFIRMASI -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>KONFIRMASI MRT-IT</h2>
            </div>
            <div class="body">
                <form id="faccept" name="faccept" action="index.php?page=uaccept" method="POST">
                    <input name="id" type="hidden" value="<?php echo $data['id']; ?>">
                    
                    <!-- Row 1: Kategori & Prioritas -->
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <label class="form-label">Kategori</label>
                                <select name="fkategori" class="form-control show-tick" data-live-search="true" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $in = mysqli_query($connect, "SELECT nama FROM jenis ORDER BY id_jenis");
                                    while($row1 = mysqli_fetch_array($in)){
                                        $selected = ($row1['nama'] == $data['jenis']) ? 'selected' : '';
                                        echo '<option value="'.$row1['nama'].'" '.$selected.'>'.$row1['nama'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <label class="form-label">Prioritas</label>
                                <select name="fprioritas" class="form-control show-tick" data-live-search="true" required>
                                    <option value="">-- Pilih Prioritas --</option>
                                    <?php
                                    $in = mysqli_query($connect, "SELECT nama_prioritas FROM tb_prioritas ORDER BY id");
                                    while($row1 = mysqli_fetch_array($in)){
                                        $selected = ($row1['nama_prioritas'] == $data['nama_prioritas']) ? 'selected' : '';
                                        echo '<option value="'.$row1['nama_prioritas'].'" '.$selected.'>'.$row1['nama_prioritas'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Petugas & Note -->
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <label class="form-label">Petugas</label>
                                <select name="fpetugas" class="form-control show-tick" data-live-search="true" required>
                                    <option value="">-- Pilih Petugas IT --</option>
                                    <?php
                                    $in = mysqli_query($connect, "SELECT nama_petugas FROM tb_petugas ORDER BY id");
                                    while($row1 = mysqli_fetch_array($in)){
                                        $selected = ($row1['nama_petugas'] == $data['petugas']) ? 'selected' : '';
                                        echo '<option value="'.$row1['nama_petugas'].'" '.$selected.'>'.$row1['nama_petugas'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <label class="form-label">NOTE Perbaikan</label>
                                <div class="form-line">
                                    <textarea name="noteperbaikan" class="form-control no-resize" rows="3" required><?php echo htmlspecialchars((string)($data['noteperbaikan'] ?? '')); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Tanggal & Jam -->
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <label class="form-label">Tanggal Perbaikan</label>
                                <input name="ftanggalacpt" type="text" value="<?php echo $tanggalperbaikan; ?>" class="form-control"  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <label class="form-label">Jam Perbaikan</label>
                                <input name="ftimeacpt" type="text" value="<?php echo $time; ?>" class="form-control"  />
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: Tombol Action (FULL WIDTH) -->
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-action-bar">
                                <button type="submit" class="btn btn-primary waves-effect">
                                    <i class="material-icons">save</i> SAVE
                                </button>
                                <a href="index.php?page=data" class="btn btn-danger waves-effect">
                                    <i class="material-icons">close</i> CLOSE
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- #END# Select -->