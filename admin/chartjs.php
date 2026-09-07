
            <div class="row clearfix">
                <!-- Line Chart -->
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>LINE CHART</h2>
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
                            <canvas id="line_chart" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <!-- #END# Line Chart -->
                <!-- Bar Chart -->
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>BAR CHART</h2>
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
                            <canvas id="bar_chart" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <!-- #END# Bar Chart -->
            </div>

            <div class="row clearfix">
                <!-- Radar Chart -->
                
                <!-- #END# Pie Chart -->
            </div>
        

    <!-- Jquery Core Js -->
    <script src="../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../plugins/node-waves/waves.js"></script>

    <!-- Chart Plugins Js -->
    <script src="../plugins/chartjs/Chart.bundle.js"></script>

    <!-- Custom Js -->
    <script src="../js/admin.js"></script>
    <script type="text/javascript">
        $(function () {
            new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line'));
            new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('bar'));
            new Chart(document.getElementById("radar_chart").getContext("2d"), getChartJs('radar'));
            new Chart(document.getElementById("pie_chart").getContext("2d"), getChartJs('pie'));
        });

        function getChartJs(type) {
            <?php 
                $con=mysqli_connect("localhost","root","","eit");
                $tgl=date('2017-12');
                if (!$con) {
                    die('Could not connect: ' . mysql_error());
                }
            ?>
            var config = null;

            if (type === 'line') {
                config = {
                    type: 'line',
                    data: {
                        url: 'tampildata.php',
                        labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"],
                        datasets: [{
                            label: "HARDWARE",
                            data: [<?php 
                                    $query = mysqli_query($con,"SELECT Sim FROM grafik where tanggal like'%$tgl%'");
                                    while ($p = mysqli_fetch_array($query)) { echo '"' . $p['Sim'] . '",';}
                                 ?>],
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            pointBorderColor: 'rgba(54, 162, 235, 0)',
                            pointBackgroundColor: 'rgba(54, 162, 235, 0.9)',
                            pointBorderWidth: 1
                        }, {
                                label: "Internet",
                                data: [<?php 
                                    $query = mysqli_query($con,"SELECT Internet FROM grafik where tanggal like'%$tgl%'");
                                    while ($p = mysqli_fetch_array($query)) { echo '"' . $p['Internet'] . '",';}
                                 ?>],
                                borderColor: 'rgba(233, 30, 99, 0.75)',
                                backgroundColor: 'rgba(233, 30, 99, 0.3)',
                                pointBorderColor: 'rgba(233, 30, 99, 0)',
                                pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                                pointBorderWidth: 1
                            }
                        , {
                                label: "Wifi",
                                data: [<?php 
                                    $query = mysqli_query($con,"SELECT Printer FROM grafik where tanggal like'%$tgl%'");
                                    while ($p = mysqli_fetch_array($query)) { echo '"' . $p['Printer'] . '",';}
                                 ?>],
                                borderColor: 'rgba(255, 206, 86, 1)',
                                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                pointBorderColor: 'rgba(255, 206, 86, 0)',
                                pointBackgroundColor: 'rgba(255, 206, 86, 0.9)',
                                pointBorderWidth: 1
                            }]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            else if (type === 'bar') {
                config = {
                    type: 'bar',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "Komunikasi",
                            data: [65, 59, 80, 81, 56, 55, 40],
                            backgroundColor: 'rgba(0, 188, 212, 0.8)'
                        }, {
                                label: "Network",
                                data: [28, 48, 40, 19, 86, 27, 90],
                                backgroundColor: 'rgba(233, 30, 99, 0.8)'
                            }
                        , {
                                label: "Software",
                                data: [28, 48, 50, 16, 16, 27, 40],
                                backgroundColor: 'rgba(255, 206, 86, 0.2)'
                            }
                        , {
                                label: "Hardware",
                                data: [26, 78, 20, 19, 36, 21, 22],
                                backgroundColor: 'rgba(233, 30, 99, 0.3)'
                            }]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            
            return config;
        }

    </script>