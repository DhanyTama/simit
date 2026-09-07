<?php
// wa_functions.php - Fungsi kirim WhatsApp via API

/**
 * Kirim pesan WhatsApp via API
 * @param string $pesan Pesan yang akan dikirim
 * @param string $nohp Nomor tujuan (format: 628xxx)
 * @return array ['success' => bool, 'message' => string, 'data' => mixed]
 */
function sendtonum($pesan, $nohp) {
    // Validasi format nomor HP (harus 62, angka saja, min 11 digit)
    $nohp = trim(preg_replace('/[^0-9]/', '', $nohp));
    if (!preg_match('/^62[0-9]{9,13}$/', $nohp)) {
        return [
            'success' => false, 
            'message' => 'Format nomor HP tidak valid. Gunakan format: 628xxxxxxxxxx',
            'data' => null
        ];
    }
    
    // Konfigurasi API
    $config = [
        'url' => "https://api-wa.rsanwarmedika.com",
        'session' => "hpit",
        'key' => getenv('WA_API_KEY') ?: "Bayuruwet123!",
    ];
    
    $destination = $nohp . "@c.us";
    
    try {
        $send = sendWaMessage(
            $config['url'], 
            $config['session'], 
            $config['key'], 
            $destination, 
            $pesan
        );
        
        $responseData = json_decode($send['body'], true);
        $httpCode = $send['status'];
        
        if ($httpCode >= 200 && $httpCode < 300 && !empty($responseData['success'])) {
            return [
                'success' => true,
                'message' => 'Pesan berhasil dikirim',
                'data' => $responseData
            ];
        } else {
            error_log("WA API Error: HTTP $httpCode - " . print_r($responseData, true));
            return [
                'success' => false,
                'message' => 'Gagal: ' . ($responseData['message'] ?? 'Unknown error'),
                'data' => $responseData
            ];
        }
        
    } catch (Exception $e) {
        error_log("WA API Exception: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Koneksi gagal: ' . $e->getMessage(),
            'data' => null
        ];
    }
}

function sendWaMessage($baseUrl, $sessionId, $apiKey, $chatId, $content, $contentType = 'string') {
    $url = rtrim($baseUrl, '/') . "/client/sendMessage/" . rawurlencode($sessionId);
    $payload = [
        'chatId'      => $chatId,
        'contentType' => $contentType,
        'content'     => $content,
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => [
            'accept: */*',
            'x-api-key: ' . $apiKey,
            'Content-Type: application/json',
        ],
        CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $res = curl_exec($ch);
    
    if ($res === false) {
        $curlError = curl_error($ch);
        curl_close($ch);
        throw new RuntimeException('cURL error: ' . $curlError);
    }
    
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['status' => $status, 'body' => $res];
}
?>