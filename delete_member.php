<?php

// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

session_start();
// die(print_r($_SESSION['current_anggota']));
// cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: ../wartaberita1.0/admin.php');
	die;
}
require_once('Connections/koneksi.php');
$user = mysqli_fetch_array($koneksi->query("SELECT `no_induk`,`nama`,`status`,`last_login`, `password` FROM `anggota` WHERE `no_induk` NOT IN ('".$_POST['no_induk']."')"));

if($_POST['status'] == 'Wartawan' || $_POST['status'] == 'Koordinator Lapangan'){
$update = $koneksi->query("DELETE FROM `anggota` WHERE `nama` = '".$_POST['nama']."' AND `no_induk` = '".$_POST['no_induk']."'");
	$_SESSION['success'] = 'Anggota berhasil dihapus';
	echo '<script> window.location.href = "admin.php" </script>';
	die;
}

else{
	$_SESSION['errors'] = 'Terjadi kegagalan';
	die;
	echo '<script> window.location.href = "admin.php" </script>';
	die;
}