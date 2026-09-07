<?php
/**
 * url_shortener.php
 * 
 * Helper class untuk shorten URL via Shlink API v5.x
 * Compatible with PHP 7.2+
 * 
 * ⚠️ PENTING: Shlink v5.x menggunakan header "X-Api-Key" untuk authentication
 * 
 * Konfigurasi:
 * - Shlink URL: https://short.rsanwarmedika.com
 * - API Key: ba314d0f-c477-481f-a3bd-c514bb1649eb
 */

class UrlShortener {
    private $baseUrl = 'https://short.rsanwarmedika.com';
    private $apiKey = 'ba314d0f-c477-481f-a3bd-c514bb1649eb';  // ✅ API Key Shlink v5
    private $timeout = 15;
    
    public function __construct($baseUrl = null, $apiKey = null) {
        if ($baseUrl !== null) {
            $this->baseUrl = rtrim($baseUrl, '/');
        }
        if ($apiKey !== null) {
            $this->apiKey = $apiKey;
        }
    }
    
    /**
     * PHP 7 compatible str_starts_with replacement
     */
    private function strStartsWith($haystack, $needle) {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
    
    /**
     * PHP 7 compatible str_contains replacement
     */
    private function strContains($haystack, $needle) {
        return $needle !== '' && strpos($haystack, $needle) !== false;
    }
    
    /**
     * Build HTTP headers untuk Shlink API v5.x
     * @return array
     */
    private function getHeaders($contentType = 'application/json') {
        return [
            'X-Api-Key: ' . $this->apiKey,      // ✅ Shlink v5: gunakan X-Api-Key
            'Content-Type: ' . $contentType,
            'Accept: application/json',
            'User-Agent: Shlink-Client/1.0',
        ];
    }
    
    public function shorten($longUrl, $customSlug = null, $extraParams = []) {
        // Validasi input dasar
        if (empty($longUrl) || !filter_var($longUrl, FILTER_VALIDATE_URL)) {
            return [
                'success' => false,
                'shortUrl' => null,
                'shortCode' => null,
                'message' => 'Invalid URL format',
                'rawResponse' => null,
                'httpCode' => null,
                'debug' => 'Invalid URL: ' . $longUrl
            ];
        }
        
        $endpoint = $this->baseUrl . '/rest/v2/short-urls';
        
        // Payload untuk Shlink API v5.x
        $payload = [
            'longUrl' => $longUrl,
            'findIfExists' => true,  // Reuse jika URL sama sudah pernah dibuat
        ];
        
        if ($customSlug !== null && $customSlug !== '') {
            $customSlug = preg_replace('/[^a-zA-Z0-9\-_]/', '', $customSlug);
            if (!empty($customSlug)) {
                $payload['customSlug'] = $customSlug;
            }
        }
        
        if (is_array($extraParams) && !empty($extraParams)) {
            $payload = array_merge($payload, $extraParams);
        }
        
        $ch = curl_init($endpoint);
        
        // Debug: log payload sebelum kirim
        error_log("Shlink Request to: $endpoint");
        error_log("Shlink Payload: " . json_encode($payload, JSON_UNESCAPED_SLASHES));
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER => $this->getHeaders(),  // ✅ Gunakan header yang benar
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_FOLLOWLOCATION => false,
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);
        
        curl_close($ch);
        
        // Debug: log response mentah
        error_log("Shlink Response HTTP Code: $httpCode");
        error_log("Shlink Response Raw: " . substr($response, 0, 500));
        
        // Handle cURL errors
        if ($curlErrno !== CURLE_OK) {
            $debugInfo = "cURL Error (errno $curlErrno): $curlError | URL: $endpoint";
            error_log("Shlink cURL failed: $debugInfo");
            return [
                'success' => false,
                'shortUrl' => null,
                'shortCode' => null,
                'message' => 'Connection error: ' . $curlError,
                'rawResponse' => null,
                'httpCode' => $httpCode,
                'debug' => $debugInfo
            ];
        }
        
        // Decode JSON response
        $data = @json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $debugInfo = "JSON decode error: " . json_last_error_msg() . " | Raw: " . substr($response, 0, 200);
            error_log("Shlink JSON error: $debugInfo");
            return [
                'success' => false,
                'shortUrl' => null,
                'shortCode' => null,
                'message' => 'Invalid API response format',
                'rawResponse' => null,
                'httpCode' => $httpCode,
                'debug' => $debugInfo
            ];
        }
        
        // Check HTTP status code (2xx = success)
        if ($httpCode >= 200 && $httpCode < 300) {
            if (!empty($data['shortUrl']) && !empty($data['shortCode'])) {
                return [
                    'success' => true,
                    'shortUrl' => $data['shortUrl'],
                    'shortCode' => $data['shortCode'],
                    'message' => 'URL successfully shortened',
                    'rawResponse' => $data,
                    'httpCode' => $httpCode,
                    'debug' => null
                ];
            }
        }
        
        // Handle API errors - extract detailed error message
        $errorMessage = 'Unknown API error';
        if (is_array($data)) {
            if (!empty($data['error'])) {
                $errorMessage = $data['error'];
            } elseif (!empty($data['message'])) {
                $errorMessage = $data['message'];
            } elseif (!empty($data['detail'])) {
                $errorMessage = $data['detail'];
            }
            
            // Tambahkan error details jika ada
            if (!empty($data['details']) && is_array($data['details'])) {
                $errorMessage .= ' | Details: ' . json_encode($data['details']);
            }
            if (!empty($data['invalidElements']) && is_array($data['invalidElements'])) {
                $errorMessage .= ' | Invalid: ' . json_encode($data['invalidElements']);
            }
        }
        
        $debugInfo = "HTTP $httpCode: $errorMessage | Response: " . json_encode($data);
        error_log("Shlink API error: $debugInfo");
        
        return [
            'success' => false,
            'shortUrl' => null,
            'shortCode' => null,
            'message' => $errorMessage,
            'rawResponse' => $data,
            'httpCode' => $httpCode,
            'debug' => $debugInfo
        ];
    }
    
    public function generateSlug($longUrl, $prefix = 'url') {
        $hash = substr(md5($longUrl), 0, 8);
        $timestamp = substr(time(), -4);
        $prefix = preg_replace('/[^a-zA-Z0-9\-_]/', '', $prefix);
        $prefix = !empty($prefix) ? $prefix . '-' : '';
        return $prefix . $hash . '-' . $timestamp;
    }
    
    public function shortenOrOriginal($longUrl, $customSlug = null, $extraParams = []) {
        $result = $this->shorten($longUrl, $customSlug, $extraParams);
        
        if ($result['success']) {
            return $result['shortUrl'];
        }
        
        // Log warning dengan detail error
        error_log("Shlink shorten failed: {$result['message']} | Debug: {$result['debug']}");
        
        return $longUrl;
    }
    
    public function getVisits($shortCode, $params = []) {
        $endpoint = $this->baseUrl . '/rest/v2/visits/' . urlencode($shortCode);
        
        if (!empty($params) && is_array($params)) {
            $endpoint .= '?' . http_build_query($params);
        }
        
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $this->getHeaders('application/json'),  // ✅ Header benar
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return @json_decode($response, true);
        }
        
        error_log("Shlink visits API error (HTTP $httpCode) for shortCode: $shortCode");
        return null;
    }
    
    public function delete($shortCode) {
        $endpoint = $this->baseUrl . '/rest/v2/short-urls/' . urlencode($shortCode);
        
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $this->getHeaders('application/json'),  // ✅ Header benar
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return ($httpCode >= 200 && $httpCode < 300);
    }
    
    public function getBaseUrl() {
        return $this->baseUrl;
    }
    
    public function setTimeout($seconds) {
        $this->timeout = max(5, min(120, intval($seconds)));
        return $this;
    }
}
?>