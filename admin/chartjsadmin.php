 <!-- Widgets -->

 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <div class="info-box bg-pink hover-expand-effect">
         <div class="icon">
             <i class="material-icons">playlist_add_check</i>
         </div>
         <div class="content">
             <div class="text">NEW TASKS</div>
             <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
         </div>
     </div>
 </div>
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <div class="info-box bg-cyan hover-expand-effect">
         <div class="icon">
             <i class="material-icons">help</i>
         </div>
         <div class="content">
             <div class="text">NEW TICKETS</div>
             <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
         </div>
     </div>
 </div>
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <div class="info-box bg-light-green hover-expand-effect">
         <div class="icon">
             <i class="material-icons">forum</i>
         </div>
         <div class="content">
             <div class="text">NEW COMMENTS</div>
             <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
         </div>
     </div>
 </div>
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <div class="info-box bg-orange hover-expand-effect">
         <div class="icon">
             <i class="material-icons">person_add</i>
         </div>
         <div class="content">
             <div class="text">NEW VISITORS</div>
             <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
         </div>
     </div>
 </div>
 <!-- #END# Widgets -->






 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
     <div class="card">
         <div class="header">
             <h2>GRAFIK MRT-IT THIS MONTH</h2>
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
     $(function() {
         new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line'));
         new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('bar'));
         new Chart(document.getElementById("radar_chart").getContext("2d"), getChartJs('radar'));
         new Chart(document.getElementById("pie_chart").getContext("2d"), getChartJs('pie'));
     });

     function getChartJs(type) {
         <?php
            $con = mysqli_connect("localhost", "root", "", "eit010517");
            $tgl = date('Y-m');
            if (!$con) {
                die('Could not connect: ' . mysql_error());
            }
            ?>
         var config = null;

         if (type === 'line') {
             config = {
                 type: 'line',
                 data: {
                     labels: [<?php
                                $query = mysqli_query($con, "SELECT tanggal FROM tb_grafik_jnstrouble where tanggal like'%$tgl%'");
                                while ($p = mysqli_fetch_array($query)) {
                                    echo '"' . $p['tanggal'] . '",';
                                }
                                ?>],
                     datasets: [{
                         label: "SOFTWARE",
                         data: [<?php
                                $query = mysqli_query($con, "SELECT SOFTWARE FROM tb_grafik_jnstrouble where tanggal like'%$tgl%'");
                                while ($p = mysqli_fetch_array($query)) {
                                    echo '"' . $p['SOFTWARE'] . '",';
                                }
                                ?>],
                         borderColor: 'rgba(54, 162, 235, 1)',
                         backgroundColor: 'rgba(54, 162, 235, 0.2)',
                         pointBorderColor: 'rgba(54, 162, 235, 0)',
                         pointBackgroundColor: 'rgba(54, 162, 235, 0.9)',
                         pointBorderWidth: 1
                     }, {
                         label: "HARDWARE",
                         data: [<?php
                                $query = mysqli_query($con, "SELECT HARDWARE FROM tb_grafik_jnstrouble where tanggal like'%$tgl%'");
                                while ($p = mysqli_fetch_array($query)) {
                                    echo '"' . $p['HARDWARE'] . '",';
                                }
                                ?>],
                         borderColor: 'rgba(233, 30, 99, 0.75)',
                         backgroundColor: 'rgba(233, 30, 99, 0.3)',
                         pointBorderColor: 'rgba(233, 30, 99, 0)',
                         pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                         pointBorderWidth: 1
                     }, {
                         label: "NETWORK",
                         data: [<?php
                                $query = mysqli_query($con, "SELECT NETWORK FROM tb_grafik_jnstrouble where tanggal like'%$tgl%'");
                                while ($p = mysqli_fetch_array($query)) {
                                    echo '"' . $p['NETWORK'] . '",';
                                }
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
                     display: true,
                     position: 'top',
                     labels: {
                         boxWidth: 80,
                         fontColor: 'black'
                     }
                 }
             }
         } else if (type === 'bar') {
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
                     }, {
                         label: "Software",
                         data: [28, 48, 50, 16, 16, 27, 40],
                         backgroundColor: 'rgba(255, 206, 86, 0.2)'
                     }, {
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