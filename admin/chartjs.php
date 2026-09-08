<?php
if (!isset($connect)) {
    include "../conn.php";
}
date_default_timezone_set('Asia/Jakarta');
$tgl = date('Y-m');
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
if ($q) {
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
?>

<div class="row clearfix">
    <!-- Line Chart -->
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>TREN GANGGUAN HARIAN (<?php echo date('F Y'); ?>)</h2>
            </div>
            <div class="body" style="position: relative; height: 320px;">
                <canvas id="line_chart"></canvas>
            </div>
        </div>
    </div>
    <!-- #END# Line Chart -->

    <!-- Bar Chart -->
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>TOTAL PER KATEGORI (<?php echo date('F Y'); ?>)</h2>
            </div>
            <div class="body" style="position: relative; height: 320px;">
                <canvas id="bar_chart"></canvas>
            </div>
        </div>
    </div>
    <!-- #END# Bar Chart -->
</div>

<script type="text/javascript">
function initDetailCharts() {
    if (typeof Chart === 'undefined') return;

    var lineElem = document.getElementById("line_chart");
    if (lineElem && lineElem.getAttribute('data-rendered') !== 'true') {
        lineElem.setAttribute('data-rendered', 'true');
        new Chart(lineElem.getContext("2d"), getLineChartConfig());
    }

    var barElem = document.getElementById("bar_chart");
    if (barElem && barElem.getAttribute('data-rendered') !== 'true') {
        barElem.setAttribute('data-rendered', 'true');
        new Chart(barElem.getContext("2d"), getBarChartConfig());
    }
}

function getLineChartConfig() {
    return {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: "SOFTWARE",
                data: <?php echo json_encode($software); ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.15)',
                pointBorderColor: 'rgba(54, 162, 235, 1)',
                pointBackgroundColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHitRadius: 15,
                pointHoverBackgroundColor: '#ffffff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
                pointHoverBorderWidth: 2,
                lineTension: 0.3,
                fill: true
            }, {
                label: "HARDWARE",
                data: <?php echo json_encode($hardware); ?>,
                borderColor: 'rgba(233, 30, 99, 1)',
                backgroundColor: 'rgba(233, 30, 99, 0.15)',
                pointBorderColor: 'rgba(233, 30, 99, 1)',
                pointBackgroundColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHitRadius: 15,
                pointHoverBackgroundColor: '#ffffff',
                pointHoverBorderColor: 'rgba(233, 30, 99, 1)',
                pointHoverBorderWidth: 2,
                lineTension: 0.3,
                fill: true
            }, {
                label: "NETWORK",
                data: <?php echo json_encode($network); ?>,
                borderColor: 'rgba(255, 193, 7, 1)',
                backgroundColor: 'rgba(255, 193, 7, 0.15)',
                pointBorderColor: 'rgba(255, 193, 7, 1)',
                pointBackgroundColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHitRadius: 15,
                pointHoverBackgroundColor: '#ffffff',
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
                    fontColor: '#475569',
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
                backgroundColor: 'rgba(15, 23, 42, 0.88)',
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
                        fontColor: '#64748b',
                        fontSize: 11
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 2,
                        fontColor: '#64748b',
                        fontSize: 11
                    },
                    gridLines: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                }]
            }
        }
    };
}

function getBarChartConfig() {
    return {
        type: 'bar',
        data: {
            labels: ["Software", "Hardware", "Network", "Komunikasi", "Security", "Other"],
            datasets: [{
                label: "Jumlah Tiket",
                data: [<?php echo "$tot_software, $tot_hardware, $tot_network, $tot_komunikasi, $tot_security, $tot_other"; ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(233, 30, 99, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(0, 188, 212, 0.8)',
                    'rgba(156, 39, 176, 0.8)',
                    'rgba(96, 125, 139, 0.8)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(233, 30, 99, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(0, 188, 212, 1)',
                    'rgba(156, 39, 176, 1)',
                    'rgba(96, 125, 139, 1)'
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
                backgroundColor: 'rgba(15, 23, 42, 0.88)',
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
                        fontColor: '#64748b',
                        fontSize: 11
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 10,
                        fontColor: '#64748b',
                        fontSize: 11
                    },
                    gridLines: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                }]
            }
        }
    };
}

if (document.readyState === 'complete') {
    initDetailCharts();
} else {
    window.addEventListener('load', initDetailCharts);
    document.addEventListener('DOMContentLoaded', initDetailCharts);
}
</script>