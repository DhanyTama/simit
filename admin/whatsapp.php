<?php
// send_wa_handler.php - Handler untuk AJAX request kirim WhatsApp
header('Content-Type: application/json');
require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../wa_functions.php";

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

// Ambil data ticket dari database
$query = mysqli_prepare($connect, "SELECT nama, depart, nohp, jnskendala FROM pengunjung WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $ticket_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($query);

if (!$data || empty($data['nohp'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan atau nohp kosong']);
    exit;
}

// Generate feedback URL
$val_kendala = !empty($data['jnskendala']) ? urlencode($data['jnskendala']) : '';
$val_depart = !empty($data['depart']) ? "&ea6710ff-c1a0-475b-a751-ca6aed483200=" . urlencode($data['depart']) : '';
$feedback_url = "https://form.rsanwarmedika.com/forms/feedbackit?eec382ce-3874-42c2-9271-ab2f0838c0c8=" . $val_kendala . $val_depart;

// Buat pesan profesional untuk WhatsApp
$nama = addslashes($data['nama']);
$kendala = addslashes($data['jnskendala']);
$wa_pesan = "Halo, *{$nama}* 🙏\n\n" .
            "Kami dari *TIM IT RSU Anwar Medika* menginformasikan bahwa permintaan maintenance/trouble IT Anda:\n" .
            "📋 *\"{$kendala}\"*\n" .
            "telah kami selesaikan ✅\n\n" .
            "🔗 *Mohon kesediaan Anda untuk mengisi form feedback berikut agar layanan kami semakin baik:*\n" .
            "{$feedback_url}\n\n" .
            "Terima kasih atas kepercayaan dan kerjasamanya. 🙏\n\n" .
            "━━━━━━━━━━━━━━━━━━━━\n" .
            "*TIM IT RSAM*\n" .
            "🏥 RSU Anwar Medika\n" .
            "📧 itrsam@example.com";

// Kirim via API WhatsApp
$nohp = $data['nohp'];
$hasil = sendtonum($wa_pesan, $nohp);

// Log aktivitas (opsional)
if ($hasil['success']) {
    error_log("WA sent to {$nohp} for ticket #{$ticket_id}");
} else {
    error_log("WA failed to {$nohp} for ticket #{$ticket_id}: {$hasil['message']}");
}

// Return JSON response
echo json_encode($hasil);
?>