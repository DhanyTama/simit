<?php
session_start();
if (empty($_SESSION['username'])) {
    header('location:../index.php');
} else {
    include "../conn.php";
    $tanggal = date("Y-m-d");
}
$is_dark = (isset($_COOKIE['simit_theme']) && $_COOKIE['simit_theme'] === 'dark');
$current_skin = (isset($_COOKIE['simit_skin']) && in_array($_COOKIE['simit_skin'], ['default', 'cappuccino', 'everforest', 'tokyo'])) ? $_COOKIE['simit_skin'] : 'default';
?>
<!DOCTYPE html>
<html class="<?php echo ($is_dark ? 'dark-mode ' : '') . 'skin-' . $current_skin; ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | SI MRT - IT</title>
    <!-- Favicon-->
    <link rel="icon" href="../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="../css/opensans.css" rel="stylesheet" type="text/css">
    <link href="../css/openfamily.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap Tagsinput Css -->
    <link href="../plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- Wait Me Css -->
    <link href="../plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Colorpicker Css -->
    <link href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">

    <!-- Dropzone Css -->
    <link href="../plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="../plugins/multi-select/css/multi-select.css" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="../plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="../plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- noUISlider Css -->
    <link href="../plugins/nouislider/nouislider.min.css" rel="stylesheet">

    <!-- JQuery DataTable Css -->
    <link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../css/themes/all-themes.css" rel="stylesheet" />


    <script>
        (function() {
            var cookieMatch = document.cookie.match(/(?:^|;\s*)simit_theme=([^;]*)/);
            var t = localStorage.getItem('simit_theme') || (cookieMatch ? cookieMatch[1] : null);
            if (t === 'dark') {
                document.documentElement.classList.add('dark-mode');
                document.cookie = "simit_theme=dark; path=/; max-age=31536000; SameSite=Lax";
            } else {
                document.documentElement.classList.remove('dark-mode');
                if (t === 'light') {
                    document.cookie = "simit_theme=light; path=/; max-age=31536000; SameSite=Lax";
                }
            }
            var skinMatch = document.cookie.match(/(?:^|;\s*)simit_skin=([^;]*)/);
            var s = localStorage.getItem('simit_skin') || (skinMatch ? skinMatch[1] : 'default');
            ['default', 'cappuccino', 'everforest', 'tokyo'].forEach(function(sk) {
                document.documentElement.classList.remove('skin-' + sk);
            });
            if (['default', 'cappuccino', 'everforest', 'tokyo'].indexOf(s) !== -1) {
                document.documentElement.classList.add('skin-' + s);
            } else {
                document.documentElement.classList.add('skin-default');
            }
        })();
    </script>

    <!-- Modern UI Overrides -->
    <style>
        /* Body Background - Darker to make white cards pop */
        body,
        section.content {
            background-color: #e4e9f0 !important;
            font-family: 'Open Sans', sans-serif;
        }

        html.dark-mode body,
        html.dark-mode section.content,
        body.dark-mode,
        body.dark-mode section.content,
        .dark-mode body,
        .dark-mode section.content {
            background-color: #0b1329 !important;
            color: #cbd5e1 !important;
        }

        /* Navbar Modernization */
        .theme-red .navbar {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
            border-bottom: none !important;
        }

        .navbar-brand {
            font-weight: 700 !important;
            letter-spacing: 0.5px;
        }

        /* Sidebar Styling */
        .sidebar {
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08) !important;
            border-right: none !important;
        }

        .sidebar .user-info {
            padding: 20px 15px 12px 15px;
        }

        /* Modern Cards */
        .card {
            border-radius: 18px !important;
            border: none !important;
            overflow: hidden !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06) !important;
            margin-bottom: 25px !important;
        }

        body:not(.dark-mode) .card {
            background-color: #ffffff !important;
        }

        /* Modern Info-Boxes / Widgets */
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

        /* Card Headers */
        .card .header {
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 18px 24px 14px 24px !important;
            background-color: transparent !important;
        }

        .card .header h2 {
            font-weight: 800 !important;
            color: #2c3e50 !important;
            font-size: 18px !important;
            letter-spacing: 0.5px;
        }

        /* Modern Tables & Clean Header */
        .card .body {
            padding: 18px 16px !important;
        }

        .table-responsive {
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow-x: auto !important;
            width: 100% !important;
        }

        .table {
            border: none !important;
            margin-bottom: 0 !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
        }

        .table>thead>tr>th,
        table.dataTable thead>tr>th {
            background-color: #f1f5f9 !important;
            color: #334155 !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            letter-spacing: 0.5px !important;
            border-bottom: 2px solid #cbd5e1 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            padding: 10px 18px 10px 8px !important;
            vertical-align: middle !important;
            white-space: nowrap !important;
            position: relative !important;
            line-height: 1.35 !important;
        }

        /* First column (No) width and alignment */
        .table>thead>tr>th:first-child,
        table.dataTable thead>tr>th:first-child,
        .table>tbody>tr>td:first-child,
        table.dataTable tbody>tr>td:first-child {
            width: 38px !important;
            min-width: 38px !important;
            max-width: 44px !important;
            padding: 10px 4px !important;
            text-align: center !important;
            font-weight: 600 !important;
            color: #64748b !important;
        }

        /* Sorting icons properly centered vertically with perfect spacing */
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:after {
            position: absolute !important;
            top: 50% !important;
            bottom: auto !important;
            right: 5px !important;
            transform: translateY(-50%) !important;
            font-size: 10px !important;
            line-height: 1 !important;
            color: #64748b !important;
            opacity: 0.45 !important;
            margin-top: 0 !important;
        }

        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            color: #0284c7 !important;
            opacity: 1 !important;
            font-weight: bold !important;
        }

        /* Action column ("Aksi") - remove sorting arrows and set proper width */
        .table>thead>tr>th:last-child:after,
        table.dataTable thead>tr>th:last-child:after,
        table.dataTable thead th.no-sort-col:after,
        table.dataTable thead th.no-sort:after {
            display: none !important;
        }

        .table>thead>tr>th:last-child,
        table.dataTable thead>tr>th:last-child,
        table.dataTable thead th.no-sort-col,
        table.dataTable thead th.no-sort {
            width: 106px !important;
            min-width: 106px !important;
            max-width: 110px !important;
            padding: 10px 4px !important;
            text-align: center !important;
            cursor: default !important;
            white-space: nowrap !important;
        }

        .table>tbody>tr>td:last-child,
        table.dataTable tbody>tr>td:last-child {
            width: 106px !important;
            min-width: 106px !important;
            max-width: 110px !important;
            padding: 8px 4px !important;
            text-align: center !important;
            white-space: nowrap !important;
        }

        /* Table Body cells */
        .table>tbody>tr>td,
        table.dataTable tbody>tr>td {
            padding: 9px 8px !important;
            vertical-align: middle !important;
            border-top: 1px solid #f1f5f9 !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: none !important;
            color: #334155 !important;
            font-size: 12.5px !important;
            line-height: 1.4 !important;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #fafbfc !important;
        }

        .table-hover>tbody>tr:hover,
        .table>tbody>tr:hover {
            background-color: #f0f7ff !important;
            transition: background-color 0.15s ease;
        }

        .table-bordered {
            border: none !important;
        }

        /* Centered labels and table cells */
        .table>thead>tr>th.text-center,
        table.dataTable thead>tr>th.text-center,
        .table>tbody>tr>td.text-center,
        table.dataTable tbody>tr>td.text-center,
        .table>tbody>tr>td[align="center"],
        table.dataTable tbody>tr>td[align="center"],
        .table td:has(> .label),
        .table td:has(> span.label) {
            text-align: center !important;
        }

        .table td .label,
        .table td span.label {
            display: inline-block !important;
            text-align: center !important;
        }

        /* Table Action Buttons Group */
        .table .action-btn-group,
        .table .icon-button-demo {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            vertical-align: middle !important;
            gap: 4px !important;
            white-space: nowrap !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .table .action-btn-group a,
        .table .icon-button-demo a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            vertical-align: middle !important;
            text-decoration: none !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1 !important;
        }

        .table .action-btn-group .btn,
        .table .action-btn-group a .btn,
        .table .icon-button-demo .btn,
        .table .icon-button-demo a .btn {
            width: 28px !important;
            height: 28px !important;
            min-width: 28px !important;
            max-width: 28px !important;
            min-height: 28px !important;
            max-height: 28px !important;
            padding: 0 !important;
            margin: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            vertical-align: middle !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.12) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
            line-height: 1 !important;
            overflow: hidden !important;
        }

        .table .action-btn-group .btn:hover,
        .table .action-btn-group a .btn:hover,
        .table .icon-button-demo .btn:hover,
        .table .icon-button-demo a .btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;
        }

        /* Reset AdminBSB's built-in top: 3px on table action icons */
        .table .action-btn-group .btn i,
        .table .action-btn-group .btn i.material-icons,
        .table .action-btn-group a .btn i,
        .table .action-btn-group a .btn i.material-icons,
        .table .icon-button-demo .btn i,
        .table .icon-button-demo .btn i.material-icons,
        .table .icon-button-demo a .btn i,
        .table .icon-button-demo a .btn i.material-icons {
            position: static !important;
            top: 0 !important;
            left: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 15px !important;
            line-height: 1 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            transform: none !important;
        }

        /* Universal Button Reset & Horizontal Alignment */
        .btn {
            display: inline-flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            vertical-align: middle !important;
            white-space: nowrap !important;
            line-height: 1 !important;
        }

        /* Standalone buttons styling */
        .btn:not(.dropdown-toggle) {
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12) !important;
            font-weight: 600 !important;
            transition: all 0.25s ease !important;
        }

        .btn:not(.dropdown-toggle):hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18) !important;
        }

        /* Reset AdminBSB's top: 3px and span top: -2px on ALL button icons */
        .btn i,
        .btn i.material-icons,
        .btn span {
            position: static !important;
            top: 0 !important;
            left: 0 !important;
            right: auto !important;
            bottom: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1 !important;
            transform: none !important;
        }

        .btn i,
        .btn i.material-icons {
            font-size: 18px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0 !important;
        }

        .btn-circle,
        .btn-xs {
            border-radius: 6px !important;
        }

        /* Form Labels */
        .form-group>label.form-label,
        .form-group>label {
            display: inline-block !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            margin-bottom: 6px !important;
            position: static !important;
        }

        body:not(.dark-mode) .form-group>label.form-label,
        body:not(.dark-mode) .form-group>label {
            color: #334155 !important;
        }

        .form-group .form-line {
            border-bottom: none !important;
        }

        .form-group .form-line:after {
            display: none !important;
        }

        /* Form Inputs, Textareas & Native Selects */
        input.form-control:not(.input-sm),
        .form-group input.form-control:not(.input-sm),
        .form-group .form-line input.form-control:not(.input-sm),
        textarea.form-control,
        .form-group textarea.form-control,
        .form-group .form-line textarea.form-control,
        select.form-control,
        select.form-control.show-tick,
        .form-group select,
        .form-group .form-line select {
            border-radius: 8px !important;
            padding: 10px 14px !important;
            height: 42px !important;
            font-size: 14px !important;
            box-sizing: border-box !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }

        /* Native Select Specific Appearance & Chevron Arrow */
        select.form-control,
        select.form-control.show-tick,
        .form-group select,
        .form-group .form-line select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            padding: 8px 36px 8px 14px !important;
            line-height: 24px !important;
            cursor: pointer !important;
            outline: none !important;
        }

        body:not(.dark-mode) input.form-control:not(.input-sm),
        body:not(.dark-mode) .form-group input.form-control:not(.input-sm),
        body:not(.dark-mode) .form-group .form-line input.form-control:not(.input-sm),
        body:not(.dark-mode) textarea.form-control,
        body:not(.dark-mode) .form-group textarea.form-control,
        body:not(.dark-mode) .form-group .form-line textarea.form-control {
            border: 1.5px solid #ced4da !important;
            color: #334155 !important;
            background-color: #ffffff !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
        }

        body:not(.dark-mode) select.form-control,
        body:not(.dark-mode) select.form-control.show-tick,
        body:not(.dark-mode) .form-group select,
        body:not(.dark-mode) .form-group .form-line select {
            border: 1.5px solid #ced4da !important;
            color: #334155 !important;
            background-color: #ffffff !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 14px center !important;
            background-size: 14px 14px !important;
        }

        textarea.form-control,
        .form-group textarea.form-control,
        .form-group .form-line textarea.form-control {
            height: auto !important;
            min-height: 100px !important;
            line-height: 1.5 !important;
            padding: 12px 14px !important;
        }

        body:not(.dark-mode) input.form-control:not(.input-sm):hover,
        body:not(.dark-mode) textarea.form-control:hover,
        body:not(.dark-mode) select.form-control:hover,
        body:not(.dark-mode) .form-group select:hover {
            border-color: #94a3b8 !important;
        }

        body:not(.dark-mode) input.form-control:not(.input-sm):focus,
        body:not(.dark-mode) textarea.form-control:focus,
        body:not(.dark-mode) select.form-control:focus,
        body:not(.dark-mode) .form-group select:focus {
            border-color: #2196F3 !important;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.18) !important;
            outline: none !important;
            background-color: #ffffff !important;
        }

        body:not(.dark-mode) select option {
            background-color: #ffffff !important;
            color: #334155 !important;
            padding: 8px 12px !important;
        }

        body:not(.dark-mode) input.form-control::placeholder,
        body:not(.dark-mode) textarea.form-control::placeholder {
            color: #9ca3af !important;
            opacity: 1 !important;
        }

        /* FIX: Bootstrap-Select (Dropdown Pergantian Hardware, Feedback, dsb.) */
        .bootstrap-select,
        .bootstrap-select.form-control,
        div.bootstrap-select.form-control {
            border: none !important;
            border-bottom: none !important;
            padding: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            height: auto !important;
            min-height: 0 !important;
            margin-bottom: 0 !important;
            border-radius: 8px !important;
        }

        .bootstrap-select>.btn.dropdown-toggle {
            border-radius: 8px !important;
            box-shadow: none !important;
            padding: 9px 14px !important;
            height: 42px !important;
            line-height: 22px !important;
            font-size: 14px !important;
            font-weight: 400 !important;
            transform: none !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }

        body:not(.dark-mode) .bootstrap-select>.btn.dropdown-toggle {
            border: 1.5px solid #ced4da !important;
            background-color: #ffffff !important;
            color: #334155 !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
        }

        body:not(.dark-mode) .bootstrap-select>.btn.dropdown-toggle:hover {
            border-color: #94a3b8 !important;
        }

        body:not(.dark-mode) .bootstrap-select>.btn.dropdown-toggle:focus,
        body:not(.dark-mode) .bootstrap-select.open>.btn.dropdown-toggle {
            border-color: #2196F3 !important;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.18) !important;
            background-color: #ffffff !important;
            transform: none !important;
            outline: none !important;
        }

        body:not(.dark-mode) .bootstrap-select>.btn.dropdown-toggle .filter-option {
            margin-top: 0 !important;
            font-size: 14px !important;
            color: #334155 !important;
            line-height: 22px !important;
            text-align: left !important;
        }

        .bootstrap-select>.btn.dropdown-toggle .bs-caret {
            margin-left: auto !important;
        }

        .bootstrap-select>.btn.dropdown-toggle .bs-caret .caret {
            border-top: 5px solid #64748b !important;
            border-right: 5px solid transparent !important;
            border-left: 5px solid transparent !important;
            position: static !important;
            margin: 0 !important;
            transition: transform 0.2s ease !important;
        }

        .bootstrap-select.open>.btn.dropdown-toggle .bs-caret .caret {
            border-top: none !important;
            border-bottom: 5px solid #2196F3 !important;
            border-right: 5px solid transparent !important;
            border-left: 5px solid transparent !important;
        }

        .bootstrap-select>.dropdown-menu,
        .bootstrap-select.open>.dropdown-menu,
        .bootstrap-select.dropup>.dropdown-menu,
        .bootstrap-select.dropup.open>.dropdown-menu {
            border-radius: 12px !important;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12) !important;
            padding: 6px !important;
            margin-top: 4px !important;
            margin-bottom: 0 !important;
            border: 1px solid #e2e8f0 !important;
            box-sizing: border-box !important;
            min-width: 100% !important;
            z-index: 1060 !important;
            top: 100% !important;
            bottom: auto !important;
        }

        body:not(.dark-mode) .bootstrap-select>.dropdown-menu {
            border: 1px solid #e2e8f0 !important;
            background-color: #ffffff !important;
        }

        /* Live Search Box Fix */
        .bootstrap-select .bs-searchbox {
            position: relative !important;
            padding: 8px 10px !important;
            margin: 0 0 6px 0 !important;
            border-bottom: 1px solid #e2e8f0 !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        .bootstrap-select .bs-searchbox:after,
        .bootstrap-select .bs-searchbox:before {
            content: none !important;
            display: none !important;
        }

        .bootstrap-select .bs-searchbox .form-control {
            margin: 0 !important;
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            float: none !important;
            height: 38px !important;
            min-height: 38px !important;
            padding: 6px 12px 6px 36px !important;
            font-size: 13.5px !important;
            border-radius: 8px !important;
            box-sizing: border-box !important;
            border: 1.5px solid #cbd5e1 !important;
            background-color: #f8fafc !important;
            color: #1e293b !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 10px center !important;
            background-size: 15px 15px !important;
            box-shadow: none !important;
        }

        .bootstrap-select .bs-searchbox .form-control:focus {
            border-color: #0284c7 !important;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.2) !important;
            outline: none !important;
        }

        .bootstrap-select .dropdown-menu.inner,
        .bootstrap-select ul.dropdown-menu.inner,
        .bootstrap-select .dropdown-menu ul {
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            background: transparent !important;
            list-style: none !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .bootstrap-select .dropdown-menu li {
            border: none !important;
            box-shadow: none !important;
            margin: 2px 0 !important;
            padding: 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            list-style: none !important;
            position: relative !important;
        }

        .bootstrap-select .dropdown-menu li a {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 8px 14px !important;
            font-size: 13.5px !important;
            line-height: 1.4 !important;
            min-height: 38px !important;
            box-sizing: border-box !important;
            border-radius: 8px !important;
            transition: all 0.15s ease !important;
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
            text-decoration: none !important;
            cursor: pointer !important;
            width: 100% !important;
            position: relative !important;
            background: transparent !important;
        }

        .bootstrap-select .dropdown-menu li a span.text {
            display: inline-block !important;
            flex: 1 1 auto !important;
            margin: 0 !important;
            padding: 0 !important;
            text-align: left !important;
            white-space: normal !important;
            word-break: break-word !important;
        }

        body:not(.dark-mode) .bootstrap-select .dropdown-menu li a {
            color: #334155 !important;
        }

        body:not(.dark-mode) .bootstrap-select .dropdown-menu li.selected a,
        body:not(.dark-mode) .bootstrap-select .dropdown-menu li.active a {
            background-color: #e0f2fe !important;
            color: #0284c7 !important;
            font-weight: 600 !important;
        }

        body:not(.dark-mode) .bootstrap-select .dropdown-menu li a:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }

        .bootstrap-select.btn-group.show-tick .dropdown-menu li.selected a span.check-mark {
            position: static !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-left: 10px !important;
            margin-right: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            color: #0284c7 !important;
            font-size: 18px !important;
            line-height: 1 !important;
            flex-shrink: 0 !important;
        }

        .bootstrap-select .dropdown-menu .no-results {
            padding: 10px 14px !important;
            background: transparent !important;
            color: #64748b !important;
            font-size: 13px !important;
            text-align: center !important;
        }

        /* Sembunyikan tooltip pop-up hitam pada tombol dropdown select */
        .bootstrap-select+.tooltip,
        .bootstrap-select .tooltip {
            display: none !important;
        }

        /* FIX: DataTable Controls (Show Entries & Search Input) */
        .dataTables_length label {
            display: inline-flex !important;
            align-items: center !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            gap: 6px !important;
        }

        body:not(.dark-mode) .dataTables_length label {
            color: #555 !important;
        }

        div.dataTables_wrapper div.dataTables_length select,
        .dataTables_length select.form-control,
        .dataTables_length select {
            height: 34px !important;
            padding: 4px 10px !important;
            font-size: 13px !important;
            line-height: normal !important;
            box-sizing: border-box !important;
            border-radius: 6px !important;
            box-shadow: none !important;
            display: inline-block !important;
            width: auto !important;
            min-width: 65px !important;
            vertical-align: middle !important;
        }

        body:not(.dark-mode) div.dataTables_wrapper div.dataTables_length select,
        body:not(.dark-mode) .dataTables_length select.form-control,
        body:not(.dark-mode) .dataTables_length select {
            border: 1px solid #ccc !important;
            background-color: #fff !important;
            color: #333 !important;
        }

        .dataTables_filter label {
            display: inline-flex !important;
            align-items: center !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            gap: 8px !important;
        }

        body:not(.dark-mode) .dataTables_filter label {
            color: #555 !important;
        }

        .dataTables_filter input.form-control,
        .dataTables_wrapper .dataTables_filter input {
            height: 34px !important;
            padding: 4px 10px !important;
            font-size: 13px !important;
            border-radius: 6px !important;
            box-shadow: none !important;
            display: inline-block !important;
            margin-left: 0 !important;
        }

        body:not(.dark-mode) .dataTables_filter input.form-control,
        body:not(.dark-mode) .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ccc !important;
            background-color: #fff !important;
            color: #333 !important;
        }

        /* DataTable Pagination & Buttons */
        .dataTables_wrapper .dt-buttons .dt-button,
        .dataTables_wrapper .dt-buttons .btn {
            border-radius: 6px !important;
            padding: 6px 14px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
            margin-right: 4px !important;
        }

        .pagination>li>a,
        .pagination>li>span {
            border-radius: 6px !important;
            margin: 0 2px !important;
            font-size: 13px !important;
            padding: 6px 12px !important;
        }

        /* Modal Dialogs */
        .modal-content {
            border-radius: 16px !important;
            overflow: hidden !important;
            border: none !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2) !important;
        }

        /* Default Button Styling in Light Mode */
        body:not(.dark-mode) .btn-default {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            color: #475569 !important;
        }

        body:not(.dark-mode) .btn-default i,
        body:not(.dark-mode) .btn-default i.material-icons {
            color: #475569 !important;
        }

        body:not(.dark-mode) .btn-default:hover,
        body:not(.dark-mode) .btn-default:focus {
            background-color: #e2e8f0 !important;
            border-color: #94a3b8 !important;
            color: #1e293b !important;
        }

        body:not(.dark-mode) .btn-default:hover i,
        body:not(.dark-mode) .btn-default:hover i.material-icons {
            color: #1e293b !important;
        }

        /* Global Table Vertical Centering */
        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td,
        .table-bordered>thead>tr>th,
        .table-bordered>tbody>tr>td {
            vertical-align: middle !important;
        }

        /* Form Action Bar */
        .form-action-bar {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            margin-top: 25px !important;
            padding-top: 20px !important;
            border-top: 1px solid #e2e8f0 !important;
        }

        .form-action-bar .btn,
        .modal-footer .btn {
            height: 38px !important;
            padding: 0 18px !important;
            font-size: 13px !important;
            letter-spacing: 0.5px !important;
            border-radius: 8px !important;
        }

        /* Table Action Return / Reply Button */
        .btn-table-back,
        .table td a.btn-table-back,
        .table td .btn-table-back,
        .table td a .btn.btn-default,
        .table td .btn.btn-default {
            border-radius: 8px !important;
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
            max-width: 34px !important;
            padding: 0 !important;
            margin: 0 auto !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            vertical-align: middle !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08) !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
        }

        .btn-table-back i,
        .btn-table-back i.material-icons,
        .table td a.btn-table-back i,
        .table td .btn.btn-default i {
            position: static !important;
            top: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 18px !important;
            line-height: 1 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        body:not(.dark-mode) .btn-table-back,
        body:not(.dark-mode) .table td a.btn-table-back,
        body:not(.dark-mode) .table td .btn.btn-default,
        body:not(.dark-mode) .table td a .btn.btn-default {
            background-color: #ffffff !important;
            border: 1.5px solid #cbd5e1 !important;
        }

        body:not(.dark-mode) .btn-table-back i,
        body:not(.dark-mode) .btn-table-back i.material-icons,
        body:not(.dark-mode) .table td a.btn-table-back i,
        body:not(.dark-mode) .table td .btn.btn-default i {
            color: #475569 !important;
        }

        body:not(.dark-mode) .btn-table-back:hover,
        body:not(.dark-mode) .table td a.btn-table-back:hover,
        body:not(.dark-mode) .table td .btn.btn-default:hover,
        body:not(.dark-mode) .table td a .btn.btn-default:hover {
            background-color: #f1f5f9 !important;
            border-color: #94a3b8 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12) !important;
        }

        body:not(.dark-mode) .btn-table-back:hover i,
        body:not(.dark-mode) .table td a.btn-table-back:hover i,
        body:not(.dark-mode) .table td .btn.btn-default:hover i {
            color: #0f172a !important;
        }
    </style>

    <!-- Dark Mode Css (Loaded after style block to ensure complete priority) -->
    <link href="../css/dark-mode.css?v=<?php echo filemtime(__DIR__ . '/../css/dark-mode.css'); ?>" rel="stylesheet">
</head>

<body class="theme-red <?php echo $is_dark ? 'dark-mode' : ''; ?>">
    <script>
        if (document.documentElement.classList.contains('dark-mode') && !document.body.classList.contains('dark-mode')) {
            document.body.classList.add('dark-mode');
        }
    </script>

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
                <a class="navbar-brand" href="index.php?page=data">SI MRT - IT (SYSTEM INFORMATION MAINTENANCE REQUEST AND TROUBLE IT)</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Navigation Icons -->
                    <li><a href="index.php" title="Dashboard Utama"><i class="material-icons">dashboard</i> <span class="icon-name"></span></a></li>
                    <li><a href="index.php?page=chartjs" title="Grafik & Statistik IT"><i class="material-icons">insert_chart</i> <span class="icon-name"></span></a></li>
                    <li><a href="index.php?page=data" title="Data MRT Hari Ini"><i class="material-icons">today</i> <span class="icon-name"></span></a></li>
                    <li><a href="index.php?page=alldata" title="Semua Data Riwayat MRT"><i class="material-icons">view_list</i> <span class="icon-name"></span></a></li>
                    <!-- Theme Toggle Button -->
                    <li>
                        <a href="javascript:void(0);" id="btn-theme-toggle" class="btn-theme-toggle" title="Ganti Mode Gelap / Terang">
                            <i class="material-icons" id="icon-theme-toggle">brightness_2</i>
                            <span class="icon-name"></span>
                        </a>
                    </li>
                    <li><a href="../logout.php" title="Keluar / Logout"><i class="material-icons">power_settings_new</i> <span class="icon-name"></span></a></li>
                    <!-- #END# Navigation Icons -->

                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- #END# Left Sidebar -->

    </section>

    <section class="content">
        <div class="container-fluid">



            <!-- CPU Usage -->
            <div class="row clearfix">
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    $file = "$page.php";

                    if (!file_exists($file)) {
                        include("chartjsadmin.php");
                    } else {
                        include("$page.php");
                    }
                } else {
                    include("chartjsadmin.php");
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
                                        <select class="form-control show-tick" name="depart" id="depart" data-live-search="true" data-size="6" data-dropup-auto="false" required>
                                            <option value="">-- Pilih Departemen --</option>
                                            <?php
                                            $in = mysqli_query($connect, "select id_kriteria,nama from kriteria order by nama");
                                            while ($row1 = mysqli_fetch_array($in)) { ?>
                                                <option value="<?php echo $row1['nama']; ?>"><?php echo $row1['nama']; ?></option><?php
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
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                                    <i class="material-icons">close</i> CLOSE
                                </button>
                                <button type="submit" class="btn btn-primary waves-effect">
                                    <i class="material-icons">save</i> SAVE
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <!-- Bootstrap Notify Plugin Js -->
    <script src="../plugins/bootstrap-notify/bootstrap-notify.js"></script>

    <!-- Jquery Spinner Plugin Js -->
    <script src="../plugins/jquery-spinner/js/jquery.spinner.js"></script>

    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="../plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- noUISlider Plugin Js -->
    <script src="../plugins/nouislider/nouislider.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="../plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="../plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="../plugins/raphael/raphael.min.js"></script>
    <script src="../plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="../plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="../plugins/flot-charts/jquery.flot.js"></script>
    <script src="../plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="../plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="../plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="../plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Autosize Plugin Js -->
    <script src="../plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Colorpicker Js -->
    <script src="../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

    <!-- Dropzone Plugin Js -->
    <script src="../plugins/dropzone/dropzone.js"></script>

    <!-- Input Mask Plugin Js -->
    <script src="../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->

    <script src="../js/admin.js"></script>
    <script src="../js/pages/forms/basic-form-elements.js"></script>
    <script src="../js/pages/tables/jquery-datatable.js"></script>
    <script src="../js/pages/index.js"></script>
    <script src="../js/pages/ui/modals.js"></script>
    <script src="../js/pages/forms/advanced-form-elements.js"></script>
    <script src="../js/pages/forms/form-validation.js"></script>

    <!-- Demo Js -->
    <script src="../js/demo.js"></script>

    <script>
        $(function() {
            // Konfigurasi Bootstrap-Select global
            if ($.fn.selectpicker) {
                $.fn.selectpicker.defaults = $.extend($.fn.selectpicker.defaults || {}, {
                    dropupAuto: false,
                    size: 6
                });
            }

            if (typeof initDashboardLineChart === 'function') {
                initDashboardLineChart();
            }
            if (typeof initDetailCharts === 'function') {
                initDetailCharts();
            }

            function cleanSelectTooltips() {
                $('.bootstrap-select button.dropdown-toggle').each(function() {
                    $(this).removeAttr('title').removeAttr('data-original-title');
                });
            }

            function cleanTableHeaders() {
                $('table.dataTable thead th').each(function() {
                    var txt = $.trim($(this).text()).toLowerCase();
                    if (txt === 'aksi' || txt === 'action') {
                        $(this).addClass('no-sort-col');
                    }
                });
            }
            cleanSelectTooltips();
            cleanTableHeaders();
            $(document).on('loaded.bs.select changed.bs.select rendered.bs.select', cleanSelectTooltips);
            $('select').on('change', cleanSelectTooltips);
            $(document).on('init.dt draw.dt', cleanTableHeaders);

            // Accordion effect: Hanya 1 detail collapse yang terbuka bergantian dalam tabel
            $(document).off('show.bs.collapse.tableAccordion').on('show.bs.collapse.tableAccordion', '.table .collapse', function() {
                var $table = $(this).closest('.table');
                $table.find('.collapse.in').not(this).collapse('hide');
            });

            // Transisi loading alldata jika ada
            if ($('#loading-alldata').length) {
                setTimeout(function() {
                    $('#loading-alldata').fadeOut(200, function() {
                        $(this).remove();
                        $('#table-wrapper-alldata').fadeIn(200, function() {
                            $('.js-basic-example').each(function() {
                                if ($.fn.dataTable.isDataTable(this)) {
                                    $(this).DataTable().columns.adjust().responsive.recalc();
                                }
                            });
                        });
                    });
                }, 300);
            }
        });
    </script>
    <!-- Theme Toggle Engine -->
    <script src="../js/theme-toggle.js?v=<?php echo filemtime(__DIR__ . '/../js/theme-toggle.js'); ?>"></script>
</body>

</html>