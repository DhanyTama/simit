<?php
if (!isset($connect)) {
    include "../conn.php";
}
date_default_timezone_set('Asia/Jakarta');

// Parameter Filter Bulan (Default bulan saat ini)
$bulan_filter = isset($_GET['bulan']) && preg_match('/^\d{4}-\d{2}$/', $_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
$tgl = $bulan_filter;
$nama_bulan_filter = date('F Y', strtotime($tgl . '-01'));

// Helper untuk inisial nama petugas
function getOfficerInitials($name)
{
    $clean = trim(preg_replace('/[^a-zA-Z\s]/', '', $name));
    $words = preg_split('/\s+/', $clean);
    if (count($words) >= 2) {
        return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    } elseif (!empty($words[0])) {
        return strtoupper(substr($words[0], 0, 2));
    }
    return 'IT';
}

// ==========================================
// 1. DATA TREN GANGGUAN HARIAN & KATEGORI
// ==========================================
$labels = [];
$software = [];
$hardware = [];
$network = [];

$tot_software = 0;
$tot_hardware = 0;
$tot_network = 0;
$tot_komunikasi = 0;
$tot_security = 0;
$tot_other = 0;

$q = mysqli_query($connect, "SELECT * FROM tb_grafik_jnstrouble WHERE tanggal LIKE '%$tgl%' ORDER BY tanggal ASC");
if ($q && mysqli_num_rows($q) > 0) {
    while ($r = mysqli_fetch_assoc($q)) {
        $labels[] = date('d M', strtotime($r['tanggal']));
        $s = (int)$r['SOFTWARE'];
        $h = (int)$r['HARDWARE'];
        $n = (int)$r['NETWORK'];
        $k = (int)$r['KOMUNIKASI'];
        $sec = (int)$r['SECURITY_SYSTEM'];
        $o = (int)$r['OTHER'];

        $software[] = $s;
        $hardware[] = $h;
        $network[] = $n;

        $tot_software += $s;
        $tot_hardware += $h;
        $tot_network += $n;
        $tot_komunikasi += $k;
        $tot_security += $sec;
        $tot_other += $o;
    }
}

// ==========================================
// 2. DATA GRAFIK & STATISTIK PER PETUGAS IT
// ==========================================
$petugas_labels = [];
$petugas_total = [];
$petugas_complete = [];
$petugas_progress = [];
$petugas_list = [];
$is_all_time_petugas = false;

// Query per petugas di bulan terpilih
$q_petugas = mysqli_query($connect, "
    SELECT 
        petugas,
        COUNT(*) as total_tiket,
        SUM(CASE WHEN status IN ('Complete', 'Selesai', 'Completed') THEN 1 ELSE 0 END) as total_complete,
        SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as total_progress,
        SUM(CASE WHEN jenis = 'TROUBLE' THEN 1 ELSE 0 END) as total_trouble,
        SUM(CASE WHEN jenis = 'REQUEST' THEN 1 ELSE 0 END) as total_request
    FROM pengunjung 
    WHERE petugas IS NOT NULL 
      AND TRIM(petugas) != '' 
      AND LOWER(TRIM(petugas)) != 'open'
      AND (tgllapor LIKE '%$tgl%' OR tglselesai LIKE '%$tgl%' OR tglperbaikan LIKE '%$tgl%')
    GROUP BY petugas 
    ORDER BY total_tiket DESC
");

// Fallback: Jika di bulan ini belum ada data tiket per petugas, tampilkan data ringkasan keseluruhan
if (!$q_petugas || mysqli_num_rows($q_petugas) == 0) {
    $q_petugas = mysqli_query($connect, "
        SELECT 
            petugas,
            COUNT(*) as total_tiket,
            SUM(CASE WHEN status IN ('Complete', 'Selesai', 'Completed') THEN 1 ELSE 0 END) as total_complete,
            SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as total_progress,
            SUM(CASE WHEN jenis = 'TROUBLE' THEN 1 ELSE 0 END) as total_trouble,
            SUM(CASE WHEN jenis = 'REQUEST' THEN 1 ELSE 0 END) as total_request
        FROM pengunjung 
        WHERE petugas IS NOT NULL 
          AND TRIM(petugas) != '' 
          AND LOWER(TRIM(petugas)) != 'open'
        GROUP BY petugas 
        ORDER BY total_tiket DESC
        LIMIT 10
    ");
    $is_all_time_petugas = true;
}

if ($q_petugas) {
    while ($p = mysqli_fetch_assoc($q_petugas)) {
        $nama_p = htmlspecialchars(trim($p['petugas']));
        $tot = (int)$p['total_tiket'];
        $comp = (int)$p['total_complete'];
        $prog = (int)$p['total_progress'];

        $petugas_labels[] = $nama_p;
        $petugas_total[] = $tot;
        $petugas_complete[] = $comp;
        $petugas_progress[] = $prog;

        $petugas_list[] = [
            'nama' => $nama_p,
            'initials' => getOfficerInitials($nama_p),
            'total' => $tot,
            'complete' => $comp,
            'progress' => $prog,
            'rate' => ($tot > 0) ? round(($comp / $tot) * 100) : 0,
            'trouble' => (int)$p['total_trouble'],
            'request' => (int)$p['total_request']
        ];
    }
}

$total_tiket_petugas = array_sum($petugas_total);
$total_petugas_aktif = count($petugas_labels);
$total_complete_all = array_sum($petugas_complete);
$avg_completion_rate = ($total_tiket_petugas > 0) ? round(($total_complete_all / $total_tiket_petugas) * 100) : 0;
?>

<style>
    /* UNIFIED CARDS & FILTER BAR */
    /* UNIFIED CARDS & FILTER BAR */
    .card.filter-card {
        margin-bottom: 20px !important;
        border-radius: 16px !important;
        border: none !important;
        background: #ffffff !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
        transition: background-color 0.25s ease, box-shadow 0.25s ease;
    }

    html.dark-mode .card.filter-card,
    body.dark-mode .card.filter-card {
        background: #111c38 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
    }

    .filter-card-body {
        padding: 12px 20px !important;
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 12px !important;
    }

    .filter-card-body .title-area h2 {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin: 0 0 3px 0 !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    html.dark-mode .filter-card-body .title-area h2,
    body.dark-mode .filter-card-body .title-area h2 {
        color: #f8fafc !important;
    }

    .filter-card-body .title-area p {
        font-size: 11.5px;
        color: #64748b;
        margin: 0;
    }

    html.dark-mode .filter-card-body .title-area p,
    body.dark-mode .filter-card-body .title-area p {
        color: #94a3b8 !important;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-form .filter-label {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        margin: 0;
    }

    html.dark-mode .filter-form .filter-label,
    body.dark-mode .filter-form .filter-label {
        color: #94a3b8 !important;
    }

    .filter-form input[type="month"] {
        padding: 6px 12px;
        border-radius: 8px;
        border: 1.5px solid #cbd5e1;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        background: #f8fafc;
        outline: none;
        transition: all 0.2s;
    }

    html.dark-mode .filter-form input[type="month"],
    body.dark-mode .filter-form input[type="month"] {
        background: #0b1329 !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
        color-scheme: dark;
    }

    .filter-form input[type="month"]:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }

    .btn-filter-action {
        border-radius: 8px !important;
        font-size: 11.5px !important;
        font-weight: 600 !important;
        padding: 6px 14px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 5px !important;
        box-shadow: none !important;
        text-transform: uppercase !important;
    }

    .btn-filter-reset {
        background: #f1f5f9 !important;
        color: #475569 !important;
        border: 1px solid #cbd5e1 !important;
    }

    html.dark-mode .btn-filter-reset,
    body.dark-mode .btn-filter-reset {
        background: #1e293b !important;
        color: #cbd5e1 !important;
        border-color: #334155 !important;
    }

    /* MINI STAT CARDS (MATCHING TOP FILTER SIZE) */
    .stat-chip {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 10px 16px !important;
        background: #ffffff !important;
        border-radius: 16px !important;
        border: none !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
        margin-bottom: 20px !important;
        min-height: 68px !important;
        height: 68px !important;
        box-sizing: border-box !important;
        width: 100% !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.25s ease !important;
    }

    .stat-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
    }

    html.dark-mode .stat-chip,
    body.dark-mode .stat-chip {
        background: #111c38 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
    }

    .stat-chip .chip-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
    }

    .stat-chip .chip-icon i.material-icons {
        font-size: 22px !important;
        line-height: 1 !important;
        color: #ffffff !important;
    }

    .stat-chip .chip-info {
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        flex: 1 !important;
        min-width: 0 !important;
    }

    .stat-chip .chip-label {
        font-size: 10.5px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        color: #64748b !important;
        letter-spacing: 0.3px !important;
        line-height: 1.15 !important;
        margin-bottom: 2px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    html.dark-mode .stat-chip .chip-label,
    body.dark-mode .stat-chip .chip-label {
        color: #94a3b8 !important;
    }

    .stat-chip .chip-val {
        font-size: 20px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        line-height: 1.1 !important;
    }

    html.dark-mode .stat-chip .chip-val,
    body.dark-mode .stat-chip .chip-val {
        color: #ffffff !important;
    }

    /* GENERAL CARDS */
    .card {
        border-radius: 16px !important;
        border: none !important;
        overflow: hidden !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
        margin-bottom: 20px !important;
        background: #ffffff !important;
        transition: background-color 0.25s ease, box-shadow 0.25s ease;
    }

    html.dark-mode .card,
    body.dark-mode .card {
        background: #111c38 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
    }

    .card .header {
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
        padding: 16px 20px 12px 20px !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    html.dark-mode .card .header,
    body.dark-mode .card .header {
        border-bottom: 1px solid #1e293b !important;
    }

    .card .header h2 {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        letter-spacing: 0.3px !important;
        margin: 0 !important;
    }

    html.dark-mode .card .header h2,
    body.dark-mode .card .header h2 {
        color: #f8fafc !important;
    }

    .card .header small {
        display: block;
        margin-top: 3px;
        color: #64748b !important;
        font-size: 11.5px !important;
    }

    html.dark-mode .card .header small,
    body.dark-mode .card .header small {
        color: #94a3b8 !important;
    }

    /* LEADERBOARD TABLE */
    .leaderboard-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-leaderboard {
        width: 100% !important;
        margin-bottom: 0 !important;
        border-collapse: collapse !important;
    }

    .table-leaderboard thead th {
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.6px !important;
        color: #64748b !important;
        background: #f8fafc !important;
        border-bottom: 1.5px solid #e2e8f0 !important;
        border-top: none !important;
        padding: 14px 16px !important;
        white-space: nowrap !important;
    }

    html.dark-mode .table-leaderboard thead th,
    body.dark-mode .table-leaderboard thead th {
        background: #0d152b !important;
        color: #94a3b8 !important;
        border-bottom: 1.5px solid #1e293b !important;
    }

    .table-leaderboard tbody td {
        padding: 13px 16px !important;
        vertical-align: middle !important;
        font-size: 13px !important;
        border-top: 1px solid #f1f5f9 !important;
        border-bottom: none !important;
    }

    html.dark-mode .table-leaderboard tbody td,
    body.dark-mode .table-leaderboard tbody td {
        border-top: 1px solid #1e293b !important;
    }

    html.dark-mode .table-hover>tbody>tr:hover {
        background-color: rgba(255, 255, 255, 0.035) !important;
    }

    .petugas-name {
        color: #0f172a;
        font-weight: 700;
        font-size: 13.5px;
        letter-spacing: 0.2px;
    }

    html.dark-mode .petugas-name,
    body.dark-mode .petugas-name {
        color: #f8fafc !important;
    }

    .total-val {
        font-weight: 800;
        font-size: 14px;
        color: #0f172a;
    }

    html.dark-mode .total-val,
    body.dark-mode .total-val {
        color: #f8fafc !important;
    }

    .petugas-avatar-badge {
        width: 36px;
        height: 36px;
        border-radius: 11px;
        color: #ffffff;
        font-weight: 800;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        flex-shrink: 0;
        letter-spacing: 0.5px;
    }

    /* Rank Badges */
    .rank-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        font-weight: 800;
        font-size: 12px;
    }

    .rank-pill.rank-1 {
        background: #fef3c7;
        color: #b45309;
        border: 1.5px solid #f59e0b;
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.25);
    }

    html.dark-mode .rank-pill.rank-1,
    body.dark-mode .rank-pill.rank-1 {
        background: rgba(245, 158, 11, 0.2) !important;
        color: #fbbf24 !important;
        border-color: #f59e0b !important;
        box-shadow: 0 0 12px rgba(245, 158, 11, 0.35);
    }

    .rank-pill.rank-2 {
        background: #f1f5f9;
        color: #334155;
        border: 1.5px solid #94a3b8;
    }

    html.dark-mode .rank-pill.rank-2,
    body.dark-mode .rank-pill.rank-2 {
        background: rgba(148, 163, 184, 0.2) !important;
        color: #e2e8f0 !important;
        border-color: #94a3b8 !important;
    }

    .rank-pill.rank-3 {
        background: #ffedd5;
        color: #9a3412;
        border: 1.5px solid #fb923c;
    }

    html.dark-mode .rank-pill.rank-3,
    body.dark-mode .rank-pill.rank-3 {
        background: rgba(251, 146, 60, 0.2) !important;
        color: #fdba74 !important;
        border-color: #fb923c !important;
    }

    .rank-pill.rank-other {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    html.dark-mode .rank-pill.rank-other,
    body.dark-mode .rank-pill.rank-other {
        background: #0f172a !important;
        color: #94a3b8 !important;
        border-color: #1e293b !important;
    }

    /* Mini Tag Pills for Trouble & Request */
    .mini-tag {
        display: inline-flex;
        align-items: center;
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 6px;
        margin-right: 4px;
    }

    .mini-tag-trouble {
        background: rgba(244, 63, 94, 0.12);
        color: #e11d48;
    }

    html.dark-mode .mini-tag-trouble,
    body.dark-mode .mini-tag-trouble {
        background: rgba(244, 63, 94, 0.2);
        color: #fb7185;
    }

    .mini-tag-request {
        background: rgba(14, 165, 233, 0.12);
        color: #0284c7;
    }

    html.dark-mode .mini-tag-request,
    body.dark-mode .mini-tag-request {
        background: rgba(14, 165, 233, 0.2);
        color: #38bdf8;
    }

    /* Progress Bar */
    .prog-box {
        min-width: 140px;
        max-width: 180px;
    }

    .prog-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 11.5px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #475569;
    }

    html.dark-mode .prog-header,
    body.dark-mode .prog-header {
        color: #cbd5e1 !important;
    }

    .prog-track {
        height: 6px;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
    }

    html.dark-mode .prog-track,
    body.dark-mode .prog-track {
        background: #1e293b !important;
    }

    .prog-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        transition: width 0.6s ease;
    }

    .badge-empty {
        color: #94a3b8;
        font-size: 13px;
        font-weight: 600;
    }
</style>

<!-- ======================================================== -->
<!-- TOP FILTER BAR (DIRECT COL-12, FLUSH WITH GRID)          -->
<!-- ======================================================== -->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card filter-card">
        <div class="filter-card-body">
            <div class="title-area">
                <h2>
                    <i class="material-icons" style="color: #0284c7; font-size: 22px;">insert_chart</i>
                    GRAFIK & STATISTIK MRT - IT
                </h2>
                <p>
                    Periode Data: <strong><?php echo $nama_bulan_filter; ?></strong>
                    <?php if ($is_all_time_petugas) { ?>
                        <span class="label bg-orange m-l-5" style="border-radius: 6px; font-size: 10.5px;">Data Petugas (All-Time Fallback)</span>
                    <?php } ?>
                </p>
            </div>
            <form class="filter-form" method="GET" action="index.php">
                <input type="hidden" name="page" value="chartjs">
                <label for="bulan" class="filter-label">Pilih Periode:</label>
                <input type="month" id="bulan" name="bulan" value="<?php echo htmlspecialchars($bulan_filter); ?>">
                <button type="submit" class="btn btn-primary waves-effect btn-filter-action">
                    <i class="material-icons" style="font-size: 16px;">filter_list</i> Filter
                </button>
                <?php if ($bulan_filter !== date('Y-m')) { ?>
                    <a href="index.php?page=chartjs" class="btn btn-default waves-effect btn-filter-action btn-filter-reset" title="Kembali ke Bulan Ini">
                        <i class="material-icons" style="font-size: 16px;">refresh</i> Reset
                    </a>
                <?php } ?>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MINI STAT SUMMARY CHIPS (DIRECT GRID COLS, FLUSH WIDTH)  -->
<!-- ======================================================== -->
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
    <div class="stat-chip">
        <div class="chip-icon" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
            <i class="material-icons">assignment_ind</i>
        </div>
        <div class="chip-info">
            <span class="chip-label">TOTAL TIKET PETUGAS</span>
            <span class="chip-val"><?php echo number_format($total_tiket_petugas); ?></span>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
    <div class="stat-chip">
        <div class="chip-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <i class="material-icons">check_circle</i>
        </div>
        <div class="chip-info">
            <span class="chip-label">TOTAL TIKET SELESAI</span>
            <span class="chip-val"><?php echo number_format($total_complete_all); ?></span>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
    <div class="stat-chip">
        <div class="chip-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);">
            <i class="material-icons">trending_up</i>
        </div>
        <div class="chip-info">
            <span class="chip-label">TINGKAT PENYELESAIAN</span>
            <span class="chip-val"><?php echo $avg_completion_rate; ?>%</span>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
    <div class="stat-chip">
        <div class="chip-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <i class="material-icons">people</i>
        </div>
        <div class="chip-info">
            <span class="chip-label">PETUGAS IT TERLIBAT</span>
            <span class="chip-val"><?php echo $total_petugas_aktif; ?> <span style="font-size: 13px; font-weight: 600; opacity: 0.85;">Personil</span></span>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- ROW 1: GRAFIK KINERJA & DISTRIBUSI PETUGAS IT            -->
<!-- ======================================================== -->
<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>KINERJA & JUMLAH PENANGANAN TIKET PER PETUGAS IT</h2>
            <small>Perbandingan tiket selesai vs dalam proses per personil IT (<?php echo $nama_bulan_filter; ?>)</small>
        </div>
        <div class="body" style="position: relative; height: 340px;">
            <canvas id="chart_petugas_bar"></canvas>
        </div>
    </div>
</div>

<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>DISTRIBUSI BEBAN KERJA</h2>
            <small>Persentase porsi pengerjaan tiket antar petugas IT</small>
        </div>
        <div class="body" style="position: relative; height: 340px;">
            <canvas id="chart_petugas_doughnut"></canvas>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- ROW 2: TABEL DETAIL & LEADERBOARD PETUGAS IT             -->
<!-- ======================================================== -->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="header">
            <h2>LEADERBOARD & DETAIL PERFORMA PETUGAS IT</h2>
            <small>Ringkasan produktivitas dan status tiket yang ditangani</small>
        </div>
        <div class="body" style="padding: 0;">
            <div class="leaderboard-wrapper">
                <table class="table table-hover table-leaderboard">
                    <thead>
                        <tr>
                            <th style="width: 7%; text-align: center;">No.</th>
                            <th style="width: 36%;">Nama Petugas IT</th>
                            <th style="width: 15%; text-align: center;">Total Ditangani</th>
                            <th style="width: 13%; text-align: center;">Selesai</th>
                            <th style="width: 13%; text-align: center;">In Progress</th>
                            <th style="width: 16%; text-align: right; padding-right: 22px !important;">Penyelesaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($petugas_list)) {
                            $avatarGradients = [
                                'linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%)',
                                'linear-gradient(135deg, #10b981 0%, #047857 100%)',
                                'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)',
                                'linear-gradient(135deg, #f59e0b 0%, #b45309 100%)',
                                'linear-gradient(135deg, #ec4899 0%, #be185d 100%)',
                                'linear-gradient(135deg, #06b6d4 0%, #0e7490 100%)',
                                'linear-gradient(135deg, #6366f1 0%, #4338ca 100%)',
                                'linear-gradient(135deg, #14b8a6 0%, #0f766e 100%)',
                                'linear-gradient(135deg, #f43f5e 0%, #be123c 100%)',
                                'linear-gradient(135deg, #64748b 0%, #334155 100%)'
                            ];

                            $rank = 0;
                            foreach ($petugas_list as $pet) {
                                $rank++;
                                $rankClass = ($rank == 1) ? 'rank-1' : (($rank == 2) ? 'rank-2' : (($rank == 3) ? 'rank-3' : 'rank-other'));
                                $bgAvatar = $avatarGradients[($rank - 1) % count($avatarGradients)];
                        ?>
                                <tr>
                                    <td align="center" style="text-align: center;">
                                        <span class="rank-pill <?php echo $rankClass; ?>"><?php echo $rank; ?></span>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <span class="petugas-avatar-badge" style="background: <?php echo $bgAvatar; ?>;">
                                                <?php echo $pet['initials']; ?>
                                            </span>
                                            <div>
                                                <div class="petugas-name"><?php echo $pet['nama']; ?></div>
                                                <div style="margin-top: 3px; display: flex; align-items: center; gap: 4px;">
                                                    <span class="mini-tag mini-tag-trouble">Trouble: <?php echo $pet['trouble']; ?></span>
                                                    <span class="mini-tag mini-tag-request">Request: <?php echo $pet['request']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td align="center" style="text-align: center;">
                                        <span class="total-val"><?php echo number_format($pet['total']); ?></span>
                                    </td>
                                    <td align="center" style="text-align: center;">
                                        <span class="label bg-green" style="font-size: 11.5px; padding: 4px 10px; border-radius: 6px; font-weight: 700;">
                                            <?php echo number_format($pet['complete']); ?>
                                        </span>
                                    </td>
                                    <td align="center" style="text-align: center;">
                                        <?php if ($pet['progress'] > 0) { ?>
                                            <span class="label bg-blue" style="font-size: 11.5px; padding: 4px 10px; border-radius: 6px; font-weight: 700;">
                                                <?php echo number_format($pet['progress']); ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class="badge-empty">&mdash;</span>
                                        <?php } ?>
                                    </td>
                                    <td align="right" style="padding-right: 22px !important;">
                                        <div class="prog-box pull-right">
                                            <div class="prog-header">
                                                <span>Progress</span>
                                                <span><strong><?php echo $pet['rate']; ?>%</strong></span>
                                            </div>
                                            <div class="prog-track">
                                                <div class="prog-fill" style="width: <?php echo $pet['rate']; ?>%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" align="center" style="padding: 36px 15px !important; color: #94a3b8;">
                                    <i class="material-icons" style="font-size: 40px; opacity: 0.4; display: block; margin-bottom: 8px;">person_outline</i>
                                    Belum ada data penanganan tiket oleh petugas pada periode ini.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- ROW 3: TREN GANGGUAN HARIAN & KATEGORI                   -->
<!-- ======================================================== -->
<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>TREN GANGGUAN HARIAN (<?php echo $nama_bulan_filter; ?>)</h2>
        </div>
        <div class="body" style="position: relative; height: 320px;">
            <canvas id="line_chart"></canvas>
        </div>
    </div>
</div>

<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>TOTAL PER KATEGORI (<?php echo $nama_bulan_filter; ?>)</h2>
        </div>
        <div class="body" style="position: relative; height: 320px;">
            <canvas id="bar_chart"></canvas>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- JAVASCRIPT INITIALIZATION & DYNAMIC THEME ENGINE         -->
<!-- ======================================================== -->
<script type="text/javascript">
    var chartInstances = {
        line: null,
        barKategori: null,
        barPetugas: null,
        doughnutPetugas: null
    };

    function isDarkModeActive() {
        return document.documentElement.classList.contains('dark-mode') ||
            document.body.classList.contains('dark-mode');
    }

    function getThemePalette() {
        var isDark = isDarkModeActive();
        return {
            isDark: isDark,
            textPrimary: isDark ? '#f8fafc' : '#1e293b',
            textSecondary: isDark ? '#94a3b8' : '#64748b',
            legendText: isDark ? '#cbd5e1' : '#475569',
            gridLine: isDark ? 'rgba(255, 255, 255, 0.07)' : 'rgba(0, 0, 0, 0.05)',
            zeroLine: isDark ? 'rgba(255, 255, 255, 0.15)' : 'rgba(0, 0, 0, 0.12)',
            doughnutBorder: isDark ? '#111c38' : '#ffffff',
            pointBg: isDark ? '#111c38' : '#ffffff',
            tooltipBg: 'rgba(15, 23, 42, 0.95)'
        };
    }

    function initAllCharts() {
        if (typeof Chart === 'undefined') return;

        var theme = getThemePalette();

        // 1. Line Chart: Tren Gangguan Harian
        var lineElem = document.getElementById("line_chart");
        if (lineElem && !chartInstances.line) {
            chartInstances.line = new Chart(lineElem.getContext("2d"), getLineChartConfig(theme));
        }

        // 2. Bar Chart: Total per Kategori
        var barElem = document.getElementById("bar_chart");
        if (barElem && !chartInstances.barKategori) {
            chartInstances.barKategori = new Chart(barElem.getContext("2d"), getBarChartConfig(theme));
        }

        // 3. Bar Chart: Kinerja Petugas IT
        var petugasBarElem = document.getElementById("chart_petugas_bar");
        if (petugasBarElem && !chartInstances.barPetugas) {
            chartInstances.barPetugas = new Chart(petugasBarElem.getContext("2d"), getPetugasBarChartConfig(theme));
        }

        // 4. Doughnut Chart: Distribusi Beban Kerja Petugas
        var petugasDoughnutElem = document.getElementById("chart_petugas_doughnut");
        if (petugasDoughnutElem && !chartInstances.doughnutPetugas) {
            chartInstances.doughnutPetugas = new Chart(petugasDoughnutElem.getContext("2d"), getPetugasDoughnutChartConfig(theme));
        }
    }

    function updateChartsTheme() {
        if (typeof Chart === 'undefined') return;
        var theme = getThemePalette();

        // Update Line Chart
        if (chartInstances.line) {
            chartInstances.line.options.legend.labels.fontColor = theme.legendText;
            chartInstances.line.options.scales.xAxes[0].ticks.fontColor = theme.textSecondary;
            chartInstances.line.options.scales.yAxes[0].ticks.fontColor = theme.textSecondary;
            chartInstances.line.options.scales.yAxes[0].gridLines.color = theme.gridLine;
            chartInstances.line.data.datasets.forEach(function(ds) {
                ds.pointBackgroundColor = theme.pointBg;
            });
            chartInstances.line.update();
        }

        // Update Bar Kategori Chart
        if (chartInstances.barKategori) {
            chartInstances.barKategori.options.scales.xAxes[0].ticks.fontColor = theme.textSecondary;
            chartInstances.barKategori.options.scales.yAxes[0].ticks.fontColor = theme.textSecondary;
            chartInstances.barKategori.options.scales.yAxes[0].gridLines.color = theme.gridLine;
            chartInstances.barKategori.update();
        }

        // Update Bar Petugas Chart
        if (chartInstances.barPetugas) {
            chartInstances.barPetugas.options.legend.labels.fontColor = theme.legendText;
            chartInstances.barPetugas.options.scales.xAxes[0].ticks.fontColor = theme.textSecondary;
            chartInstances.barPetugas.options.scales.yAxes[0].ticks.fontColor = theme.textSecondary;
            chartInstances.barPetugas.options.scales.yAxes[0].gridLines.color = theme.gridLine;
            chartInstances.barPetugas.update();
        }

        // Update Doughnut Petugas Chart
        if (chartInstances.doughnutPetugas) {
            chartInstances.doughnutPetugas.options.legend.labels.fontColor = theme.legendText;
            chartInstances.doughnutPetugas.data.datasets[0].borderColor = theme.doughnutBorder;
            chartInstances.doughnutPetugas.update();
        }
    }

    // Config 1: Line Chart Tren Gangguan
    function getLineChartConfig(theme) {
        return {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: "SOFTWARE",
                    data: <?php echo json_encode($software); ?>,
                    borderColor: 'rgba(56, 189, 248, 1)',
                    backgroundColor: 'rgba(56, 189, 248, 0.16)',
                    pointBorderColor: 'rgba(56, 189, 248, 1)',
                    pointBackgroundColor: theme.pointBg,
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointHitRadius: 15,
                    lineTension: 0.3,
                    fill: true
                }, {
                    label: "HARDWARE",
                    data: <?php echo json_encode($hardware); ?>,
                    borderColor: 'rgba(244, 63, 94, 1)',
                    backgroundColor: 'rgba(244, 63, 94, 0.16)',
                    pointBorderColor: 'rgba(244, 63, 94, 1)',
                    pointBackgroundColor: theme.pointBg,
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointHitRadius: 15,
                    lineTension: 0.3,
                    fill: true
                }, {
                    label: "NETWORK",
                    data: <?php echo json_encode($network); ?>,
                    borderColor: 'rgba(245, 158, 11, 1)',
                    backgroundColor: 'rgba(245, 158, 11, 0.16)',
                    pointBorderColor: 'rgba(245, 158, 11, 1)',
                    pointBackgroundColor: theme.pointBg,
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointHitRadius: 15,
                    lineTension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 14,
                        fontColor: theme.legendText,
                        fontFamily: "'Segoe UI', Roboto, sans-serif",
                        fontSize: 11.5,
                        padding: 12
                    }
                },
                hover: {
                    mode: 'single',
                    animationDuration: 150
                },
                tooltips: {
                    enabled: true,
                    mode: 'single',
                    backgroundColor: theme.tooltipBg,
                    titleFontColor: '#ffffff',
                    bodyFontColor: '#ffffff',
                    titleFontSize: 12.5,
                    bodyFontSize: 12,
                    cornerRadius: 8,
                    xPadding: 12,
                    yPadding: 10
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            fontColor: theme.textSecondary,
                            fontSize: 11
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: theme.textSecondary,
                            fontSize: 11
                        },
                        gridLines: {
                            color: theme.gridLine,
                            drawBorder: false
                        }
                    }]
                }
            }
        };
    }

    // Config 2: Bar Chart Kategori
    function getBarChartConfig(theme) {
        return {
            type: 'bar',
            data: {
                labels: ["Software", "Hardware", "Network", "Komunikasi", "Security", "Other"],
                datasets: [{
                    label: "Jumlah Tiket",
                    data: [<?php echo "$tot_software, $tot_hardware, $tot_network, $tot_komunikasi, $tot_security, $tot_other"; ?>],
                    backgroundColor: [
                        'rgba(56, 189, 248, 0.85)',
                        'rgba(244, 63, 94, 0.85)',
                        'rgba(245, 158, 11, 0.85)',
                        'rgba(20, 184, 166, 0.85)',
                        'rgba(168, 85, 247, 0.85)',
                        'rgba(100, 116, 139, 0.85)'
                    ],
                    borderColor: [
                        'rgba(56, 189, 248, 1)',
                        'rgba(244, 63, 94, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(20, 184, 166, 1)',
                        'rgba(168, 85, 247, 1)',
                        'rgba(100, 116, 139, 1)'
                    ],
                    borderWidth: 1.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                hover: {
                    mode: 'single',
                    animationDuration: 150
                },
                tooltips: {
                    enabled: true,
                    mode: 'single',
                    backgroundColor: theme.tooltipBg,
                    titleFontColor: '#ffffff',
                    bodyFontColor: '#ffffff',
                    titleFontSize: 12.5,
                    bodyFontSize: 12,
                    cornerRadius: 8,
                    xPadding: 12,
                    yPadding: 10
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            fontColor: theme.textSecondary,
                            fontSize: 11
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: theme.textSecondary,
                            fontSize: 11
                        },
                        gridLines: {
                            color: theme.gridLine,
                            drawBorder: false
                        }
                    }]
                }
            }
        };
    }

    // Config 3: Bar Chart Per Petugas IT
    function getPetugasBarChartConfig(theme) {
        var petugasLabels = <?php echo json_encode($petugas_labels); ?>;
        var petugasComplete = <?php echo json_encode($petugas_complete); ?>;
        var petugasProgress = <?php echo json_encode($petugas_progress); ?>;

        return {
            type: 'bar',
            data: {
                labels: petugasLabels,
                datasets: [{
                        label: "Tiket Selesai (Complete)",
                        data: petugasComplete,
                        backgroundColor: 'rgba(16, 185, 129, 0.85)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1.5
                    },
                    {
                        label: "Dalam Pengerjaan (In Progress)",
                        data: petugasProgress,
                        backgroundColor: 'rgba(14, 165, 233, 0.85)',
                        borderColor: 'rgba(14, 165, 233, 1)',
                        borderWidth: 1.5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 14,
                        fontColor: theme.legendText,
                        fontFamily: "'Segoe UI', Roboto, sans-serif",
                        fontSize: 11.5,
                        padding: 14
                    }
                },
                hover: {
                    mode: 'single',
                    animationDuration: 150
                },
                tooltips: {
                    enabled: true,
                    mode: 'single',
                    backgroundColor: theme.tooltipBg,
                    titleFontColor: '#ffffff',
                    bodyFontColor: '#ffffff',
                    titleFontSize: 13,
                    bodyFontSize: 12,
                    cornerRadius: 8,
                    xPadding: 12,
                    yPadding: 10
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            fontColor: theme.textSecondary,
                            fontSize: 11,
                            autoSkip: false,
                            maxRotation: 20,
                            minRotation: 0
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 5,
                            fontColor: theme.textSecondary,
                            fontSize: 11
                        },
                        gridLines: {
                            color: theme.gridLine,
                            drawBorder: false
                        }
                    }]
                }
            }
        };
    }

    // Config 4: Doughnut Chart Distribusi Petugas
    function getPetugasDoughnutChartConfig(theme) {
        var petugasLabels = <?php echo json_encode($petugas_labels); ?>;
        var petugasTotal = <?php echo json_encode($petugas_total); ?>;

        var vibrantPalette = [
            '#0ea5e9', '#10b981', '#f59e0b', '#ec4899',
            '#8b5cf6', '#06b6d4', '#f43f5e', '#6366f1',
            '#14b8a6', '#64748b', '#d946ef', '#84cc16'
        ];

        return {
            type: 'doughnut',
            data: {
                labels: petugasLabels,
                datasets: [{
                    data: petugasTotal,
                    backgroundColor: vibrantPalette.slice(0, petugasLabels.length),
                    borderColor: theme.doughnutBorder,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 62,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        fontColor: theme.legendText,
                        fontFamily: "'Segoe UI', Roboto, sans-serif",
                        fontSize: 11,
                        padding: 8
                    }
                },
                hover: {
                    mode: 'single',
                    animationDuration: 150
                },
                tooltips: {
                    enabled: true,
                    mode: 'single',
                    backgroundColor: theme.tooltipBg,
                    titleFontColor: '#ffffff',
                    bodyFontColor: '#ffffff',
                    titleFontSize: 13,
                    bodyFontSize: 12,
                    cornerRadius: 8,
                    xPadding: 12,
                    yPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function(previousValue, currentValue) {
                                return previousValue + currentValue;
                            }, 0);
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            return data.labels[tooltipItem.index] + ': ' + currentValue + ' Tiket (' + percentage + '%)';
                        }
                    }
                }
            }
        };
    }

    // Observer untuk Real-time Dark Mode Toggle
    var themeObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                updateChartsTheme();
            }
        });
    });
    themeObserver.observe(document.documentElement, {
        attributes: true
    });
    themeObserver.observe(document.body, {
        attributes: true
    });

    // Inisialisasi otomatis
    if (document.readyState === 'complete') {
        initAllCharts();
    } else {
        window.addEventListener('load', initAllCharts);
        document.addEventListener('DOMContentLoaded', initAllCharts);
    }
</script>