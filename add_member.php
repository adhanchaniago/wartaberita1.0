<?php

// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

session_start();
// die(print_r($_SESSION['current_anggota']));
// cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: ../wartaberita1.0/edit_member.php');
	die;
}
require_once('Connections/koneksi.php');

$check = $koneksi->query("SELECT `anggota`.`no_induk` FROM `anggota` WHERE `no_induk` = '".$_POST['no_induk']."'");
if(!is_numeric($_POST['no_induk'])){
	$_SESSION['errors'] = 'Masukkan NIP dengan angka';
	echo '<script> window.history.go(-1) </script>';
	die;
}

if(mysqli_num_rows($check) != 0){
	$_SESSION['errors'] = 'Anggota sudah memiliki akun';
	echo '<script> window.history.go(-1) </script>';
	die;
}
else{
if($_POST['status'] == 'Wartawan' || $_POST['status'] == 'Koordinator Lapangan'){
	$update = $koneksi->query("INSERT INTO `anggota` (`nama`, `no_induk`, `password`, `status`, `foto_profil`) VALUES ('".$_POST['nama']."' , '".$_POST['no_induk']."' , '".$_POST['password']."', '".$_POST['status']."' , 'avatar-placeholder.png')");
	$_SESSION['success'] = 'anggota berhasil ditambahkan';
	echo '<script> window.history.go(-2) </script>';
	die;
}

if($_POST['status'] == 'Mahasiswa' || $_POST['status'] == 'Dosen'){
	$update = $koneksi->query("INSERT INTO `anggota` (`nama`, `no_induk`, `password`, `status`, `foto_profil`) VALUES ('".$_POST['nama']."' , '".$_POST['no_induk']."' , '".$_POST['password']."', '".$_POST['status']."', 'avatar-placeholder.png')");
		$_SESSION['success'] = 'anggota berhasil ditambahkan';
		echo '<script> window.history.go(-2) </script>';
		die;
	}
}