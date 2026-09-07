<?php include "conn.php"; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | SI MRT - IT</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="css/opensans.css" rel="stylesheet" type="text/css">
    <link href="css/openfamily.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="plugins/waitme/waitMe.css" rel="stylesheet" />
    
    <!-- Colorpicker Css -->
    <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">

    <!-- Dropzone Css -->
    <link href="plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="plugins/multi-select/css/multi-select.css" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- noUISlider Css -->
    <link href="plugins/nouislider/nouislider.min.css" rel="stylesheet">
    
    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-red">
    
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">SI MRT - IT (SYSTEM INFORMATION MAINTENANCE REQUEST AND TROUBLE IT)</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
					<li><a href="index.php?page=tutorial"><i class="material-icons">home</i> <span class="icon-name"></span></a></li>
					<li><a href="" data-toggle="modal" data-target="#defaultModal"><i class="material-icons">add_circle</i> <span class="icon-name"></span></a></li>
					
					<li><a href="index.php?page=data"><i class="material-icons">data_usage</i> <span class="icon-name"></span></a></li>
					<li><a href="index.php?page=alldata"><i class="material-icons">view_list</i> <span class="icon-name"></span></a></li>
					<li><a href="sign-in.php"><i class="material-icons">account_circle</i> <span class="icon-name"></span></a></li>
                    <!-- #END# Call Search -->
                   
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <a href="sign-in.php"><img src="images/user.png" width="48" height="48" alt="User" /></a>
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">IT RSAM</div>
                    <div class="email">itrsam@example.com</div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active">
                        <a href="index.php?page=tutorial">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
						<a href="" data-toggle="modal" data-target="#defaultModal">
                            <i class="material-icons">add_circle</i>
                            <span>MRT - IT</span>
                        </a>
                    </li>
                    <li>
                        <a href="" data-toggle="modal" data-target="#defaultModal2">
                            <i class="material-icons">add_circle</i>
                            <span>MASUKAN DAN SARAN SIMRS NEW</span>
                        </a>
                    </li>
					<li>
						<a href="index.php?page=data">
                            <i class="material-icons">view_list</i>
                            <span>Data MRT - IT Today</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=alldata">
                            <i class="material-icons">view_list</i>
                            <span>Data MRT - IT Complete All</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2017 - 2018 <a href="javascript:void(0);"> - RSU. ANWAR MEDIKA</a>                
				</div>
                <div class="version">
                    <b>Version: </b> 1.0.5                
				</div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        
    </section>

    <section class="content">
        <div class="container-fluid">
            

            
            <!-- CPU Usage -->
            <div class="row clearfix">
                <?php
                	if(isset($_GET['page'])){
                		$page=$_GET['page'];
                		$file="$page.php";

                		if (!file_exists($file)){
                			include("tutorial.php");
                		}else{
                			include("$page.php");

                		}

                	}else{
                		include("tutorial.php");
                	}
					  
				?>   
            </div>
            <!-- #END# CPU Usage -->
             <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">MAINTENANCE/REQUEST/TROUBLE - IT</h4>
                        </div>
						<form id="form_validation" method="POST" action="psimpandata.php">
                        <div class="modal-body">
												<div class="form-group form-float">
													<div class="form-line">
														<input type="text" class="form-control" name="pelapor" id="pelapor" required>
														<label class="form-label">Nama Pelapor</label>
													</div>
												</div>
												
												<div class="row clearfix">
													<div class="col-md-12">
														<select class="form-control show-tick" name="depart" id="depart" required>
															<option value="">-- Pilih Departemen --</option>
															 <?php
															  $in=mysql_query("select id_kriteria,nama from kriteria order by nama");
															  while($row1=mysql_fetch_array($in)){			  
																?>
																	<option value="<?php echo $row1['nama'];?>"><?php echo $row1['nama'];?>  </option>
																<?php
															  }
															 ?>
														</select>
													</div>
												</div>
												<br>
												<div class="form-group form-float">
													<div class="form-line">
														<textarea name="description" id="description" cols="30" rows="5" class="form-control no-resize" required></textarea>
														<label class="form-label">Description</label>
													</div>
												</div>
												
												
							
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect">SAVE</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
						</form>
                    </div>
                </div>
            </div>

            <!-- #END# CPU Usage -->
             <div class="modal fade" id="defaultModal2" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">MASUKAN DAN SARAN SIMRS NEW</h4>
                        </div>
                        <form id="form_validation" method="POST" action="psimpandata2.php">
                        <div class="modal-body">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="pelapor" id="pelapor" required>
                                                        <label class="form-label">Nama Pelapor</label>
                                                    </div>
                                                </div>
                                                
                                                <div class="row clearfix">
                                                    <div class="col-md-12">
                                                        <select class="form-control show-tick" name="depart" id="depart" required>
                                                            <option value="">-- Pilih Departemen --</option>
                                                             <?php
                                                              $in=mysql_query("select id_kriteria,nama from kriteria order by nama");
                                                              while($row1=mysql_fetch_array($in)){            
                                                                ?>
                                                                    <option value="<?php echo $row1['nama'];?>"><?php echo $row1['nama'];?>  </option>
                                                                <?php
                                                              }
                                                             ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <textarea name="description" id="description" cols="30" rows="5" class="form-control no-resize" required></textarea>
                                                        <label class="form-label">Description</label>
                                                    </div>
                                                </div>
                                                
                                                
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect">SAVE</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>
    
    <!-- Bootstrap Notify Plugin Js -->
    <script src="plugins/bootstrap-notify/bootstrap-notify.js"></script>
    
     <!-- Jquery Spinner Plugin Js -->
    <script src="plugins/jquery-spinner/js/jquery.spinner.js"></script>
    
    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    
    <!-- noUISlider Plugin Js -->
    <script src="plugins/nouislider/nouislider.js"></script>
    
    <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    
    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>
    
    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>
    
    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Autosize Plugin Js -->
    <script src="plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    
    <!-- Input Mask Plugin Js -->
    <script src="plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    
    <!-- Dropzone Plugin Js -->
    <script src="plugins/dropzone/dropzone.js"></script>

    <!-- Custom Js -->
    
    <script src="js/admin.js"></script>
    <script src="js/pages/forms/basic-form-elements.js"></script>
    <script src="js/pages/tables/jquery-datatable.js"></script> 
    <script src="js/pages/index.js"></script>
    <script src="js/pages/ui/modals.js"></script>
    <script src="js/pages/forms/advanced-form-elements.js"></script>
    <script src="js/pages/forms/form-validation.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>