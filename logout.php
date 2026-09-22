<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            title: 'Berhasil Keluar',
            text: 'Anda telah berhasil keluar.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        }).then(function() {
            window.location.href = 'index.php';
        });
    </script>
</body>
</html>
