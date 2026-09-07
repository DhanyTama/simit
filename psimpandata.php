<?php
include "conn.php";
include "wa.php"; // Pastikan nama file benar: whatsapp.php atau wa_functions.php

date_default_timezone_set('Asia/Jakarta');

// Validasi: Jika form tidak disubmit via POST, redirect
if (!isset($_POST['pelapor'])) {
    header("Location: index.php");
    exit();
}

// Ambil dan sanitasi input dasar (trim whitespace)
$pelapor    = trim($_POST['pelapor'] ?? '');
$departemen = trim($_POST['depart'] ?? '');
$desc       = trim($_POST['description'] ?? '');
$nohp       = trim($_POST['nohp'] ?? '');

// Validasi field wajib
if (empty($pelapor) || empty($departemen) || empty($desc)) {
    echo "<script>alert('Nama, Departemen, dan Description wajib diisi!'); window.location = 'index.php';</script>";
    exit();
}

// Generate data sistem
$tgllapor   = date('Y-m-d');
$jamlapor   = date('H:i:s');
$status     = "Open";
$ipclient   = $_SERVER['REMOTE_ADDR'];

// === ✅ INSERT MENGGUNAKAN PREPARED STATEMENT (Anti SQL Injection + Handle Kutip) ===
$query = mysqli_prepare($connect, "
    INSERT INTO pengunjung 
    (nama, depart, jnskendala, tgllapor, jamlapor, petugas, status, ipclient, nohp) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if ($query) {
    // Bind parameter: s = string, semua field di sini adalah string
    mysqli_stmt_bind_param($query, "sssssssss", 
        $pelapor, 
        $departemen, 
        $desc, 
        $tgllapor, 
        $jamlapor, 
        $status, 
        $status,    // petugas diisi 'Open' sesuai kode asli
        $ipclient, 
        $nohp
    );
    
    // Eksekusi query
    if (mysqli_stmt_execute($query)) {
        $insert_id = mysqli_insert_id($connect);
        
        // ✅ Simpan pesan ke JSON file (jika fungsi ada)
        if (function_exists('saveFormDataToJson')) {
            $message = "[SIMIT] [$pelapor] [$departemen] : $desc";
            saveFormDataToJson($message);
        }
        
        // Redirect dengan pesan sukses
        echo "<script>alert('✅ Data Maintenance/Request/Trouble IT TERSIMPAN!'); window.location = 'index.php';</script>";
    } else {
        // Log error database (tidak ditampilkan ke user)
        error_log("DB Insert Error: " . mysqli_stmt_error($query));
        echo "<script>alert('❌ Gagal menyimpan ke database. Hubungi administrator.'); window.location = 'index.php';</script>";
    }
    
    // Close statement
    mysqli_stmt_close($query);
} else {
    // Log error prepare
    error_log("DB Prepare Error: " . mysqli_error($connect));
    echo "<script>alert('❌ System error. Hubungi administrator.'); window.location = 'index.php';</script>";
}

// Close connection (opsional, akan auto-close di akhir script)
// mysqli_close($connect);
?>