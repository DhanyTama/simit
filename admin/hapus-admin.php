<?php
include "../conn.php";
$user_id = $_GET['kd'];

$query = mysql_query("DELETE FROM admin WHERE user_id='$user_id'");
if ($query){
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Berhasil',
        text: 'Data Berhasil dihapus!',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    }).then(function() {
        window.location.href = 'admin.php';
    });
    </script></body></html>";
} else {
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Gagal',
        text: 'Data Gagal dihapus!',
        icon: 'error'
    }).then(function() {
        window.location.href = 'admin.php';
    });
    </script></body></html>";
}
?>