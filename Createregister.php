<?php

require_once('Connections/koneksi.php');
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	$nama = $_POST['nama'];
	$deskripsi_diri = $_POST['deskripsi_diri'];
	$last_login = $_POST['last_login'];
	//die(print_r($_POST));

	if ($password != $password2){
		die("kata sandi harus sama");
	}
	$query = "INSERT INTO `anggota` (`id_anggota`, `email`, `password`, `nama`, `deskripsi_diri`, `last_login`) VALUES (NULL, '".$email."', '".$password."', '".$nama."', '".$deskripsi_diri."', '".$last_login."');";
	//die($query);
	$hasil = $koneksi->query($query);
	if($hasil){
		echo ("INPUT DATA BERHASIL");
		header("Location: http://localhost/miniblog/Masuk.php");
	}else{
		echo ("INPUT DATA GAGAL");
		}
	//die(print_r($koneksi));
?>