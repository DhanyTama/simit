<?php
include "../conn.php";
$id = $_GET['kd'];

$query = mysql_query("DELETE FROM data_anggota WHERE id='$id'");
if ($query){
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Berhasil',
        text: 'Data Berhasil dihapus!',
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
        text: 'Data Gagal dihapus!',
        icon: 'error'
    }).then(function() {
        window.location.href = 'anggota.php';
    });
    </script></body></html>";
}
?>