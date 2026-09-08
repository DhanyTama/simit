<?php
date_default_timezone_set('Asia/Jakarta');
$tampil = mysqli_query($connect, "SELECT * FROM pengunjung WHERE status='Complete' ORDER BY id DESC LIMIT 1000");
?>

<!-- Basic Examples -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>DATA MAINTENANCE/TROUBLE/REQUEST IT COMPLETE ALL</h2>
        </div>
        <div class="body">
            <!-- Loading State -->
            <div id="loading-alldata" style="padding: 60px 20px; text-align: center;">
                <div class="preloader pl-size-l">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p style="margin-top: 20px; font-weight: 700; color: #1e293b; font-size: 15px; letter-spacing: 0.3px;">
                    Memuat data... Harap tunggu sebentar
                </p>
                <small style="color: #64748b; font-size: 12.5px;">Sedang menyiapkan data transaksi complete</small>
            </div>

            <div class="table-responsive" id="table-wrapper-alldata" style="display: none;">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Start date</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th class="text-center" style="text-align: center !important;">Status</th>
                            <th>Repair Date</th>
                            <th>End date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        while ($data = mysqli_fetch_array($tampil)) {
                            $no++;
                            $cekidx = $data['id'];
                        ?>
                            <tr>
                                <td align="center" style="font-weight: 600; color: #64748b;"><?php echo $no; ?></td>
                                <td>
                                    <span style="font-weight: 600; color: #1e293b;"><?php echo date('d M Y', strtotime($data['tgllapor'])); ?></span>
                                    <br><small style="color: #64748b; font-size: 11px;">[<?php echo $data['jamlapor']; ?>]</small>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars((string)($data['nama'] ?? '')); ?></span>
                                    <br><span style="color: #64748b; font-size: 11.5px;">[<?php echo htmlspecialchars((string)($data['depart'] ?? '')); ?>]</span>
                                </td>
                                <td>
                                    <span style="font-weight: 500;"><?php echo htmlspecialchars((string)($data['jnskendala'] ?? '')); ?></span><br>
                                    <a
                                        class="waves-effect m-b-15"
                                        role="button"
                                        data-toggle="collapse"
                                        href="#<?php echo $cekidx; ?>"
                                        aria-expanded="false"
                                        aria-controls="collapseExample"
                                        style="font-size: 12px; font-weight: 600; color: #0284c7; text-decoration: none;">Detail...</a>

                                    <div class="collapse" id="<?php echo $cekidx; ?>" style="margin-top: 6px; padding: 8px 12px; background: #f8fafc; border-radius: 6px; border-left: 3px solid #0284c7;">
                                        <small style="color: #475569; font-style: normal; display: block; line-height: 1.6;">
                                            <strong>Kerusakan:</strong> <?php echo htmlspecialchars((string)($data['kerusakan'] ?? '-')); ?><br>
                                            <strong>Tindakan:</strong> <?php echo htmlspecialchars((string)($data['tindakan'] ?? '-')); ?><br>
                                            <strong>Petugas IT:</strong> <?php echo htmlspecialchars((string)($data['petugas'] ?? '-')); ?><br>
                                            <strong>Prioritas:</strong> <?php echo htmlspecialchars((string)($data['nama_prioritas'] ?? '-')); ?><br>
                                            <strong>Kategori:</strong> <?php echo htmlspecialchars((string)($data['jenis'] ?? '-')); ?><br>
                                            <strong>Jenis Kendala:</strong> <?php echo htmlspecialchars((string)($data['kendala'] ?? '-')); ?><br>
                                            <strong>Catatan:</strong> <?php echo htmlspecialchars((string)($data['noteperbaikan'] ?? '-')); ?>
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center" align="center" style="text-align: center !important;">
                                    <?php
                                    $st = $data['status'];
                                    if ($st == 'Complete') {
                                        echo "<span class='label bg-green' style='font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;'>Complete</span>";
                                    } elseif ($st == 'In Progress') {
                                        echo "<span class='label bg-blue' style='font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;'>In Progress</span>";
                                    } elseif ($st == 'Open') {
                                        echo "<span class='label bg-pink' style='font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;'>Open</span>";
                                    } else {
                                        echo "<span class='label bg-grey' style='font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;'>" . htmlspecialchars((string)$st) . "</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($data['tglperbaikan']) && $data['tglperbaikan'] != '0000-00-00') {
                                        echo "<span style='font-weight: 600; color: #1e293b;'>" . date('d M Y', strtotime($data['tglperbaikan'])) . "</span><br><small style='color: #64748b; font-size: 11px;'>[" . $data['jamperbaikan'] . "]</small>";
                                    } else {
                                        echo "<span class='text-muted' style='color: #94a3b8;'>-</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($data['tglselesai']) && $data['tglselesai'] != '0000-00-00') {
                                        echo "<span style='font-weight: 600; color: #1e293b;'>" . date('d M Y', strtotime($data['tglselesai'])) . "</span><br><small style='color: #64748b; font-size: 11px;'>[" . $data['jamselesai'] . "]</small>";
                                    } else {
                                        echo "<span class='text-muted' style='color: #94a3b8;'>-</span>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Fallback aman tanpa dependensi jQuery langsung di sini
window.addEventListener('load', function () {
    setTimeout(function () {
        var l = document.getElementById('loading-alldata');
        var w = document.getElementById('table-wrapper-alldata');
        if (l) l.style.display = 'none';
        if (w) w.style.display = 'block';
    }, 600);
});
</script>