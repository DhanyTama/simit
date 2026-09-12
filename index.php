<?php
include "conn.php";
$is_dark = (isset($_COOKIE['simit_theme']) && $_COOKIE['simit_theme'] === 'dark');
$current_skin = (isset($_COOKIE['simit_skin']) && in_array($_COOKIE['simit_skin'], ['default', 'cappuccino', 'everforest', 'tokyo'])) ? $_COOKIE['simit_skin'] : 'default';
?>
<!DOCTYPE html>
<html class="<?php echo ($is_dark ? 'dark-mode ' : '') . 'skin-' . $current_skin; ?>">

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
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link
        href="plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="plugins/waitme/waitMe.css" rel="stylesheet" />

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

    <!-- Bootstrap Select Css -->
    <link
        href="plugins/bootstrap-select/css/bootstrap-select.css"
        rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all
        themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />


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

    <!-- Custom CSS untuk validasi -->
    <style>
        .is-invalid {
            border-color: #e91e63 !important;
        }

        .is-valid {
            border-color: #4caf50 !important;
        }

        .error-msg {
            color: #e91e63;
            font-size: 11px;
            margin-top: 3px;
            display: none;
        }

        .error-msg.show {
            display: block;
        }

        .form-line.error {
            border-bottom: 2px solid #e91e63;
        }

        .form-line.success {
            border-bottom: 2px solid #4caf50;
        }

        /* Modern UI Overrides */
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

        .theme-red .navbar {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
            border-bottom: none !important;
        }

        .navbar-brand {
            font-weight: 700 !important;
            letter-spacing: 0.5px;
        }

        .sidebar {
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08) !important;
            border-right: none !important;
        }

        .sidebar .user-info {
            padding: 20px 15px 12px 15px;
        }

        /* Modern Cards & Info Boxes */
        .card,
        .info-box {
            border-radius: 16px !important;
            border: none !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        body:not(.dark-mode) .card,
        body:not(.dark-mode) .info-box {
            background-color: #ffffff !important;
        }

        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.12) !important;
        }

        .info-box .icon {
            border-radius: 16px 0 0 16px !important;
        }

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
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
        }

        /* Modern Form Inputs & Textareas with Clear Visible Borders */
        .form-group .form-line {
            border-bottom: none !important;
        }

        .form-group .form-line:after {
            display: none !important;
        }

        .form-group>label.form-label,
        .form-group>label,
        label.form-label {
            display: inline-block !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            color: #374151 !important;
            margin-bottom: 6px !important;
            position: static !important;
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

        /* Modern Panels (For Panduan/Tutorial) */
        .panel-group .panel {
            border-radius: 12px !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05) !important;
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

        /* Modern Tables & Clean Header */
        .table-responsive {
            border: none !important;
            padding: 4px 0 !important;
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

        /* Remove sorting on no-sort columns */
        table.dataTable thead th.no-sort-col:after,
        table.dataTable thead th.no-sort:after {
            display: none !important;
        }

        table.dataTable thead th.no-sort-col,
        table.dataTable thead th.no-sort {
            padding-right: 8px !important;
            cursor: default !important;
            pointer-events: none !important;
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

        /* Global Table Vertical Centering */
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td,
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > td {
            vertical-align: middle !important;
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

        .btn i,
        .btn i.material-icons,
        .btn span {
            position: static !important;
            top: 0 !important;
            left: 0 !important;
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

        .modal-footer .btn {
            height: 38px !important;
            padding: 0 18px !important;
            font-size: 13px !important;
            letter-spacing: 0.5px !important;
            border-radius: 8px !important;
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

        /* DataTable Controls */
        .dataTables_length label {
            display: inline-flex !important;
            align-items: center !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            gap: 6px !important;
        }

        body:not(.dark-mode) .dataTables_length label {
            color: #475569 !important;
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
            border: 1px solid #cbd5e1 !important;
            background-color: #fff !important;
            color: #334155 !important;
        }

        .dataTables_filter label {
            display: inline-flex !important;
            align-items: center !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            gap: 8px !important;
        }

        body:not(.dark-mode) .dataTables_filter label {
            color: #475569 !important;
        }

        div.dataTables_wrapper div.dataTables_filter input,
        .dataTables_filter input.form-control {
            height: 34px !important;
            padding: 6px 12px !important;
            font-size: 13px !important;
            border-radius: 8px !important;
            box-shadow: none !important;
            display: inline-block !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }

        body:not(.dark-mode) div.dataTables_wrapper div.dataTables_filter input,
        body:not(.dark-mode) .dataTables_filter input.form-control {
            border: 1.5px solid #cbd5e1 !important;
            background-color: #fff !important;
            color: #334155 !important;
        }

        div.dataTables_wrapper div.dataTables_filter input:focus,
        .dataTables_filter input.form-control:focus {
            border-color: #2196F3 !important;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.18) !important;
            outline: none !important;
        }

        .dataTables_info {
            font-size: 12.5px !important;
            color: #64748b !important;
            padding-top: 12px !important;
        }

        .dataTables_paginate {
            padding-top: 8px !important;
        }

        .dataTables_paginate .pagination {
            margin: 0 !important;
        }

        .pagination>li>a {
            border-radius: 6px !important;
            margin: 0 2px !important;
            color: #475569 !important;
            font-size: 12.5px !important;
            border: 1px solid #e2e8f0 !important;
        }

        .pagination>.active>a,
        .pagination>.active>a:focus,
        .pagination>.active>a:hover {
            background-color: #f44336 !important;
            border-color: #f44336 !important;
            color: #fff !important;
        }

        /* FIX: Bootstrap-Select */
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

        .bootstrap-select>.dropdown-menu {
            border-radius: 12px !important;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12) !important;
            padding: 6px !important;
            margin-top: 5px !important;
            border: 1px solid #e2e8f0 !important;
            box-sizing: border-box !important;
            min-width: 100% !important;
            z-index: 1060 !important;
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

        .bootstrap-select>.dropdown-menu,
        .bootstrap-select.open>.dropdown-menu,
        .bootstrap-select.dropup>.dropdown-menu,
        .bootstrap-select.dropup.open>.dropdown-menu {
            top: 100% !important;
            bottom: auto !important;
            margin-top: 4px !important;
            margin-bottom: 0 !important;
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
            max-height: 220px !important;
            overflow-y: auto !important;
            scrollbar-width: thin !important;
            scrollbar-color: #cbd5e1 transparent !important;
        }

        .bootstrap-select .dropdown-menu.inner::-webkit-scrollbar {
            width: 6px !important;
            height: 6px !important;
        }

        .bootstrap-select .dropdown-menu.inner::-webkit-scrollbar-track {
            background: transparent !important;
        }

        .bootstrap-select .dropdown-menu.inner::-webkit-scrollbar-thumb {
            background: #cbd5e1 !important;
            border-radius: 4px !important;
        }

        .bootstrap-select .dropdown-menu.inner::-webkit-scrollbar-thumb:hover {
            background: #94a3b8 !important;
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

        .bootstrap-select+.tooltip,
        .bootstrap-select .tooltip {
            display: none !important;
        }
    </style>

    <!-- Dark Mode Css (Loaded after style block to ensure complete priority) -->
    <link href="css/dark-mode.css?v=<?php echo filemtime(__DIR__ . '/css/dark-mode.css'); ?>" rel="stylesheet">
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
                        <a href="index.php?page=tutorial" title="Home / Tutorial">
                            <i class="material-icons">home</i>
                            <span class="icon-name"></span></a>
                    </li>
                    <li>
                        <a href="" data-toggle="modal" data-target="#defaultModal" title="Buat Permintaan MRT - IT">
                            <i class="material-icons">add_circle</i>
                            <span class="icon-name"></span></a>
                    </li>

                    <li>
                        <a href="index.php?page=data" title="Data MRT Hari Ini">
                            <i class="material-icons">today</i>
                            <span class="icon-name"></span></a>
                    </li>
                    <li>
                        <a href="index.php?page=alldata" title="Semua Riwayat MRT Selesai">
                            <i class="material-icons">view_list</i>
                            <span class="icon-name"></span></a>
                    </li>
                    <!-- Theme Toggle Button -->
                    <li>
                        <a href="javascript:void(0);" id="btn-theme-toggle" class="btn-theme-toggle" title="Ganti Mode Gelap / Terang">
                            <i class="material-icons" id="icon-theme-toggle">brightness_2</i>
                            <span class="icon-name"></span>
                        </a>
                    </li>
                    <li>
                        <a href="sign-in.php" title="Login Petugas IT">
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
                        include("tutorial.php");
                    } else {
                        include("$page.php");
                    }
                } else {
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
                                            data-live-search="true"
                                            data-size="6"
                                            data-dropup-auto="false"
                                            required="required">
                                            <option value="">-- Pilih Departemen --</option>
                                            <?php
                                            $in = mysqli_query($connect, "select id_kriteria,nama from kriteria order by nama");
                                            while ($row1 = mysqli_fetch_array($in)) {
                                            ?>
                                                <option value="<?php echo $row1['nama']; ?>"><?php echo $row1['nama']; ?>
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
                                            data-live-search="true"
                                            data-size="6"
                                            data-dropup-auto="false"
                                            required="required">
                                            <option value="">-- Pilih Departemen --</option>
                                            <?php
                                            $in = mysqli_query($connect, "select id_kriteria,nama from kriteria order by nama");
                                            while ($row1 = mysqli_fetch_array($in)) {
                                            ?>
                                                <option value="<?php echo $row1['nama']; ?>"><?php echo $row1['nama']; ?>
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
                if (line) line.classList.remove('error', 'success');
                if (error) error.classList.remove('show');
                return;
            }

            if (isValidPhone(value)) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                if (line) {
                    line.classList.remove('error');
                    line.classList.add('success');
                }
                if (error) error.classList.remove('show');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                if (line) {
                    line.classList.remove('success');
                    line.classList.add('error');
                }
                if (error) error.classList.add('show');
            }
            // Tidak return apa-apa, tidak blocking input lain
        }

        // Validasi saat blur (hanya visual feedback, tidak blocking)
        function validatePhoneOnBlur(inputId, errorId) {
            var input = document.getElementById(inputId);
            var value = input.value.trim();
            var error = document.getElementById(errorId);

            if (value === '') {
                if (input) input.classList.remove('is-invalid', 'is-valid');
                if (error) error.classList.remove('show');
                return;
            }

            if (!isValidPhone(value)) {
                if (input) {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
                if (error) error.classList.add('show');
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
                if (input) {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
                if (error) error.classList.add('show');
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
                            var event = new Event('input', {
                                bubbles: true
                            });
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

    <script>
        $(document).ready(function() {
            // Konfigurasi Bootstrap-Select global
            if ($.fn.selectpicker) {
                $.fn.selectpicker.defaults = $.extend($.fn.selectpicker.defaults || {}, {
                    dropupAuto: false,
                    size: 6
                });
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
    <script src="js/theme-toggle.js?v=<?php echo filemtime(__DIR__ . '/js/theme-toggle.js'); ?>"></script>
</body>

</html>