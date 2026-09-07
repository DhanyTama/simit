<?php
include ("conn.php");
date_default_timezone_set('Asia/Jakarta');

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// $username = mysqli_real_escape_string($username);
// $password = mysqli_real_escape_string($password);

if (empty($username) && empty($password)) {
	header('location:sign-in.php?error1');
	// break;
} else if (empty($username)) {
	header('location:sign-in.php?error=2');
	// break;
} else if (empty($password)) {
	header('location:sign-in.php?error=3');
	// break;
}

$q = mysqli_query($connect,"select * from admin where username='$username' and password='$password'");
$row = mysqli_fetch_array ($q);

if (mysqli_num_rows($q) == 1) {
    $_SESSION['user_id'] = $row['user_id'];
	$_SESSION['username'] = $username;
	$_SESSION['fullname'] = $row['fullname'];
    $_SESSION['gambar'] = $row['gambar'];	

	header('location:admin/index.php');
} else {
	header('location:sign-in.php?error=4');
}
?>