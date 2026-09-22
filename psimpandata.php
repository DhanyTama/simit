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
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Validasi Gagal',
        text: 'Nama, Departemen, dan Description wajib diisi!',
        icon: 'warning'
    }).then(function() {
        window.location.href = 'index.php';
    });
    </script></body></html>";
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
        
        // Redirect dengan pesan sukses SweetAlert2 CDN
        echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
        Swal.fire({
            title: 'Berhasil Tersimpan',
            text: 'Data Maintenance/Request/Trouble IT TERSIMPAN!',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        }).then(function() {
            window.location.href = 'index.php';
        });
        </script></body></html>";
    } else {
        // Log error database (tidak ditampilkan ke user)
        error_log("DB Insert Error: " . mysqli_stmt_error($query));
        echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
        Swal.fire({
            title: 'Gagal Menyimpan',
            text: 'Gagal menyimpan ke database. Hubungi administrator.',
            icon: 'error'
        }).then(function() {
            window.location.href = 'index.php';
        });
        </script></body></html>";
    }
    
    // Close statement
    mysqli_stmt_close($query);
} else {
    // Log error prepare
    error_log("DB Prepare Error: " . mysqli_error($connect));
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'System Error',
        text: 'System error. Hubungi administrator.',
        icon: 'error'
    }).then(function() {
        window.location.href = 'index.php';
    });
    </script></body></html>";
}

// Close connection (opsional, akan auto-close di akhir script)
// mysqli_close($connect);
?>