<?php
include "conn.php";
date_default_timezone_set('Asia/Jakarta');
$pelapor	= $_POST['pelapor'];
$departemen	= $_POST['depart'];
$desc 		= $_POST['description'];
$nohp 		= $_POST['nohp'];

$query3 = mysqli_query($connect,"INSERT INTO tb_laporan (id, nama, unit, keterangan,nohp) 
				VALUES ('', '$pelapor', '$departemen', '$desc','$nohp')");

if ($query3){
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Berhasil Tersimpan',
        text: 'DATA MASUKAN DAN SARAN SIMRS NEW TERSIMPAN!',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    }).then(function() {
        window.location.href = 'index.php';
    });
    </script></body></html>";
} else {
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Gagal Menyimpan',
        text: 'DATA MASUKAN DAN SARAN SIMRS NEW GAGAL TERSIMPAN!',
        icon: 'error'
    }).then(function() {
        window.location.href = 'index.php';
    });
    </script></body></html>";
}
?>