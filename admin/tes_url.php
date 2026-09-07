<?php
// test_url_shortener.php - PHP 7 Compatible
require_once 'url_shortener.php';

function str_starts_with_php7($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}

function str_contains_php7($haystack, $needle) {
    return $needle !== '' && strpos($haystack, $needle) !== false;
}

echo "=== Shlink URL Shortener Test (PHP " . PHP_VERSION . ") ===\n\n";

$shortener = new UrlShortener();

// Test 1: Shorten dengan custom slug
echo "🔹 Test 1: Custom Slug\n";
$long1 = "https://form.rsanwarmedika.com/forms/feedbackit?test=1";
$result1 = $shortener->shorten($long1, 'fb-test-001');
echo "   Long:  $long1\n";
echo "   Short: " . ($result1['shortUrl'] ?? 'FAILED') . "\n";
echo "   Status: " . ($result1['success'] ? '✅ SUCCESS' : '❌ FAILED') . "\n";
echo "   Message: {$result1['message']}\n";
if (!empty($result1['debug'])) {
    echo "   Debug: {$result1['debug']}\n";
}
echo "   HTTP Code: " . ($result1['httpCode'] ?? 'N/A') . "\n\n";

// Test 2: Shorten dengan auto-slug (fallback test)
echo "🔹 Test 2: Auto Slug (Fallback Test)\n";
$long2 = "https://form.rsanwarmedika.com/forms/feedbackit?eec382ce-3874-42c2-9271-ab2f0838c0c8=demo&ea6710ff-c1a0-475b-a751-ca6aed483200=IT";
$result2 = $shortener->shortenOrOriginal($long2);
echo "   Long:  " . substr($long2, 0, 80) . "...\n";
echo "   Result: " . (strlen($result2) > 80 ? substr($result2, 0, 80) . "..." : $result2) . "\n";
$isShortened = str_starts_with_php7($result2, 'https://short.rsanwarmedika.com/');
echo "   Is shortened: " . ($isShortened ? '✅ YES' : '❌ NO (fallback to original)') . "\n\n";

// Test 3: Invalid URL handling
echo "🔹 Test 3: Invalid URL\n";
$result3 = $shortener->shorten('not-a-valid-url');
echo "   Status: " . ($result3['success'] ? '✅ (unexpected)' : '❌ Expected failure') . "\n";
echo "   Message: {$result3['message']}\n\n";

// Test 4: Redirect verification (jika shorten sukses)
if ($result1['success']) {
    echo "🔹 Test 4: Redirect Verification\n";
    $ch = curl_init($result1['shortUrl']);
    curl_setopt_array($ch, [
        CURLOPT_NOBODY => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $location = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    
    echo "   HTTP Code: $httpCode\n";
    echo "   Redirect: " . ($httpCode == 302 ? '✅ 302 Found' : "❌ Code $httpCode") . "\n";
    echo "   Target: " . (str_contains_php7($location, 'feedbackit') ? '✅ Correct' : '❌ Wrong') . "\n";
}

echo "\n=== Test Complete ===\n";
?>