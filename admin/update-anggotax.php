<?php
$namafolder="gambar_anggota/"; //tempat menyimpan file

include "../conn.php";
$id         = $_POST['id'];
$petugas    = $_POST['petugas'];
$status		= $_POST['status'];
$kerusakan	= $_POST['kerusakan'];
$tindakan	= $_POST['tindakan'];
$tglperbaikan	= $_POST['tglperbaikan'];
$jamperbaikan	= $_POST['jamperbaikan'];

$query = mysql_query("UPDATE pengunjung SET petugas='$petugas', status='$status', kerusakan='$kerusakan', tindakan='$tindakan', tglperbaikan='$tglperbaikan', jamperbaikan='$jamperbaikan' WHERE id='$id'");

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