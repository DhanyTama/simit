<?php include "conn.php"; ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport">
        <title>Welcome To | SI MRT - IT</title>
        <!-- Favicon-->
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <!-- Google Fonts -->
        <link href="css/opensans.css" rel="stylesheet" type="text/css">
        <link href="css/openfamily.css" rel="stylesheet" type="text/css">

        <!-- Bootstrap Core Css -->
        <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="plugins/node-waves/waves.css" rel="stylesheet"/>

        <!-- Animation Css -->
        <link href="plugins/animate-css/animate.css" rel="stylesheet"/>

        <!-- Bootstrap Material Datetime Picker Css -->
        <link
            href="plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
            rel="stylesheet"/>

        <!-- Wait Me Css -->
        <link href="plugins/waitme/waitMe.css" rel="stylesheet"/>

        <!-- Colorpicker Css -->
        <link
            href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css"
            rel="stylesheet">

        <!-- Dropzone Css -->
        <link href="plugins/dropzone/dropzone.css" rel="stylesheet">

        <!-- Multi Select Css -->
        <link href="plugins/multi-select/css/multi-select.css" rel="stylesheet">

        <!-- Bootstrap Spinner Css -->
        <link href="plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">

        <!-- Bootstrap Tagsinput Css -->
        <link
            href="plugins/bootstrap-tagsinput/bootstrap-tagsinput.css"
            rel="stylesheet">

        <!-- noUISlider Css -->
        <link href="plugins/nouislider/nouislider.min.css" rel="stylesheet">

        <!-- JQuery DataTable Css -->
        <link
            href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css"
            rel="stylesheet">

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Bootstrap Select Css -->
        <link
            href="plugins/bootstrap-select/css/bootstrap-select.css"
            rel="stylesheet"/>

        <!-- Custom Css -->
        <link href="css/style.css" rel="stylesheet">

        <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all
        themes -->
        <link href="css/themes/all-themes.css" rel="stylesheet"/>
        
        <!-- Custom CSS untuk validasi -->
        <style>
            .is-invalid { border-color: #e91e63 !important; }
            .is-valid { border-color: #4caf50 !important; }
            .error-msg { color: #e91e63; font-size: 11px; margin-top: 3px; display: none; }
            .error-msg.show { display: block; }
            .form-line.error { border-bottom: 2px solid #e91e63; }
            .form-line.success { border-bottom: 2px solid #4caf50; }
            
            /* Modern UI Overrides */
            body, section.content { background-color: #e4e9f0 !important; font-family: 'Open Sans', sans-serif; }
            .theme-red .navbar { box-shadow: 0 4px 15px rgba(0,0,0,0.15) !important; border-bottom: none !important; }
            .navbar-brand { font-weight: 700 !important; letter-spacing: 0.5px; }
            .sidebar { box-shadow: 4px 0 20px rgba(0,0,0,0.08) !important; border-right: none !important; }
            .sidebar .user-info { padding: 20px 15px 12px 15px; }
            
            /* Modern Cards & Info Boxes */
            .card, .info-box {
                border-radius: 16px !important;
                border: none !important;
                box-shadow: 0 10px 40px rgba(0,0,0,0.08) !important;
                background-color: #ffffff !important;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .info-box:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 45px rgba(0,0,0,0.12) !important;
            }
            .info-box .icon { border-radius: 16px 0 0 16px !important; }
            
            .card .header {
                border-bottom: 1px solid #f0f0f0 !important;
                padding: 25px 20px !important;
                background-color: transparent !important;
            }
            .card .header h2 {
                font-weight: 800 !important;
                color: #2c3e50 !important;
                font-size: 18px !important;
                letter-spacing: 0.5px;
            }
            
            /* Modal Modernization */
            .modal-content {
                border-radius: 16px !important;
                overflow: hidden;
                border: none;
                box-shadow: 0 10px 40px rgba(0,0,0,0.15) !important;
            }
            /* Fix Select2 in Modal */
            .select2-container--default .select2-selection--single {
                border: 1px solid #ddd !important;
                border-radius: 8px !important;
                height: 40px !important;
                padding: 5px 10px;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 38px;
            }
            .select2-container {
                width: 100% !important;
            }
            
            /* Modern Panels (For Panduan/Tutorial) */
            .panel-group .panel {
                border-radius: 12px !important;
                border: none !important;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
                margin-bottom: 15px !important;
                overflow: hidden;
            }
            .panel-group .panel-title a {
                padding: 18px 25px !important;
                font-weight: 600 !important;
                display: block;
                text-decoration: none !important;
                font-size: 15px !important;
                letter-spacing: 0.5px;
            }
            .panel-group .panel-body {
                padding: 25px !important;
                background-color: #fff !important;
                color: #555 !important;
                line-height: 1.6;
            }
        </style>
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
                    <a
                        href="javascript:void(0);"
                        class="navbar-toggle collapsed"
                        data-toggle="collapse"
                        data-target="#navbar-collapse"
                        aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="#">SI MRT - IT (SYSTEM INFORMATION MAINTENANCE REQUEST AND TROUBLE IT)</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="index.php?page=tutorial">
                                <i class="material-icons">home</i>
                                <span class="icon-name"></span></a>
                        </li>
                        <li>
                            <a href="" data-toggle="modal" data-target="#defaultModal">
                                <i class="material-icons">add_circle</i>
                                <span class="icon-name"></span></a>
                        </li>

                        <li>
                            <a href="index.php?page=data">
                                <i class="material-icons">data_usage</i>
                                <span class="icon-name"></span></a>
                        </li>
                        <li>
                            <a href="index.php?page=alldata">
                                <i class="material-icons">view_list</i>
                                <span class="icon-name"></span></a>
                        </li>
                        <li>
                            <a href="sign-in.php">
                                <i class="material-icons">account_circle</i>
                                <span class="icon-name"></span></a>
                        </li>
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
                        <a href="sign-in.php"><img src="images/user.png" width="48" height="48" alt="User"/></a>
                    </div>
                    <div class="info-container">
                        <div
                            class="name"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">IT RSAM</div>
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
                        &copy; 2017 - 2018
                        <a href="javascript:void(0);">
                            - RSU. ANWAR MEDIKA</a>
                    </div>
                    <div class="version">
                        <b>Version:
                        </b>
                        1.0.5
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
                
                <!-- Modal 1: MAINTENANCE/REQUEST/TROUBLE - IT -->
                <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom: 1px solid #f0f0f0; padding: 20px 25px; background-color: #fafbfc;">
                                <h4 class="modal-title" id="defaultModalLabel" style="font-weight: 700; color: #333;">MAINTENANCE / REQUEST / TROUBLE - IT</h4>
                            </div>
                            <form id="form_validation" method="POST" action="psimpandata.php" onsubmit="return validatePhoneOnSubmit('nohp', 'error-msg-1');">
                                <div class="modal-body" style="padding: 25px;">
                                    
                                    <div class="alert alert-warning" style="border-radius: 8px; color: #8a6d3b; background-color: #fcf8e3; border: 1px solid #faebcc; padding: 15px; margin-bottom: 25px;">
                                        <strong><i class="material-icons" style="font-size:18px; vertical-align:middle;">info_outline</i> Perhatian:</strong><br>
                                        Untuk perubahan data terhadap pasien yang sudah KRS harus membuat Berita Acara terlebih dahulu.
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label" style="font-weight: 600; color: #555; margin-bottom: 8px;">Nama Pelapor</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="pelapor"
                                            id="pelapor"
                                            placeholder="Masukkan nama pelapor"
                                            required="required">
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <label class="form-label" style="font-weight: 600; color: #555; margin-bottom: 8px;">Departemen</label>
                                            <select
                                                class="form-control show-tick"
                                                name="depart"
                                                id="depart"
                                                required="required">
                                                <option value="">-- Pilih Departemen --</option>
                                                <?php
                                                              $in=mysqli_query($connect,"select id_kriteria,nama from kriteria order by nama");
                                                              while($row1=mysqli_fetch_array($in)){
                                                                ?>
                                                <option value="<?php echo $row1['nama'];?>"><?php echo $row1['nama'];?>
                                                </option>
                                                <?php
                                                              }
                                                             ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    
                                    <!-- === FIELD NO HP BARU === -->
                                    <div class="form-group">
                                        <label class="form-label" style="font-weight: 600; color: #555; margin-bottom: 8px;">No HP</label>
                                        <div id="line-nohp-1">
                                            <input
                                                type="tel"
                                                class="form-control"
                                                name="nohp"
                                                id="nohp"
                                                placeholder="Contoh: 6281234567890"
                                                pattern="^628[0-9]{8,12}$"
                                                title="Nomor HP harus diawali 628, hanya angka, tanpa spasi (min 11 digit, max 15 digit)"
                                                oninput="validatePhoneInput('nohp', 'error-msg-1', 'line-nohp-1')"
                                                onblur="validatePhoneOnBlur('nohp', 'error-msg-1')"
                                                required="required">
                                        </div>
                                        <div id="error-msg-1" class="error-msg" style="margin-top: 5px;">
                                            <i class="material-icons" style="font-size:14px;vertical-align:middle;">error</i>
                                            Nomor HP harus diawali 628, hanya angka, tanpa spasi
                                        </div>
                                    </div>
                                    <!-- === END FIELD NO HP === -->
                                    
                                    <div class="form-group">
                                        <label class="form-label" style="font-weight: 600; color: #555; margin-bottom: 8px;">Deskripsi Kendala</label>
                                        <textarea
                                            name="description"
                                            id="description"
                                            cols="30"
                                            rows="5"
                                            class="form-control no-resize"
                                            placeholder="Jelaskan detail masalah atau kendala yang dialami"
                                            required="required"></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer" style="padding: 15px 25px; border-top: 1px solid #f0f0f0; background-color: #fafbfc; border-radius: 0 0 16px 16px;">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" style="background-color: #f1f3f5; color: #444; border: 1px solid #ddd !important;">TUTUP</button>
                                    <button type="submit" class="btn btn-primary waves-effect" style="background-color: #2196F3; color: white;">SIMPAN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal 2: MASUKAN DAN SARAN SIMRS NEW -->
                <div class="modal fade" id="defaultModal2" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="defaultModalLabel">MASUKAN DAN SARAN SIMRS NEW</h4>
                            </div>
                            <form id="form_validation2" method="POST" action="psimpandata2.php" onsubmit="return validatePhoneOnSubmit('nohp2', 'error-msg-2');">
                                <div class="modal-body">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="pelapor"
                                                id="pelapor2"
                                                required="required">
                                            <label class="form-label">Nama Pelapor</label>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <select
                                                class="form-control show-tick"
                                                name="depart"
                                                id="depart2"
                                                required="required">
                                                <option value="">-- Pilih Departemen --</option>
                                                <?php
                                                              $in=mysqli_query($connect,"select id_kriteria,nama from kriteria order by nama");
                                                              while($row1=mysqli_fetch_array($in)){
                                                                ?>
                                                <option value="<?php echo $row1['nama'];?>"><?php echo $row1['nama'];?>
                                                </option>
                                                <?php
                                                              }
                                                             ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    
                                    <!-- === FIELD NO HP BARU (Modal 2) === -->
                                    <div class="form-group form-float">
                                        <div class="form-line" id="line-nohp-2">
                                            <input
                                                type="tel"
                                                class="form-control"
                                                name="nohp"
                                                id="nohp2"
                                                placeholder="6281234567890"
                                                pattern="^628[0-9]{8,12}$"
                                                title="Nomor HP harus diawali 628, hanya angka, tanpa spasi (min 11 digit, max 15 digit)"
                                                oninput="validatePhoneInput('nohp2', 'error-msg-2', 'line-nohp-2')"
                                                onblur="validatePhoneOnBlur('nohp2', 'error-msg-2')"
                                                required="required">
                                            <label class="form-label">No HP (Opsional)</label>
                                        </div>
                                        <div id="error-msg-2" class="error-msg">
                                            <i class="material-icons" style="font-size:14px;vertical-align:middle;">error</i>
                                            Nomor HP harus diawali 628, hanya angka, tanpa spasi
                                        </div>
                                    </div>
                                    <!-- === END FIELD NO HP === -->
                                    
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea
                                                name="description"
                                                id="description2"
                                                cols="30"
                                                rows="5"
                                                class="form-control no-resize"
                                                required="required"></textarea>
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
        <script
            src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
        <script
            src="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css"></script>
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
        <script
            src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

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
        
        <!-- === CUSTOM JS: Validasi No HP (Non-Blocking) === -->
        <script>
        // Fungsi validasi format No HP: harus 628, hanya angka, min 11 digit, max 15 digit
        function isValidPhone(phone) {
            if (!phone || phone.trim() === '') return true; // boleh kosong (opsional)
            var pattern = /^628[0-9]{8,12}$/;
            return pattern.test(phone);
        }

        // Validasi real-time saat user mengetik (hanya visual feedback)
        function validatePhoneInput(inputId, errorId, lineId) {
            var input = document.getElementById(inputId);
            var error = document.getElementById(errorId);
            var line = document.getElementById(lineId);
            var value = input.value.trim();
            
            // Hapus semua spasi secara otomatis
            input.value = value.replace(/\s/g, '');
            value = input.value;
            
            if (value === '') {
                // Kosong = valid (opsional), reset styling
                input.classList.remove('is-invalid', 'is-valid');
                if(line) line.classList.remove('error', 'success');
                if(error) error.classList.remove('show');
                return;
            }
            
            if (isValidPhone(value)) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                if(line) { line.classList.remove('error'); line.classList.add('success'); }
                if(error) error.classList.remove('show');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                if(line) { line.classList.remove('success'); line.classList.add('error'); }
                if(error) error.classList.add('show');
            }
            // Tidak return apa-apa, tidak blocking input lain
        }

        // Validasi saat blur (hanya visual feedback, tidak blocking)
        function validatePhoneOnBlur(inputId, errorId) {
            var input = document.getElementById(inputId);
            var value = input.value.trim();
            var error = document.getElementById(errorId);
            
            if (value === '') {
                if(input) input.classList.remove('is-invalid', 'is-valid');
                if(error) error.classList.remove('show');
                return;
            }
            
            if (!isValidPhone(value)) {
                if(input) {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
                if(error) error.classList.add('show');
            }
            // Tidak return false, tidak blocking
        }

        // Validasi saat submit - INI YANG MENCEGAH SUBMIT JIKA INVALID
        function validatePhoneOnSubmit(inputId, errorId) {
            var input = document.getElementById(inputId);
            var value = input ? input.value.trim() : '';
            var error = document.getElementById(errorId);
            
            // Jika kosong, anggap valid (opsional)
            if (value === '') return true;
            
            if (!isValidPhone(value)) {
                // Tampilkan error visual
                if(input) {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
                if(error) error.classList.add('show');
                // Cegah submit dengan return false
                return false;
            }
            // Valid, izinkan submit
            return true;
        }

        // Auto-format: hapus non-angka saat paste/input (hanya untuk UX, tidak blocking)
        document.addEventListener('DOMContentLoaded', function() {
            ['nohp', 'nohp2'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) {
                    el.addEventListener('paste', function(e) {
                        setTimeout(function() {
                            el.value = el.value.replace(/[^0-9]/g, '');
                            // Trigger input event untuk update visual
                            var event = new Event('input', { bubbles: true });
                            el.dispatchEvent(event);
                        }, 10);
                    });
                    // Hanya izinkan angka saat mengetik (opsional, untuk UX lebih baik)
                    el.addEventListener('input', function(e) {
                        // Hapus karakter non-angka tapi biarkan user tetap bisa edit
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });
                }
            });
        });
        </script>
        <!-- === END CUSTOM JS === -->
        
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                // Inisialisasi Select2 pada dropdown departemen
                $('#depart').select2({
                    dropdownParent: $('#defaultModal'),
                    placeholder: "-- Pilih Departemen --",
                    allowClear: true
                });
            });
        </script>
    </body>

</html>