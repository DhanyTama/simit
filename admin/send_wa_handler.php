<?php
// send_wa_handler.php - Handler AJAX untuk kirim WhatsApp via API + Fallback Copy

// ✅ CLEAR ALL OUTPUT BUFFERS (PENTING!)
while (ob_get_level()) { ob_end_clean(); }
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
    error_log("conn.php not found in send_wa_handler.php!");
    echo json_encode(['success' => false, 'message' => 'Configuration error: conn.php not found']);
    exit;
}

// Include fungsi WhatsApp dan URL Shortener
require_once __DIR__ . "/../wa_functions.php";
require_once __DIR__ . "/url_shortener.php";

// Validasi method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Ambil dan sanitasi input
$ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0;
if ($ticket_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid ticket ID']);
    exit;
}

// Ambil data ticket dari database (include is_sent untuk validasi)
$query = mysqli_prepare($connect, "SELECT nama, depart, nohp, jnskendala, is_sent FROM pengunjung WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $ticket_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($query);

if (!$data || empty($data['nohp'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan atau nohp kosong']);
    exit;
}

// ✅ Cek apakah pesan sudah pernah dikirim (is_sent = 1)
if (!empty($data['is_sent']) && $data['is_sent'] == 1) {
    echo json_encode(['success' => false, 'message' => 'Pesan WhatsApp untuk ticket ini sudah pernah dikirim']);
    exit;
}

// === 1. GENERATE FEEDBACK URL (PANJANG) ===
$val_kendala = !empty($data['jnskendala']) ? urlencode($data['jnskendala']) : '';
$val_depart = !empty($data['depart']) ? "&ea6710ff-c1a0-475b-a751-ca6aed483200=" . urlencode($data['depart']) : '';
$feedback_url_long = "https://form.rsanwarmedika.com/forms/feedbackit?eec382ce-3874-42c2-9271-ab2f0838c0c8=" . $val_kendala . $val_depart;

// === 2. SHORTEN URL VIA SHLINK ===
$shortener = new UrlShortener();
$customSlug = 'fb-' . $ticket_id . '-' . substr(md5($feedback_url_long), 0, 6);
$feedback_url = $shortener->shortenOrOriginal($feedback_url_long, $customSlug);

// === 3. BUILD PESAN WHATSAPP (TEKS SESUAI REQUEST ANDA) ===
$nama = addslashes($data['nama']);

// ✅ TRUNCATE KENDALA: Maksimal 40 karakter, jika lebih tambahkan " ***"
$maxLength = 40;
$kendala_raw = $data['jnskendala'];
$kendala = (mb_strlen($kendala_raw, 'UTF-8') > $maxLength) 
    ? mb_substr($kendala_raw, 0, $maxLength, 'UTF-8') . " ***" 
    : $kendala_raw;
$kendala = addslashes($kendala); // Escape untuk keamanan

$wa_pesan = "Halo, *{$nama}* 🙏\n\n" .
            "Kami dari *IT RSU Anwar Medika* menginformasikan bahwa permintaan maintenance/trouble IT Anda:\n" .
            "📋 *\"{$kendala}\"*\n" .
            "telah kami selesaikan ✅\n\n" .
            "🔗 *Mohon kesediaan Anda untuk mengisi form feedback berikut agar layanan kami semakin baik:*\n" .
            "{$feedback_url}\n\n" .
            "Terima kasih atas kepercayaan dan kerjasamanya. 🙏\n\n" .
            "━━━━━━━━━━━━━━━━━━━━\n" .
            "*TIM IT*\n" .
            "🏥 RSU Anwar Medika\n" .
            "📱 167";

// === 4. KIRIM VIA API WHATSAPP ===
$nohp = $data['nohp'];
$hasil = sendtonum($wa_pesan, $nohp);

// === 5. UPDATE is_sent JIKA BERHASIL ===
if ($hasil['success']) {
    // Update kolom is_sent = 1
    $update_query = mysqli_prepare($connect, "UPDATE pengunjung SET is_sent = 1 WHERE id = ?");
    mysqli_stmt_bind_param($update_query, "i", $ticket_id);
    $update_result = mysqli_stmt_execute($update_query);
    mysqli_stmt_close($update_query);
    
    if ($update_result) {
        error_log("✅ WA sent + is_sent updated | Ticket #{$ticket_id} | To: {$nohp} | ShortURL: {$feedback_url}");
    } else {
        error_log("⚠️ WA sent but is_sent update FAILED | Ticket #{$ticket_id}");
    }
} else {
    error_log("❌ WA failed | Ticket #{$ticket_id} | To: {$nohp} | Error: {$hasil['message']}");
}

// === 6. OUTPUT JSON FINAL (Dengan message_text untuk fallback copy) ===
$response = [
    'success' => $hasil['success'],
    'message' => $hasil['message'],
    'data' => $hasil['data'] ?? null,
];

// ✅ TAMBAHKAN: Sertakan pesan teks untuk fallback copy ke clipboard
// Selalu sertakan message_text agar bisa digunakan saat error atau debug
$response['message_text'] = $wa_pesan;  // Pesan lengkap yang sudah diformat WhatsApp
$response['nohp'] = $nohp;              // Nomor tujuan untuk referensi manual

ob_end_clean();
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>