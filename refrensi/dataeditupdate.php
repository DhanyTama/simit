<?php
include "koneksi.php";

$idp=$_POST['idperusahaan'];
echo "$idp";
$query = "update tbperusahaan set nmperusahaan='".addslashes($_POST['perusahaan'])."',alamat='".addslashes($_POST['alamatp'])."',penanggungjwb='".addslashes($_POST['jawabp'])."',kantor='".$_POST['kantorp']."',kantorlain='".$_POST['kantorlainp']."',fax='".$_POST['faxp']."',faxlain='".$_POST['faxlainp']."',hp='".$_POST['hpp']."',hplain='".$_POST['hplainp']."' where id='$idp'";
$hasil = mysql_query($query);
 
if ($hasil) {
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Berhasil',
        text: 'Data Sudah Terupdate!',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    }).then(function() {
        window.location.href = 'index.php?page=dataedit&no=$idp';
    });
    </script></body></html>";
} else {
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body><script>
    Swal.fire({
        title: 'Gagal',
        text: 'Data Gagal di Update',
        icon: 'error'
    }).then(function() {
        window.location.href = 'index.php?page=dataedit';
    });
    </script></body></html>";
}
//&no=$idp
?>