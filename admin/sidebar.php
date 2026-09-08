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
            <img src="../images/user.png" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ADMIN IT RSAM</div>
            <div class="email">itrsam@example.com</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="../logout.php"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php echo ($currentPage === 'chartjsadmin') ? 'active' : ''; ?>">
                <a href="index.php?page=chartjsadmin">
                    <i class="material-icons">home</i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php echo ($currentPage === 'data') ? 'active' : ''; ?>">
                <a href="index.php?page=data">
                    <i class="material-icons">add_circle</i>
                    <span>Data MRT - IT Today</span>
                </a>
            </li>
            <li class="<?php echo ($currentPage === 'alldata') ? 'active' : ''; ?>">
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
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2017 - 2020 <a href="javascript:void(0);"> - RSU. ANWAR MEDIKA</a>
        </div>
        <div class="version">
            <b>Version: </b> 1.0.5
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->