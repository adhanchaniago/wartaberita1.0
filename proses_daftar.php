<?php

session_start();
// cek jika anggota sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

// validasi input
$errors = [];
if (!isset($_POST['email']))
	$errors['email'] = 'email tidak boleh kosong';
if (!isset($_POST['password']) || !isset($_POST['password2']))
	$errors['password'] = 'password tidak boleh kosong';
elseif ($_POST['password'] != $_POST['password2'])
	$errors['password'] = 'password harus sama';
if (!isset($_POST['nama']))
	$errors['nama'] = 'nama tidak boleh kosong';
if (!isset($_POST['deskripsi_diri']))
	$errors['deskripsi_diri'] = 'deskripsi_diri tidak boleh kosong';

if (count($errors) > 0) {
	$_SESSION['errors'] = $errors;
	header('Location: http://localhost/miniblog/Daftar.php');
	die;
}

require_once('Connections/koneksi.php');

$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$nama = $_POST['nama'];
$deskripsi_diri = $_POST['deskripsi_diri'];
$last_login = date('Y-m-d');
//die(print_r($_POST));

$query = "INSERT INTO `anggota` (`email`, `password`, `nama`, `deskripsi_diri`, `last_login`) VALUES ('".$email."', '".$password."', '".$nama."', '".$deskripsi_diri."', '".$last_login."');";
//die($query);
$hasil = $koneksi->query($query);
if($hasil){
	$_SESSION['notif'] = 'Input data berhasil';
	header("Location: http://localhost/miniblog/Masuk.php");
	die;
}else{
	$_SESSION['notif'] = 'Gagal input data';
	header('Location: http://localhost/miniblog/Daftar.php');
	die;
}
