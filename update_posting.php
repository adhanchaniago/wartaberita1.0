<?php

// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

session_start();
// cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: http://localhost/wartaberita1.0/');
	die;
}

require_once('Connections/koneksi.php');

$id_kategori = $_POST['id_kategori'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$file_gambar =$_POST['file_gambar'];
$tanggal_posting = date('Y-m-d');
$no_induk = $_SESSION['current_id'];



$updatePosting = $koneksi->query("UPDATE `posting` SET `judul` = '$judul', `deskripsi` = '$deskripsi', `id_kategori` = '$id_kategori', `file_gambar` = '$file_gambar' WHERE `id_posting` = '$id_posting' AND `id_anggota` = '".$_SESSION['current_id']."'");

header('Location: http://localhost/wartaberita1.0/riwayat_berita.php');
