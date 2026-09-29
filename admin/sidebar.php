<?php

/**
 * SIMIT - Admin Sidebar Component
 * Modularized for easy maintenance and editing.
 * Dynamically highlights active menu item based on $_GET['page'].
 */
$currentPage = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 'chartjsadmin';
?>
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#profileImageModal">
                <img src="../images/giphy.gif" width="70" height="70" alt="User" style="cursor: pointer;" title="Perbesar Gambar" />
            </a>
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">IT COMMAND CENTER</div>
            <div class="email">it@rsanwarmedika.com</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="index.php?page=chartjsadmin"><i class="material-icons">dashboard</i>Dashboard</a></li>
                    <!-- <li><a href="index.php?page=chartjs"><i class="material-icons">insert_chart</i>Grafik & Statistik</a></li> -->
                    <li><a href="index.php?page=data"><i class="material-icons">today</i>Data Hari Ini</a></li>
                    <li><a href="index.php?page=alldata"><i class="material-icons">view_list</i>Semua Data</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="../logout.php"><i class="material-icons">power_settings_new</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php echo (in_array($currentPage, ['chartjsadmin', 'chartjs'])) ? 'active' : ''; ?>">
                <a href="index.php?page=chartjsadmin">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- <li class="<?php echo ($currentPage == 'chartjs') ? 'active' : ''; ?>">
                <a href="index.php?page=chartjs">
                    <i class="material-icons">insert_chart</i>
                    <span>Grafik & Statistik</span>
                </a>
            </li> -->
            <li class="<?php echo (in_array($currentPage, ['data', 'accept', 'solution'])) ? 'active' : ''; ?>">
                <a href="index.php?page=data">
                    <i class="material-icons">today</i>
                    <span>Data MRT - IT Today</span>
                </a>
            </li>
            <li class="<?php echo (in_array($currentPage, ['alldata', 'dataedit'])) ? 'active' : ''; ?>">
                <a href="index.php?page=alldata">
                    <i class="material-icons">view_list</i>
                    <span>Data MRT - IT ALL</span>
                </a>
            </li>
            <li class="header">PENGATURAN TAMPILAN</li>
            <li class="sidebar-theme-item">
                <a href="javascript:void(0);" class="theme-toggle-link sidebar-theme-toggle" id="sidebar-theme-toggle-btn">
                    <i class="material-icons sidebar-theme-icon" id="sidebar-theme-icon">brightness_2</i>
                    <span class="sidebar-theme-title" id="sidebar-theme-text">Mode Gelap</span>
                    <div class="sidebar-switch-track">
                        <div class="sidebar-switch-thumb"></div>
                    </div>
                </a>
            </li>
            <!-- <li class="sidebar-skin-item">
                <div class="sidebar-skin-picker">
                    <div class="sidebar-skin-title">
                        <i class="material-icons">palette</i>
                        <span>Pilihan Skin</span>
                    </div>
                    <div class="sidebar-skin-grid">
                        <button type="button" class="skin-btn active" data-skin="default" title="Default (Red / Blue)">
                            <span class="skin-preview-dot skin-dot-default"></span>
                            <span class="skin-name">Default</span>
                        </button>
                        <button type="button" class="skin-btn" data-skin="cappuccino" title="Cappuccino (Warm Coffee / Caramel)">
                            <span class="skin-preview-dot skin-dot-cappuccino"></span>
                            <span class="skin-name">Cappuccino</span>
                        </button>
                        <button type="button" class="skin-btn" data-skin="everforest" title="Everforest (Sage Green)">
                            <span class="skin-preview-dot skin-dot-everforest"></span>
                            <span class="skin-name">Everforest</span>
                        </button>
                        <button type="button" class="skin-btn" data-skin="tokyo" title="Tokyo Night (Cyberpunk)">
                            <span class="skin-preview-dot skin-dot-tokyo"></span>
                            <span class="skin-name">Tokyo</span>
                        </button>
                        <button type="button" class="skin-btn skin-btn-pb" data-skin="pb" title="Point Blank (Tactical Cyan & Amber)">
                            <span class="skin-preview-dot skin-dot-pb"></span>
                            <span class="skin-name">Point Blank</span>
                        </button>
                    </div>
                </div>
            </li> -->
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2026 <a href="javascript:void(0);"> - RSU. ANWAR MEDIKA</a>
        </div>
        <div class="version">
            <b>Version: </b> 2.0.0
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->

<!-- Profile Image Modal -->
<div class="modal fade" id="profileImageModal" tabindex="-1" role="dialog" aria-labelledby="profileImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: transparent; border: none; box-shadow: none;">
            <div class="modal-header" style="border-bottom: none; padding-bottom: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 1; text-shadow: 0 1px 3px rgba(0,0,0,0.8); font-size: 30px; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" style="padding-top: 0;">
                <img src="../images/giphy.gif" alt="User" style="max-width: 100%; max-height: 80vh; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);" />
            </div>
        </div>
    </div>
</div>