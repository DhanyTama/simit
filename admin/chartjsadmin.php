<?php
if (!isset($connect)) {
    include "../conn.php";
}
date_default_timezone_set('Asia/Jakarta');
$tanggal_hari_ini = date("Y-m-d");

// 1. Tiket Open (Belum ditangani)
$q_open = mysqli_query($connect, "SELECT COUNT(*) as total FROM pengunjung WHERE status='Open'");
$d_open = mysqli_fetch_assoc($q_open);
$total_open = isset($d_open['total']) ? (int)$d_open['total'] : 0;

// 2. Tiket In Progress (Sedang dikerjakan)
$q_progress = mysqli_query($connect, "SELECT COUNT(*) as total FROM pengunjung WHERE status='In Progress'");
$d_progress = mysqli_fetch_assoc($q_progress);
$total_progress = isset($d_progress['total']) ? (int)$d_progress['total'] : 0;

// 3. Tiket Selesai Hari Ini
$q_complete_today = mysqli_query($connect, "SELECT COUNT(*) as total FROM pengunjung WHERE (status='Complete' OR status='Selesai' OR status='Completed') AND (tglselesai='$tanggal_hari_ini' OR tgllapor='$tanggal_hari_ini')");
$d_complete_today = mysqli_fetch_assoc($q_complete_today);
$total_complete_today = isset($d_complete_today['total']) ? (int)$d_complete_today['total'] : 0;

// 4. Total Tiket Hari Ini
$q_today = mysqli_query($connect, "SELECT COUNT(*) as total FROM pengunjung WHERE tgllapor='$tanggal_hari_ini'");
$d_today = mysqli_fetch_assoc($q_today);
$total_today = isset($d_today['total']) ? (int)$d_today['total'] : 0;
?>

<style>
    /* Modern Dashboard Stat Cards */
    .info-box {
        border-radius: 18px !important;
        border: none !important;
        overflow: hidden !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08) !important;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        display: flex !important;
        align-items: center !important;
        padding: 12px 16px !important;
        height: auto !important;
        min-height: 94px !important;
        margin-bottom: 24px !important;
        position: relative !important;
        color: #ffffff !important;
        cursor: pointer !important;
    }

    .info-box:hover {
        transform: translateY(-4px) !important;
    }

    /* Ambient circular subtle glow */
    .info-box::after {
        content: '' !important;
        position: absolute !important;
        right: -15px !important;
        bottom: -20px !important;
        left: auto !important;
        top: auto !important;
        width: 85px !important;
        height: 85px !important;
        border-radius: 50% !important;
        background: rgba(255, 255, 255, 0.14) !important;
        pointer-events: none !important;
        transition: transform 0.3s ease, background 0.3s ease !important;
    }

    .info-box:hover::after {
        transform: scale(1.15) !important;
        background: rgba(255, 255, 255, 0.22) !important;
    }

    /* Disable old AdminBSB ugly dark expanding bar */
    .info-box.hover-expand-effect:after,
    .info-box.hover-expand-effect:hover:after {
        display: none !important;
        width: 0 !important;
        content: none !important;
    }

    /* Soft Rounded Frosted Glass Icon Badge - Unified across all skins */
    html .info-box .icon,
    body .info-box .icon,
    .info-box .icon {
        width: 48px !important;
        height: 48px !important;
        min-width: 48px !important;
        border-radius: 14px !important;
        background: rgba(255, 255, 255, 0.22) !important;
        background-color: rgba(255, 255, 255, 0.22) !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin-right: 14px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.28) !important;
        transition: transform 0.25s ease, background 0.25s ease !important;
    }

    html .info-box:hover .icon,
    body .info-box:hover .icon,
    .info-box:hover .icon {
        transform: scale(1.08) !important;
        background: rgba(255, 255, 255, 0.32) !important;
        background-color: rgba(255, 255, 255, 0.32) !important;
    }

    .info-box .icon i.material-icons,
    .info-box .icon i {
        font-size: 24px !important;
        line-height: 1 !important;
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15) !important;
    }

    /* Content & Typography */
    .info-box .content {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        padding: 0 !important;
        overflow: visible !important;
    }

    .info-box .content .text {
        font-size: 11px !important;
        font-weight: 700 !important;
        letter-spacing: 0.3px !important;
        text-transform: uppercase !important;
        color: rgba(255, 255, 255, 0.95) !important;
        margin: 0 0 3px 0 !important;
        line-height: 1.25 !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: unset !important;
    }

    .info-box .content .number {
        font-size: 26px !important;
        font-weight: 800 !important;
        line-height: 1.1 !important;
        color: #ffffff !important;
        margin: 0 !important;
        letter-spacing: -0.5px !important;
    }

    /* ==========================================================================
       Skin-Tailored Info-Box Gradients & Hover Shadows
       ========================================================================== */

    /* 1. Default Skin (Hospital IT Clean Modern) */
    .info-box.bg-pink {
        background: linear-gradient(135deg, #e11d48 0%, #be123c 100%) !important;
    }
    .info-box.bg-pink:hover {
        box-shadow: 0 12px 28px rgba(225, 29, 72, 0.38) !important;
    }
    .info-box.bg-cyan {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
    }
    .info-box.bg-cyan:hover {
        box-shadow: 0 12px 28px rgba(2, 132, 199, 0.38) !important;
    }
    .info-box.bg-light-green {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
    }
    .info-box.bg-light-green:hover {
        box-shadow: 0 12px 28px rgba(5, 150, 105, 0.38) !important;
    }
    .info-box.bg-orange {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important;
    }
    .info-box.bg-orange:hover {
        box-shadow: 0 12px 28px rgba(217, 119, 6, 0.38) !important;
    }

    /* 2. Cappuccino Skin (Warm Coffee, Terracotta, Roasted Mocha, Matcha Sage, Caramel) */
    html.skin-cappuccino .info-box.bg-pink,
    body.skin-cappuccino .info-box.bg-pink {
        background: linear-gradient(135deg, #b8533b 0%, #87311c 100%) !important;
    }
    html.skin-cappuccino .info-box.bg-pink:hover,
    body.skin-cappuccino .info-box.bg-pink:hover {
        box-shadow: 0 12px 28px rgba(184, 83, 59, 0.40) !important;
    }
    html.skin-cappuccino .info-box.bg-cyan,
    body.skin-cappuccino .info-box.bg-cyan {
        background: linear-gradient(135deg, #7c4c28 0%, #522d13 100%) !important;
    }
    html.skin-cappuccino .info-box.bg-cyan:hover,
    body.skin-cappuccino .info-box.bg-cyan:hover {
        box-shadow: 0 12px 28px rgba(124, 76, 40, 0.40) !important;
    }
    html.skin-cappuccino .info-box.bg-light-green,
    body.skin-cappuccino .info-box.bg-light-green {
        background: linear-gradient(135deg, #5a7d52 0%, #3a5633 100%) !important;
    }
    html.skin-cappuccino .info-box.bg-light-green:hover,
    body.skin-cappuccino .info-box.bg-light-green:hover {
        box-shadow: 0 12px 28px rgba(90, 125, 82, 0.40) !important;
    }
    html.skin-cappuccino .info-box.bg-orange,
    body.skin-cappuccino .info-box.bg-orange {
        background: linear-gradient(135deg, #c47c35 0%, #92531a 100%) !important;
    }
    html.skin-cappuccino .info-box.bg-orange:hover,
    body.skin-cappuccino .info-box.bg-orange:hover {
        box-shadow: 0 12px 28px rgba(196, 124, 53, 0.40) !important;
    }

    /* Cappuccino Dark Mode */
    html.skin-cappuccino.dark-mode .info-box.bg-pink,
    body.skin-cappuccino.dark-mode .info-box.bg-pink {
        background: linear-gradient(135deg, #9b3d27 0%, #682110 100%) !important;
    }
    html.skin-cappuccino.dark-mode .info-box.bg-cyan,
    body.skin-cappuccino.dark-mode .info-box.bg-cyan {
        background: linear-gradient(135deg, #673b1d 0%, #3d1c08 100%) !important;
    }
    html.skin-cappuccino.dark-mode .info-box.bg-light-green,
    body.skin-cappuccino.dark-mode .info-box.bg-light-green {
        background: linear-gradient(135deg, #486841 0%, #2b4125 100%) !important;
    }
    html.skin-cappuccino.dark-mode .info-box.bg-orange,
    body.skin-cappuccino.dark-mode .info-box.bg-orange {
        background: linear-gradient(135deg, #a66528 0%, #703f11 100%) !important;
    }

    /* 3. Everforest Skin (Autumn Terracotta, River Teal, Forest Moss Sage, Amber Cedar) */
    html.skin-everforest .info-box.bg-pink,
    body.skin-everforest .info-box.bg-pink {
        background: linear-gradient(135deg, #bd5654 0%, #8c3634 100%) !important;
    }
    html.skin-everforest .info-box.bg-pink:hover,
    body.skin-everforest .info-box.bg-pink:hover {
        box-shadow: 0 12px 28px rgba(189, 86, 84, 0.40) !important;
    }
    html.skin-everforest .info-box.bg-cyan,
    body.skin-everforest .info-box.bg-cyan {
        background: linear-gradient(135deg, #3d7972 0%, #23524c 100%) !important;
    }
    html.skin-everforest .info-box.bg-cyan:hover,
    body.skin-everforest .info-box.bg-cyan:hover {
        box-shadow: 0 12px 28px rgba(61, 121, 114, 0.40) !important;
    }
    html.skin-everforest .info-box.bg-light-green,
    body.skin-everforest .info-box.bg-light-green {
        background: linear-gradient(135deg, #5b8c53 0%, #3a6333 100%) !important;
    }
    html.skin-everforest .info-box.bg-light-green:hover,
    body.skin-everforest .info-box.bg-light-green:hover {
        box-shadow: 0 12px 28px rgba(91, 140, 83, 0.40) !important;
    }
    html.skin-everforest .info-box.bg-orange,
    body.skin-everforest .info-box.bg-orange {
        background: linear-gradient(135deg, #b88636 0%, #875c1b 100%) !important;
    }
    html.skin-everforest .info-box.bg-orange:hover,
    body.skin-everforest .info-box.bg-orange:hover {
        box-shadow: 0 12px 28px rgba(184, 134, 54, 0.40) !important;
    }

    /* Everforest Dark Mode */
    html.skin-everforest.dark-mode .info-box.bg-pink,
    body.skin-everforest.dark-mode .info-box.bg-pink {
        background: linear-gradient(135deg, #9d3e3c 0%, #6a2120 100%) !important;
    }
    html.skin-everforest.dark-mode .info-box.bg-cyan,
    body.skin-everforest.dark-mode .info-box.bg-cyan {
        background: linear-gradient(135deg, #2c5e57 0%, #173b36 100%) !important;
    }
    html.skin-everforest.dark-mode .info-box.bg-light-green,
    body.skin-everforest.dark-mode .info-box.bg-light-green {
        background: linear-gradient(135deg, #46703e 0%, #294723 100%) !important;
    }
    html.skin-everforest.dark-mode .info-box.bg-orange,
    body.skin-everforest.dark-mode .info-box.bg-orange {
        background: linear-gradient(135deg, #946924 0%, #61410f 100%) !important;
    }

    /* 4. Tokyo Night Skin (Shibuya Rose, Twilight Violet, Cyber Teal, Neon Purple) */
    html.skin-tokyo .info-box.bg-pink,
    body.skin-tokyo .info-box.bg-pink {
        background: linear-gradient(135deg, #dc3d65 0%, #a01a3e 100%) !important;
    }
    html.skin-tokyo .info-box.bg-pink:hover,
    body.skin-tokyo .info-box.bg-pink:hover {
        box-shadow: 0 12px 28px rgba(220, 61, 101, 0.40) !important;
    }
    html.skin-tokyo .info-box.bg-cyan,
    body.skin-tokyo .info-box.bg-cyan {
        background: linear-gradient(135deg, #6449b1 0%, #3e2886 100%) !important;
    }
    html.skin-tokyo .info-box.bg-cyan:hover,
    body.skin-tokyo .info-box.bg-cyan:hover {
        box-shadow: 0 12px 28px rgba(100, 73, 177, 0.40) !important;
    }
    html.skin-tokyo .info-box.bg-light-green,
    body.skin-tokyo .info-box.bg-light-green {
        background: linear-gradient(135deg, #159ba8 0%, #09636e 100%) !important;
    }
    html.skin-tokyo .info-box.bg-light-green:hover,
    body.skin-tokyo .info-box.bg-light-green:hover {
        box-shadow: 0 12px 28px rgba(21, 155, 168, 0.40) !important;
    }
    html.skin-tokyo .info-box.bg-orange,
    body.skin-tokyo .info-box.bg-orange {
        background: linear-gradient(135deg, #8845b5 0%, #592083 100%) !important;
    }
    html.skin-tokyo .info-box.bg-orange:hover,
    body.skin-tokyo .info-box.bg-orange:hover {
        box-shadow: 0 12px 28px rgba(136, 69, 181, 0.40) !important;
    }

    /* 5. Point Blank Skin (Tactical Crimson Red, Deep Cobalt Navy, Stealth Cyan, Weapon Amber) */
    html.skin-pb .info-box.bg-pink,
    body.skin-pb .info-box.bg-pink {
        background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;
    }
    html.skin-pb .info-box.bg-pink:hover,
    body.skin-pb .info-box.bg-pink:hover {
        box-shadow: 0 12px 28px rgba(220, 38, 38, 0.40) !important;
    }
    html.skin-pb .info-box.bg-cyan,
    body.skin-pb .info-box.bg-cyan {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%) !important;
    }
    html.skin-pb .info-box.bg-cyan:hover,
    body.skin-pb .info-box.bg-cyan:hover {
        box-shadow: 0 12px 28px rgba(29, 78, 216, 0.40) !important;
    }
    html.skin-pb .info-box.bg-light-green,
    body.skin-pb .info-box.bg-light-green {
        background: linear-gradient(135deg, #0284c7 0%, #075985 100%) !important;
    }
    html.skin-pb .info-box.bg-light-green:hover,
    body.skin-pb .info-box.bg-light-green:hover {
        box-shadow: 0 12px 28px rgba(2, 132, 199, 0.40) !important;
    }
    html.skin-pb .info-box.bg-orange,
    body.skin-pb .info-box.bg-orange {
        background: linear-gradient(135deg, #d97706 0%, #92400e 100%) !important;
    }
    html.skin-pb .info-box.bg-orange:hover,
    body.skin-pb .info-box.bg-orange:hover {
        box-shadow: 0 12px 28px rgba(217, 119, 6, 0.40) !important;
    }

    /* Modern Card Layout */
    .card {
        border-radius: 18px !important;
        border: none !important;
        overflow: hidden !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06) !important;
        margin-bottom: 25px !important;
        transition: background-color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease !important;
    }

    body:not(.dark-mode) .card {
        background: #ffffff !important;
    }

    .card .header {
        border-top-left-radius: 18px !important;
        border-top-right-radius: 18px !important;
        padding: 18px 24px 14px 24px !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06) !important;
    }

    .card .header h2 {
        font-size: 15px !important;
        font-weight: 700 !important;
        letter-spacing: 0.3px !important;
        margin: 0 !important;
    }

    /* Skin specific card header text color */
    html.skin-cappuccino:not(.dark-mode) .card .header h2 { color: #583722 !important; }
    html.skin-everforest:not(.dark-mode) .card .header h2 { color: #344438 !important; }
    html.skin-tokyo:not(.dark-mode) .card .header h2 { color: #2e3440 !important; }
    html.skin-pb:not(.dark-mode) .card .header h2 { color: #0f172a !important; }
    html.skin-default:not(.dark-mode) .card .header h2,
    body:not(.dark-mode) .card .header h2 { color: #1e293b !important; }

    .dark-mode .card .header h2 { color: #f8fafc !important; }
    html.skin-cappuccino.dark-mode .card .header h2 { color: #dfd4cb !important; }
    html.skin-everforest.dark-mode .card .header h2 { color: #d3c6aa !important; }
    html.skin-tokyo.dark-mode .card .header h2 { color: #c0caf5 !important; }
    html.skin-pb.dark-mode .card .header h2 { color: #f1f5f9 !important; }
</style>

<!-- Widgets -->
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-pink">
        <div class="icon">
            <i class="material-icons">report_problem</i>
        </div>
        <div class="content">
            <div class="text" title="TIKET OPEN">TIKET OPEN</div>
            <div class="number count-to" data-from="0" data-to="<?php echo $total_open; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_open; ?></div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-cyan">
        <div class="icon">
            <i class="material-icons">hourglass_empty</i>
        </div>
        <div class="content">
            <div class="text" title="IN PROGRESS">IN PROGRESS</div>
            <div class="number count-to" data-from="0" data-to="<?php echo $total_progress; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_progress; ?></div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-light-green">
        <div class="icon">
            <i class="material-icons">check_circle</i>
        </div>
        <div class="content">
            <div class="text" title="SELESAI HARI INI">SELESAI HARI INI</div>
            <div class="number count-to" data-from="0" data-to="<?php echo $total_complete_today; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_complete_today; ?></div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-orange">
        <div class="icon">
            <i class="material-icons">today</i>
        </div>
        <div class="content">
            <div class="text" title="TOTAL TIKET HARI INI">TOTAL TIKET HARI INI</div>
            <div class="number count-to" data-from="0" data-to="<?php echo $total_today; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_today; ?></div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="header">
            <h2>GRAFIK MRT-IT THIS MONTH (<?php echo date('F Y'); ?>)</h2>
            <ul class="header-dropdown m-r--5">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="index.php?page=chartjs">Grafik Detail</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body" style="position: relative; height: 320px;">
            <canvas id="line_chart"></canvas>
        </div>
    </div>
</div>

<?php
$tgl = date('Y-m');
$chart_labels = [];
$chart_software = [];
$chart_hardware = [];
$chart_network = [];

$query_chart = mysqli_query($connect, "SELECT tanggal, SOFTWARE, HARDWARE, NETWORK FROM tb_grafik_jnstrouble WHERE tanggal LIKE '%$tgl%' ORDER BY tanggal ASC");
if ($query_chart) {
    while ($p = mysqli_fetch_assoc($query_chart)) {
        $chart_labels[] = date('d M', strtotime($p['tanggal']));
        $chart_software[] = (int)$p['SOFTWARE'];
        $chart_hardware[] = (int)$p['HARDWARE'];
        $chart_network[] = (int)$p['NETWORK'];
    }
}
?>

<script type="text/javascript">
var dashboardLineChartInstance = null;

function isDashboardDarkModeActive() {
    return document.documentElement.classList.contains('dark-mode') ||
        document.body.classList.contains('dark-mode');
}

function getDashboardCurrentSkin() {
    var html = document.documentElement;
    var body = document.body;
    if (html.classList.contains('skin-cappuccino') || body.classList.contains('skin-cappuccino')) return 'cappuccino';
    if (html.classList.contains('skin-everforest') || body.classList.contains('skin-everforest')) return 'everforest';
    if (html.classList.contains('skin-tokyo') || body.classList.contains('skin-tokyo')) return 'tokyo';
    if (html.classList.contains('skin-pb') || body.classList.contains('skin-pb')) return 'pb';
    var stored = localStorage.getItem('simit_skin');
    if (stored) return stored;
    var m = document.cookie.match(/(?:^|;\s*)simit_skin=([^;]*)/);
    return m ? m[1] : 'default';
}

function getDashboardThemePalette() {
    var isDark = isDashboardDarkModeActive();
    var skin = getDashboardCurrentSkin();

    var cardBg = '#ffffff';
    var textSec = '#64748b';
    var legend = '#334155';
    var tooltip = 'rgba(15, 23, 42, 0.90)';

    // Dataset skin colors
    var dsColors = {
        cappuccino: {
            software: { border: isDark ? '#d49b5c' : '#c68642', bg: isDark ? 'rgba(212, 155, 92, 0.20)' : 'rgba(198, 134, 66, 0.16)' },
            hardware: { border: isDark ? '#c9654d' : '#b8533b', bg: isDark ? 'rgba(201, 101, 77, 0.20)' : 'rgba(184, 83, 59, 0.16)' },
            network:  { border: isDark ? '#ab744b' : '#7c4c28', bg: isDark ? 'rgba(171, 116, 75, 0.20)' : 'rgba(124, 76, 40, 0.16)' }
        },
        everforest: {
            software: { border: isDark ? '#75aa6d' : '#5b8c53', bg: isDark ? 'rgba(117, 170, 109, 0.20)' : 'rgba(91, 140, 83, 0.16)' },
            hardware: { border: isDark ? '#d46e6c' : '#bd5654', bg: isDark ? 'rgba(212, 110, 108, 0.20)' : 'rgba(189, 86, 84, 0.16)' },
            network:  { border: isDark ? '#cf9d48' : '#b88636', bg: isDark ? 'rgba(207, 157, 72, 0.20)' : 'rgba(184, 134, 54, 0.16)' }
        },
        tokyo: {
            software: { border: '#7aa2f7', bg: isDark ? 'rgba(122, 162, 247, 0.22)' : 'rgba(122, 162, 247, 0.16)' },
            hardware: { border: '#f7768e', bg: isDark ? 'rgba(247, 118, 142, 0.22)' : 'rgba(247, 118, 142, 0.16)' },
            network:  { border: '#bb9af7', bg: isDark ? 'rgba(187, 154, 247, 0.22)' : 'rgba(187, 154, 247, 0.16)' }
        },
        pb: {
            software: { border: isDark ? '#38bdf8' : '#0284c7', bg: isDark ? 'rgba(56, 189, 248, 0.22)' : 'rgba(2, 132, 199, 0.16)' },
            hardware: { border: isDark ? '#f87171' : '#dc2626', bg: isDark ? 'rgba(248, 113, 113, 0.22)' : 'rgba(220, 38, 38, 0.16)' },
            network:  { border: isDark ? '#fbbf24' : '#d97706', bg: isDark ? 'rgba(251, 191, 36, 0.22)' : 'rgba(217, 119, 6, 0.16)' }
        },
        default: {
            software: { border: '#0284c7', bg: isDark ? 'rgba(2, 132, 199, 0.22)' : 'rgba(2, 132, 199, 0.16)' },
            hardware: { border: '#e11d48', bg: isDark ? 'rgba(225, 29, 72, 0.22)' : 'rgba(225, 29, 72, 0.16)' },
            network:  { border: '#d97706', bg: isDark ? 'rgba(217, 119, 6, 0.22)' : 'rgba(217, 119, 6, 0.16)' }
        }
    };

    if (isDark) {
        if (skin === 'cappuccino') {
            cardBg = '#241b16';
            textSec = '#bfa594';
            legend = '#dfd4cb';
            tooltip = 'rgba(36, 27, 22, 0.96)';
        } else if (skin === 'everforest') {
            cardBg = '#272e33';
            textSec = '#9da9a0';
            legend = '#d3c6aa';
            tooltip = 'rgba(39, 46, 51, 0.96)';
        } else if (skin === 'tokyo') {
            cardBg = '#1a1b26';
            textSec = '#9aa5ce';
            legend = '#c0caf5';
            tooltip = 'rgba(26, 27, 38, 0.96)';
        } else if (skin === 'pb') {
            cardBg = '#111726';
            textSec = '#78909c';
            legend = '#cbd5e1';
            tooltip = 'rgba(17, 23, 38, 0.96)';
        } else {
            cardBg = '#111c38';
            textSec = '#94a3b8';
            legend = '#cbd5e1';
            tooltip = 'rgba(15, 23, 42, 0.95)';
        }
    } else {
        if (skin === 'cappuccino') {
            textSec = '#8d7564';
            legend = '#583722';
            tooltip = 'rgba(56, 38, 26, 0.92)';
        } else if (skin === 'everforest') {
            textSec = '#67756b';
            legend = '#344438';
            tooltip = 'rgba(40, 52, 44, 0.92)';
        } else if (skin === 'tokyo') {
            textSec = '#565f89';
            legend = '#2e3440';
            tooltip = 'rgba(30, 32, 48, 0.92)';
        } else if (skin === 'pb') {
            textSec = '#475569';
            legend = '#0f172a';
            tooltip = 'rgba(15, 23, 42, 0.92)';
        }
    }

    var currentDs = dsColors[skin] || dsColors['default'];

    return {
        isDark: isDark,
        skin: skin,
        textPrimary: isDark ? '#f8fafc' : '#1e293b',
        textSecondary: textSec,
        legendText: legend,
        gridLine: isDark ? 'rgba(255, 255, 255, 0.07)' : 'rgba(0, 0, 0, 0.06)',
        zeroLine: isDark ? 'rgba(255, 255, 255, 0.15)' : 'rgba(0, 0, 0, 0.12)',
        pointBg: isDark ? cardBg : '#ffffff',
        tooltipBg: tooltip,
        ds: currentDs
    };
}

function initDashboardLineChart() {
    var lineChartElem = document.getElementById("line_chart");
    if (!lineChartElem) return;
    if (typeof Chart === 'undefined') return;
    if (dashboardLineChartInstance) return;

    var theme = getDashboardThemePalette();

    var config = {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: [{
                label: "SOFTWARE",
                data: <?php echo json_encode($chart_software); ?>,
                borderColor: theme.ds.software.border,
                backgroundColor: theme.ds.software.bg,
                pointBorderColor: theme.ds.software.border,
                pointBackgroundColor: theme.pointBg,
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHitRadius: 15,
                pointHoverBackgroundColor: theme.pointBg,
                pointHoverBorderColor: theme.ds.software.border,
                pointHoverBorderWidth: 2,
                lineTension: 0.3,
                fill: true
            }, {
                label: "HARDWARE",
                data: <?php echo json_encode($chart_hardware); ?>,
                borderColor: theme.ds.hardware.border,
                backgroundColor: theme.ds.hardware.bg,
                pointBorderColor: theme.ds.hardware.border,
                pointBackgroundColor: theme.pointBg,
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHitRadius: 15,
                pointHoverBackgroundColor: theme.pointBg,
                pointHoverBorderColor: theme.ds.hardware.border,
                pointHoverBorderWidth: 2,
                lineTension: 0.3,
                fill: true
            }, {
                label: "NETWORK",
                data: <?php echo json_encode($chart_network); ?>,
                borderColor: theme.ds.network.border,
                backgroundColor: theme.ds.network.bg,
                pointBorderColor: theme.ds.network.border,
                pointBackgroundColor: theme.pointBg,
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHitRadius: 15,
                pointHoverBackgroundColor: theme.pointBg,
                pointHoverBorderColor: theme.ds.network.border,
                pointHoverBorderWidth: 2,
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
                    boxWidth: 15,
                    fontColor: theme.legendText,
                    fontFamily: "'Segoe UI', Roboto, sans-serif",
                    fontSize: 12,
                    padding: 15
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
                titleFontFamily: "'Segoe UI', Roboto, sans-serif",
                titleFontSize: 13,
                titleFontStyle: 'bold',
                titleFontColor: '#ffffff',
                bodyFontFamily: "'Segoe UI', Roboto, sans-serif",
                bodyFontSize: 12,
                bodyFontColor: '#ffffff',
                cornerRadius: 8,
                caretSize: 6,
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
                        stepSize: 2,
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

    dashboardLineChartInstance = new Chart(lineChartElem.getContext("2d"), config);
}

function updateDashboardChartTheme() {
    if (!dashboardLineChartInstance) return;
    var theme = getDashboardThemePalette();
    dashboardLineChartInstance.options.legend.labels.fontColor = theme.legendText;
    dashboardLineChartInstance.options.scales.xAxes[0].ticks.fontColor = theme.textSecondary;
    dashboardLineChartInstance.options.scales.yAxes[0].ticks.fontColor = theme.textSecondary;
    dashboardLineChartInstance.options.scales.yAxes[0].gridLines.color = theme.gridLine;
    if (dashboardLineChartInstance.options.tooltips) {
        dashboardLineChartInstance.options.tooltips.backgroundColor = theme.tooltipBg;
    }
    var ds = dashboardLineChartInstance.data.datasets;
    var dsKeys = ['software', 'hardware', 'network'];
    ds.forEach(function(dataset, idx) {
        var key = dsKeys[idx];
        if (theme.ds && theme.ds[key]) {
            dataset.borderColor = theme.ds[key].border;
            dataset.backgroundColor = theme.ds[key].bg;
            dataset.pointBorderColor = theme.ds[key].border;
            dataset.pointHoverBorderColor = theme.ds[key].border;
        }
        dataset.pointBackgroundColor = theme.pointBg;
        dataset.pointHoverBackgroundColor = theme.pointBg;
    });
    dashboardLineChartInstance.update();
}

var dashObserver = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.attributeName === 'class') {
            updateDashboardChartTheme();
        }
    });
});
dashObserver.observe(document.documentElement, { attributes: true });
dashObserver.observe(document.body, { attributes: true });
window.addEventListener('skinChanged', updateDashboardChartTheme);
window.addEventListener('themeChanged', updateDashboardChartTheme);

if (document.readyState === 'complete') {
    initDashboardLineChart();
} else {
    window.addEventListener('load', initDashboardLineChart);
    document.addEventListener('DOMContentLoaded', initDashboardLineChart);
}
</script>