<?php
$namafolder="gambar_anggota/"; //tempat menyimpan file

include "../conn.php";
$id         = $_POST['id'];
$petugas    = $_POST['petugas'];
$status		= $_POST['status'];
$remote     = $_POST['remote'];
$feedback   = $_POST['feedback'];
$jamselesai = $_POST['jamselesai'];
$tglselesai = $_POST['tglselesai'];

$query = mysql_query("UPDATE pengunjung SET petugas='$petugas', status='$status', remote='$remote', feedback='$feedback', 
	tglselesai='$tglselesai', jamselesai='$jamselesai' WHERE id='$id'");

if ($query){
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Berhasil',
        text: 'Update Sukses.',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    }).then(function() {
        window.location.href = 'anggota.php';
    });
    </script></body></html>";
} else {
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Gagal',
        text: 'Update Gagal.',
        icon: 'error'
    }).then(function() {
        window.location.href = 'anggota.php';
    });
    </script></body></html>";
}
?>