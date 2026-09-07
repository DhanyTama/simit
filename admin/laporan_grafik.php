<?php 
session_start();
if (empty($_SESSION['username'])){
	header('location:../index.php');	
} else {
	include "../conn.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SIM-IT</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="Hakko Bio Richard">
    <meta name="keywords" content="Perpus, Website, Aplikasi, Perpustakaan, Online">
    <!-- bootstrap 3.0.2 -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="../css/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="../css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- fullCalendar -->
    <!-- <link href="css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" /> -->
    <!-- Daterange picker -->
    <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="../css/iCheck/all.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <!-- <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" /> -->
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <!-- Theme style -->
    <link href="../css/style.css" rel="stylesheet" type="text/css" />



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
          <![endif]-->

          <style type="text/css">

          </style>
      </head>
      <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php" class="logo">
                SIM-IT
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i>
                                <span><?php echo $_SESSION['fullname']; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                <li class="dropdown-header text-center">Account</li>

                                    <li>
                                        <a href="detail-admin.php?hal=edit&kd=<?php echo $_SESSION['user_id'];?>">
                                        <i class="fa fa-user fa-fw pull-right"></i>
                                            Profile
                                        </a>
                                        <a href="admin.php">
                                        <i class="fa fa-cog fa-fw pull-right"></i>
                                            Settings
                                        </a>
                                        </li>

                                        <li class="divider"></li>

                                        <li>
                                            <a href="../logout.php"><i class="fa fa-ban fa-fw pull-right"></i> Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <?php
$timeout = 10; // Set timeout minutes
$logout_redirect_url = "../login.html"; // Set logout URL

$timeout = $timeout * 60; // Converts minutes to seconds
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        echo "<script>alert('Session Anda Telah Habis!'); window.location = '$logout_redirect_url'</script>";
    }
}
$_SESSION['start_time'] = time();
?>
<?php } ?>
                <div class="wrapper row-offcanvas row-offcanvas-left">
                    <!-- Left side column. contains the logo and sidebar -->
                    <aside class="left-side sidebar-offcanvas">
                        <!-- sidebar: style can be found in sidebar.less -->
                        <section class="sidebar">
                            <!-- Sidebar user panel -->
                            <div class="user-panel">
                                <div>
                                    <center><img src="<?php echo $_SESSION['gambar']; ?>" height="80" width="80" class="img-circle" alt="User Image" style="border: 3px solid white;" /></center>
                                </div>
                                <div class="info">
                                    <center><p><?php echo $_SESSION['fullname']; ?></p></center>

                                </div>
                            </div>
                            <!-- search form -->
                            <!--<form action="#" method="get" class="sidebar-form">
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control" placeholder="Search..."/>
                                    <span class="input-group-btn">
                                        <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </form> -->
                            <!-- /.search form -->
                            <!-- sidebar menu: : style can be found in sidebar.less -->
                            <?php include "menu.php"; ?>
                        </section>
                        <!-- /.sidebar -->
                    </aside>

                    <aside class="right-side">

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel">
                                <header class="panel-heading">
                                    <b>Data Admin</b>

                                </header>

							   <table id="xmyTable" class="table table-striped table-bordered table-hover">
								<thead>
								   <tr>
								   <th class="center" width="40px">No</th>
								   <th class="center" width="400px">Jenis Laporan</th>
									<th class="center">Filter </th>
								   <th class="center" width="200px">Aksi</th>
								   </tr>
								</thead>
								<tbody>
										<tr>
										   <td class="center">1</td>
										   <td class="left">Laporan Grafik Maintace Hardware & Sofware</td>
										   <form action="cetak/linechart.php" method="GET" target="_blank">
										   <td class="center">
												 <select class="chosen-select span1" name="bulan" id="bulan">
												  <option> -- Pilih Bulan --</option>
												  <option value="01"> Januari</option>
												  <option value="02"> Februari</option>
												  <option value="03"> Maret</option>
												  <option value="04"> April</option>
												  <option value="05"> Mei</option>
												  <option value="06"> Juni</option>
												  <option value="07"> Juli</option>
												  <option value="08"> Agustus</option>
												  <option value="09"> September</option>
												  <option value="10"> Oktober</option>
												  <option value="11"> November</option>
												  <option value="12"> Desember</option>
												  </select>
												  <select class="chosen-select span1" name="tahun" id="tahun">
												  <option> -- Pilih Tahun --</option>
												  <option value="2017"> 2017</option>
												  <option value="2018"> 2018</option>
												  <option value="2019"> 2019</option>
												  </select>
										   </td>
										   <td class="center">
											<button class='btn btn-primary btn-small' type="submit">
													<i class='icon-print bigger-100'></i> Cetak
												</button>
											</td>
											</form>
									   </tr>
	   									
										
									   <tr>
										   <td class="center">2</td>
										   <td class="left">Laporan SIM-IT</td>
										   <form action="laporan_sim.php" method="GET">
										   <td class="center">
												 <select class="chosen-select span1" name="bulansim" id="bulansim">
												  <option> -- Pilih Bulan --</option>
												  <option value="01"> Januari</option>
												  <option value="02"> Februari</option>
												  <option value="03"> Maret</option>
												  <option value="04"> April</option>
												  <option value="05"> Mei</option>
												  <option value="06"> Juni</option>
												  <option value="07"> Juli</option>
												  <option value="08"> Agustus</option>
												  <option value="09"> September</option>
												  <option value="10"> Oktober</option>
												  <option value="11"> November</option>
												  <option value="12"> Desember</option>
												  </select>
												  <select class="chosen-select span1" name="tahunsim" id="tahunsim">
												  <option> -- Pilih Tahun --</option>
												  <option value="2017"> 2017</option>
												  <option value="2018"> 2018</option>
												  <option value="2019"> 2019</option>
												  </select>
												  <select class="chosen-select span1" name="depart" id="depart">
												  <option> -- Departemen --</option>
												  <option value="IPS"> IPS</option>
												  <option value="KOMDIS"> KOMDIS</option>
												  <option value="Admin"> Admin</option>
												  <option value="Verifikator"> Verifikator</option>
												  <option value="Rekam Medis"> Rekam Medis</option>
												  <option value="Apotik"> Apotik</option>
												  <option value="Laborat"> Laborat</option>
												  <option value="Radiologi"> Radiologi</option>
												  <option value="Kasir RI"> Kasir RI</option>
												  <option value="Kasir RJ"> Kasir RJ</option>
												  <option value="Loket RI"> Loket RI</option>
												  <option value="Loket RJ"> Loket RJ</option>
												  <option value="CS"> CS</option>
												  <option value="IGD"> IGD</option>
												  <option value="Poli Umum"> Poli Umum</option>
												  <option value="Poli Gigi"> Poli Gigi</option>
												  <option value="Poli Mata/Rehab"> Poli Mata/Rehab</option>
												  <option value="Marketing"> Marketing</option>
												  <option value="Poli Obsgyn"> Poli Obsgyn</option>
												  <option value="Yayasan"> Yayasan</option>
												  <option value="Icu"> Icu</option>
												  <option value="OK"> OK</option>
												  <option value="HD"> HD</option>
												  <option value="FORENSIK"> FORENSIK</option>
												  <option value="Tulip"> Tulip</option>
												  <option value="Angrek"> Angrek</option>
												  <option value="Mawar"> Mawar</option>
												  <option value="Dahlia"> Dahlia</option>
												  <option value="Melati"> Melati</option>
												  <option value="Neo"> Neo</option>
												  <option value="Melati"> Melati</option>
												  <option value="Gudang Log Umum"> Gudang Log Umum</option>
												  <option value="Kantor Log Agses"> Kantor Log Agses</option>
												  <option value="CSSD/Laundry"> CSSD/Laundry</option>
												  <option value="Photocopy"> Photocopy</option>
												  <option value="Gizi"> Gizi</option>
												  <option value="MR"> MR</option>
												  <option value="VK"> VK</option>
												  <option value="TPPRI"> TPPRI</option>
												  <option value="TPPRJ"> TPPRJ</option>
												  <option value="Poli Anak"> Poli Anak</option>								 
												  <option value="Depo Farmasi"> Depo Farmasi</option>								 
												  <option value="Lainnya">Lainnya</option>
												  </select>
										   </td>
										   <td class="center">
											<button class='btn btn-primary btn-small' type="submit">
													<i class='icon-print bigger-100'></i> Tampil
												</button>
											</td>
											</form>
									   </tr>
									   
	  
									</tbody>
									</table>
															   

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
              <!-- row end -->
                </section><!-- /.content -->
                <div class="footer-main">
                    Copyright &copy <a href="http://www.hakkoblogs.com" target="_blank">RSU Anwar Medika</a> 2017
                </div>
            </aside><!-- /.right-side -->

        </div><!-- ./wrapper -->


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="../js/jquery.min.js" type="text/javascript"></script>

        <!-- jQuery UI 1.10.3 -->
        <script src="../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="../js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

        <script src="../js/plugins/chart.js" type="text/javascript"></script>

        <!-- datepicker
        <script src="js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>-->
        <!-- Bootstrap WYSIHTML5
        <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>-->
        <!-- iCheck -->
        <script src="../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <!-- calendar -->
        <script src="../js/plugins/fullcalendar/fullcalendar.js" type="text/javascript"></script>

        <!-- Director App -->
        <script src="../js/Director/app.js" type="text/javascript"></script>

        <!-- Director dashboard demo (This is only for demo purposes) -->
        <script src="../js/Director/dashboard.js" type="text/javascript"></script>

        <!-- Director for demo purposes -->
        <script type="text/javascript">
            $('input').on('ifChecked', function(event) {
                // var element = $(this).parent().find('input:checkbox:first');
                // element.parent().parent().parent().addClass('highlight');
                $(this).parents('li').addClass("task-done");
                console.log('ok');
            });
            $('input').on('ifUnchecked', function(event) {
                // var element = $(this).parent().find('input:checkbox:first');
                // element.parent().parent().parent().removeClass('highlight');
                $(this).parents('li').removeClass("task-done");
                console.log('not');
            });

        </script>
        <script>
            $('#noti-box').slimScroll({
                height: '400px',
                size: '5px',
                BorderRadius: '5px'
            });

            $('input[type="checkbox"].flat-grey, input[type="radio"].flat-grey').iCheck({
                checkboxClass: 'icheckbox_flat-grey',
                radioClass: 'iradio_flat-grey'
            });
</script>
<script type="text/javascript">
    $(function() {
                "use strict";
                //BAR CHART
                var data = {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [
                        {
                            label: "My First dataset",
                            fillColor: "rgba(220,220,220,0.2)",
                            strokeColor: "rgba(220,220,220,1)",
                            pointColor: "rgba(220,220,220,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: [65, 59, 80, 81, 56, 55, 40]
                        },
                        {
                            label: "My Second dataset",
                            fillColor: "rgba(151,187,205,0.2)",
                            strokeColor: "rgba(151,187,205,1)",
                            pointColor: "rgba(151,187,205,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(151,187,205,1)",
                            data: [28, 48, 40, 19, 86, 27, 90]
                        }
                    ]
                };
            new Chart(document.getElementById("linechart").getContext("2d")).Line(data,{
                responsive : true,
                maintainAspectRatio: false,
            });

            });
            // Chart.defaults.global.responsive = true;
</script>
</body>
</html>