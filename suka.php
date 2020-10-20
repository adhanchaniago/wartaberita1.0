<?php

// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

session_start();
// cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: http://localhost/miniblog/');
	die;
}
require_once('Connections/koneksi.php');

$is_like = $_POST['is_like'];
$is_dislike = (int) !$_POST['is_like'];
$id_posting = $_POST['id_posting'];
$id_anggota = $_SESSION['current_id'];

// query hapus baris like id_anggota dan id_posting yang dimaksud lalu insert kembali ke dalam tabel like
$koneksi->multi_query(
    "DELETE FROM `like` WHERE `id_anggota` = '$id_anggota' AND `id_posting` = '$id_posting'; INSERT INTO `like` (`id_anggota`, `id_posting`, `is_like`, `is_dislike`) VALUES ('$id_anggota', '$id_posting', '$is_like', '$is_dislike')"
);

// redirect ke halaman sebelumnya jika ada
if (isset($_SERVER['HTTP_REFERER'])) {
	header('Location: '. $_SERVER['HTTP_REFERER']);
	die;
}
header('Location: http://localhost/miniblog/index.php');