<?php
session_start();
session_destroy();	

    echo "<script>alert('Anda telah berhasil keluar.'); window.location = 'sign-in.php'</script>";
?>