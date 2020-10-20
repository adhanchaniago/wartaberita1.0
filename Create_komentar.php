<?php
// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

session_start();

// cek jika anggota belum login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: http://localhost/wartaberita1.0/');
	die;
}

require_once('Connections/koneksi.php');

$id_posting = $_POST['id_posting'];
$id_anggota = $_SESSION['current_id'];
$isi_komentar = $_POST['isi_komentar'];

$query = "INSERT INTO `komentar` (`id_posting`, `id_anggota`, `isi_komentar`) VALUES ('$id_posting', '$id_anggota', '$isi_komentar')";
$hasil = $koneksi->query($query);

if (isset($_SERVER['HTTP_REFERER'])) {
	header('Location: '. $_SERVER['HTTP_REFERER']);
	die;
}

header('Location: http://localhost/wartaberita1.0/wartawan.php');
?>