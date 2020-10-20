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
if(!is_numeric($_POST['no_induk'])){
	$_SESSION['errors'] = 'Masukkan NIP dengan angka';
	echo '<script> window.history.go(-1) </script>';
	die;
}
$check = $koneksi->query("SELECT `anggota`.`no_induk` FROM `anggota` WHERE `no_induk` = '".$_POST['no_induk']."'");
if($_GET['no_induk'] != $_POST['no_induk']){
if(mysqli_num_rows($check) != 0){
	$_SESSION['errors'] = 'NIP sudah terdaftar';
	echo '<script> window.history.go(-1) </script>';
	die;
}
}

if($_POST['status'] == 'Wartawan' || $_POST['status'] == 'Koordinator Lapangan'){
		$update = $koneksi->query("UPDATE `anggota` SET `nama` = '".$_POST['nama']."' ,`no_induk` = '".$_POST['no_induk']."' , `password` = '".$_POST['password']."' WHERE `no_induk`= '".$_POST['no_induk']."'");
			$_SESSION['success'] = 'Profil telah diganti';
			echo '<script> window.history.go(-2) </script>';
			die;
		}


else{
	$_SESSION['errors'] = 'Terjadi Kesalahan';
	die;
	echo '<script> window.history.go(-1) </script>';
	die;
}