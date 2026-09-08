<?php

/**
 * SIMIT - Public / User Sidebar Component
 * Modularized for easy maintenance and editing.
 * Dynamically highlights active menu item based on $_GET['page'].
 */
$currentPage = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 'tutorial';
?>
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info pb-5">
        <div class="image">
            <a href="sign-in.php"><img src="images/user.png" width="48" height="48" alt="User" /></a>
        </div>
        <div class="info-container">
            <div class="name">IT RSAM</div>
            <div class="email">itrsam@example.com</div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php echo ($currentPage === 'tutorial') ? 'active' : ''; ?>">
                <a href="index.php?page=tutorial">
                    <i class="material-icons">home</i>
                    <span>Home</span>
                </a>
            </li>
            <li class="<?php echo ($currentPage === 'data') ? 'active' : ''; ?>">
                <a href="index.php?page=data">
                    <i class="material-icons">view_list</i>
                    <span>Data MRT - IT Today</span>
                </a>
            </li>
            <li class="<?php echo ($currentPage === 'alldata') ? 'active' : ''; ?>">
                <a href="index.php?page=alldata">
                    <i class="material-icons">view_list</i>
                    <span>Data MRT - IT Complete All</span>
                </a>
            </li>

            <li class="header">MRT - IT</li>
            <li class="sidebar-action-mrt">
                <a href="javascript:void(0);" data-toggle="modal" data-target="#defaultModal">
                    <i class="material-icons">add_circle</i>
                    <span>MRT - IT</span>
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
                    </div>
                </div>
            </li> -->
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2026
            <a href="javascript:void(0);">- RSU. ANWAR MEDIKA</a>
        </div>
        <div class="version">
            <b>Version: </b> 2.0.0
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->