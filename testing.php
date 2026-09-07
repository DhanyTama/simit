<?php 
include "wa.php";

$submission = $_GET['pesan'];

if(!$submission)
{
    echo 'pesan tidak ditemukan';
    die();
}
try {
    $r = sendgroup($submission);
    var_dump($r);
} catch (Exception $e) {
    echo $e->getMessage();
}