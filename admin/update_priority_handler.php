<?php
// update_priority_handler.php - AJAX handler untuk mengubah prioritas tiket IT
while (ob_get_level()) {
    ob_end_clean();
}
ob_start();

header('Content-Type: application/json');

// === AUTO-DETECT PATH CONN.PHP ===
if (file_exists(__DIR__ . "/../conn.php")) {
    require_once __DIR__ . "/../conn.php";
} elseif (file_exists(__DIR__ . "/conn.php")) {
    require_once __DIR__ . "/conn.php";
} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/conn.php")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/conn.php";
} else {
    echo json_encode(['success' => false, 'message' => 'Configuration error: conn.php not found']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0;
if ($ticket_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID tiket tidak valid']);
    exit;
}

// Cek tiket ada di database
$check_query = mysqli_query($connect, "SELECT id, tgllapor, nama_prioritas, status FROM pengunjung WHERE id = $ticket_id");
$ticket = mysqli_fetch_assoc($check_query);
if (!$ticket) {
    echo json_encode(['success' => false, 'message' => 'Tiket tidak ditemukan']);
    exit;
}

// Normalisasi input prioritas
$raw_prio = isset($_POST['nama_prioritas']) ? trim((string)$_POST['nama_prioritas']) : '';
$clean_prio = strtoupper($raw_prio);

$final_prio = '';
if (strpos($clean_prio, 'EMERG') !== false) {
    $final_prio = 'EMERGENCY';
} elseif (strpos($clean_prio, 'URGENT') !== false) {
    $final_prio = 'URGENT';
} elseif (strpos($clean_prio, 'HIGH') !== false) {
    $final_prio = 'HIGH PRIORITY';
} elseif (strpos($clean_prio, 'MED') !== false) {
    $final_prio = 'MEDIUM PRIORITY';
} elseif (strpos($clean_prio, 'LOW') !== false) {
    $final_prio = 'LOW PRIORITY';
} else {
    $final_prio = ''; // Dikosongkan
}

// Update ke database pengunjung
$prio_escaped = mysqli_real_escape_string($connect, $final_prio);
$update_sql = "UPDATE pengunjung SET nama_prioritas = '$prio_escaped' WHERE id = $ticket_id";
$update_success = mysqli_query($connect, $update_sql);

if (!$update_success) {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui prioritas: ' . mysqli_error($connect)]);
    exit;
}

// Sinkronkan data ke tb_grafik_prioritas jika ada tanggal lapor
$xtgl = $ticket['tgllapor'];
if (!empty($xtgl) && $xtgl !== '0000-00-00') {
    $q_cek = mysqli_query($connect, "SELECT count(tanggal) as jml FROM tb_grafik_prioritas WHERE tanggal = '$xtgl'");
    $r_cek = mysqli_fetch_assoc($q_cek);
    if ($r_cek && intval($r_cek['jml']) > 0) {
        mysqli_query($connect, "UPDATE tb_grafik_prioritas SET 
            EMERGANCY = (SELECT COUNT(nama_prioritas) FROM pengunjung WHERE (nama_prioritas='EMERGANCY' OR nama_prioritas='EMERGENCY') AND tgllapor = '$xtgl'),
            URGENT = (SELECT COUNT(nama_prioritas) FROM pengunjung WHERE nama_prioritas='URGENT' AND tgllapor = '$xtgl'),
            HIGH = (SELECT COUNT(nama_prioritas) FROM pengunjung WHERE (nama_prioritas='HIGH PRIORITY' OR nama_prioritas='HIGH') AND tgllapor = '$xtgl'),
            MEDIUM = (SELECT COUNT(nama_prioritas) FROM pengunjung WHERE (nama_prioritas='MEDIUM PRIORITY' OR nama_prioritas='MEDIUM') AND tgllapor = '$xtgl'),
            LOW = (SELECT COUNT(nama_prioritas) FROM pengunjung WHERE (nama_prioritas='LOW PRIORITY' OR nama_prioritas='LOW') AND tgllapor = '$xtgl')
            WHERE tanggal = '$xtgl'");
    }
}

echo json_encode([
    'success' => true,
    'message' => 'Prioritas berhasil diperbarui!',
    'ticket_id' => $ticket_id,
    'new_priority' => $final_prio
]);
exit;
