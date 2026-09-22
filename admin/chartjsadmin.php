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
        padding: 10px 14px !important;
        height: auto !important;
        min-height: 90px !important;
        margin-bottom: 24px !important;
        position: relative !important;
        color: #ffffff !important;
        cursor: pointer !important;
    }

    .info-box:hover {
        transform: translateY(-4px) !important;
    }
    .info-box.bg-pink:hover {
        box-shadow: 0 12px 28px rgba(244, 63, 94, 0.36) !important;
    }
    .info-box.bg-cyan:hover {
        box-shadow: 0 12px 28px rgba(14, 165, 233, 0.36) !important;
    }
    .info-box.bg-light-green:hover {
        box-shadow: 0 12px 28px rgba(16, 185, 129, 0.36) !important;
    }
    .info-box.bg-orange:hover {
        box-shadow: 0 12px 28px rgba(245, 158, 11, 0.36) !important;
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
        background: rgba(255, 255, 255, 0.12) !important;
        pointer-events: none !important;
        transition: transform 0.3s ease, background 0.3s ease !important;
    }

    .info-box:hover::after {
        transform: scale(1.15) !important;
        background: rgba(255, 255, 255, 0.18) !important;
        width: 85px !important;
        height: 85px !important;
    }

    /* Disable old AdminBSB ugly dark expanding bar */
    .info-box.hover-expand-effect:after,
    .info-box.hover-expand-effect:hover:after {
        display: none !important;
        width: 0 !important;
        content: none !important;
    }

    /* Vibrant Gradients */
    .info-box.bg-pink {
        background: linear-gradient(135deg, #F43F5E 0%, #BE123C 100%) !important;
    }
    .info-box.bg-cyan {
        background: linear-gradient(135deg, #0EA5E9 0%, #0369A1 100%) !important;
    }
    .info-box.bg-light-green {
        background: linear-gradient(135deg, #10B981 0%, #047857 100%) !important;
    }
    .info-box.bg-orange {
        background: linear-gradient(135deg, #F59E0B 0%, #B45309 100%) !important;
    }

    /* Soft Rounded Frosted Icon Badge */
    .info-box .icon {
        width: 46px !important;
        height: 46px !important;
        min-width: 46px !important;
        border-radius: 12px !important;
        background: rgba(255, 255, 255, 0.22) !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin-right: 12px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        border: none !important;
        transition: transform 0.25s ease, background 0.25s ease !important;
    }

    .info-box:hover .icon {
        transform: scale(1.08) !important;
        background: rgba(255, 255, 255, 0.32) !important;
    }

    .info-box .icon i.material-icons {
        font-size: 24px !important;
        line-height: 1 !important;
        color: #ffffff !important;
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
        letter-spacing: 0 !important;
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

    /* Modern Card Layout */
    .card {
        border-radius: 18px !important;
        border: none !important;
        overflow: hidden !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06) !important;
        margin-bottom: 25px !important;
    }

    body:not(.dark-mode) .card {
        background: #ffffff !important;
    }

    .card .header {
        border-top-left-radius: 18px !important;
        border-top-right-radius: 18px !important;
        padding: 18px 24px 14px 24px !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .card .header h2 {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        letter-spacing: 0.3px !important;
        margin: 0 !important;
    }
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

    var cardBg = '#111c38';
    var textSec = '#94a3b8';
    var legend = '#cbd5e1';
    var tooltip = 'rgba(15, 23, 42, 0.95)';

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
        }
    }

    return {
        isDark: isDark,
        skin: skin,
        textPrimary: isDark ? '#f8fafc' : '#1e293b',
        textSecondary: isDark ? textSec : '#64748b',
        legendText: isDark ? legend : '#475569',
        gridLine: isDark ? 'rgba(255, 255, 255, 0.07)' : 'rgba(0, 0, 0, 0.05)',
        zeroLine: isDark ? 'rgba(255, 255, 255, 0.15)' : 'rgba(0, 0, 0, 0.12)',
        pointBg: isDark ? cardBg : '#ffffff',
        tooltipBg: isDark ? tooltip : 'rgba(15, 23, 42, 0.88)'
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
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.15)',
                pointBorderColor: 'rgba(54, 162, 235, 1)',
                pointBackgroundColor: theme.pointBg,
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHitRadius: 15,
                pointHoverBackgroundColor: theme.pointBg,
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
                pointHoverBorderWidth: 2,
                lineTension: 0.3,
                fill: true
            }, {
                label: "HARDWARE",
                data: <?php echo json_encode($chart_hardware); ?>,
                borderColor: 'rgba(233, 30, 99, 1)',
                backgroundColor: 'rgba(233, 30, 99, 0.15)',
                pointBorderColor: 'rgba(233, 30, 99, 1)',
                pointBackgroundColor: theme.pointBg,
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHitRadius: 15,
                pointHoverBackgroundColor: theme.pointBg,
                pointHoverBorderColor: 'rgba(233, 30, 99, 1)',
                pointHoverBorderWidth: 2,
                lineTension: 0.3,
                fill: true
            }, {
                label: "NETWORK",
                data: <?php echo json_encode($chart_network); ?>,
                borderColor: 'rgba(255, 193, 7, 1)',
                backgroundColor: 'rgba(255, 193, 7, 0.15)',
                pointBorderColor: 'rgba(255, 193, 7, 1)',
                pointBackgroundColor: theme.pointBg,
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHitRadius: 15,
                pointHoverBackgroundColor: theme.pointBg,
                pointHoverBorderColor: 'rgba(255, 193, 7, 1)',
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
    dashboardLineChartInstance.data.datasets.forEach(function(ds) {
        ds.pointBackgroundColor = theme.pointBg;
        ds.pointHoverBackgroundColor = theme.pointBg;
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

if (document.readyState === 'complete') {
    initDashboardLineChart();
} else {
    window.addEventListener('load', initDashboardLineChart);
    document.addEventListener('DOMContentLoaded', initDashboardLineChart);
}
</script>