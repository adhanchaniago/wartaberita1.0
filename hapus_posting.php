<?php
session_start();

// cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: http://localhost/wartaberita1.0/');
	die;
}

// harus ada parameter ?id_posting
if (! isset($_GET['id_posting'])) {
    header('Location: http://localhost/wartaberita1.0/view_posting.php');
	die;
}

require_once('Connections/koneksi.php');

$id_posting = $_GET['id_posting'];
$koneksi->query(
    "DELETE FROM `posting` WHERE `id_posting` = '$id_posting' AND `no_induk` = '".$_SESSION['current_id']."'");

// redirect ke halaman sebelumnya jika ada.
if (isset($_SERVER['HTTP_REFERER'])) {
	header('Location: '. $_SERVER['HTTP_REFERER']);
	die;
}

header('Location: http://localhost/wartaberita1.0/view_posting.php');
