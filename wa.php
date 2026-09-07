<?php 


// Parameters
// $no = '6285730534634';
// $pesan = 'xxx';

// sendwa($no,$pesan);
// current active uuid 


function sendwa($no,$pesan){
    echo 'mengirim pesan '.$no.'<br>';
    // URL to hit
    $url = 'http://192.168.0.196/waweb/sendwa.php';

    // Build query string
    $queryString = http_build_query([
        'no' => $no,
        'pesan' => $pesan
    ]);

    // Final URL with query string
    $urlWithQuery = $url . '?' . $queryString;
    echo $urlWithQuery.'<br>';

    // Send request
    $response = file_get_contents($urlWithQuery);

    // Output response
    return $response;
}

function saveFormDataToJson($text) {
    
    // Read existing JSON file
    $jsonData = file_get_contents('laporan.json');

    // Decode JSON data
    $data = json_decode($jsonData, true);

    // Append new form data to the array
    $data[] = $text;

    // Encode updated data
    $updatedData = json_encode($data);

    // Save updated data back to JSON file
    file_put_contents('laporan.json', $updatedData);
    
}

function saveLogJson($text) {
    
    // Read existing JSON file
    $jsonData = file_get_contents('log.json');

    // Decode JSON data
    $data = json_decode($jsonData, true);

    // Append new form data to the array
    $data[] = $text;

    // Encode updated data
    $updatedData = json_encode($data);

    // Save updated data back to JSON file
    file_put_contents('log.json', $updatedData);
    
}

function sendgroup($pesan){
    $uuid = "e57f3325-30ac-44aa-8f0c-1fe712361e02";

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // URL to hit
   // $url = 'http://192.168.0.196/waweb/sendwa.php';
  
    // $group = file_get_contents('group.json');
    // $listgroup = json_decode($group);
    $error=[];
    
    $url ="https://api-wa.rsanwarmedika.com";
    $session = "hpit";
    $key = "Bayuruwet123!";
    $groupid= "120363277088393581@g.us";
    
      $r = true;
    $send = sendWaMessage($url,$session,$key,$groupid,$pesan);
    $response = $send['body'];
        // Check for cURL errors
        if ($response === false) {
            $r = false;
            // echo 'cURL error: ' . curl_error($curl);
            $error[]="group ".$gg." : Error";
        } else {
            // Get cURL information
            $info = $response['status'];

            
            
        }

        // Close cURL session
        
        
        // echo json_encode($error);
        return $r;

    

    
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
    ]);

    $res = curl_exec($ch);
    if ($res === false) {
        throw new RuntimeException('cURL error: ' . curl_error($ch));
    }
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['status' => $status, 'body' => $res];
}


 
 
?>