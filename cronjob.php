<?php
include "wa.php";
// Read JSON file
$jsonData = file_get_contents('laporan.json');
$no = file_get_contents('nohp.json');
// Decode JSON data
$data = json_decode($jsonData, true);
$listhp = json_decode($no);
 
if ($no === false) {
    die("Gagal membaca nohp.json\n");
}
 
// Check if JSON decoding was successful
if ($data !== null) { 

    // kodesendwa
// 	 $no=['6281358887147','62895366832390','6285784406018','6285745449374'];
// 	$message = "[SIMIT] [$pelapor] [$departemen] : $desc";
// 	foreach ($no as $phone) {
// 		sendwa($phone,$message);		 
// 		usleep(500000);  //0.5second
// 	}
	// END kodesendwa
    
    // Iterate over each form submission
    // Set the default timezone if it's not already set
    date_default_timezone_set('Asia/Jakarta'); // You can set it to your desired timezone

    // Get the current time
    $current_time = date('Y-m-d H:i:s');

    $error = [];
    foreach ($data as $submission) {
        echo $submission.'<br>';
        // foreach ($listhp as $phone) {
        // 	$response=sendwa($phone,$submission);	
        //     if($response === false)	 {
        //         saveLogJson($current_time.' '.$phone);
        //     }    
        // 	sleep(5);  //delay 5second
        // }
         sleep(5);  //delay 5 seconds
         try {
            $r = sendgroup($submission);
            var_dump($r);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        // if($group_response === false )	 
        // {
        //     $error[]=$submission;
        //     saveLogJson($current_time.'- Gagal Dikirim -'.$submission);
        // }
        
    }   

   
    
    // Empty the JSON file by overwriting it with an empty array
    file_put_contents('laporan.json', json_encode($error));
    
} else {
    echo "Failed to decode JSON data.";
}
?>



 