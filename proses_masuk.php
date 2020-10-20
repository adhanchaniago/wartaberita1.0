<?php

session_start();

// cek jika sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    die("<h1>404 PAGE NOT FOUND</h1>");
}
// cek request metod harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

// cek no_induk dan password tidak boleh kosong
if (!isset($_POST['no_induk']) || !isset($_POST['password'])) {
    $_SESSION['errors'] = ['no_induk' => 'no_induk dan password tidak boleh kosong'];
	header('Location: http://localhost/wartaberita1.0/index.php');
	die;
}

require_once('Connections/koneksi.php');

$no_induk = filter_var($_POST['no_induk'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

// cek no_induk
$cekno_induk = $koneksi->query("SELECT * FROM `anggota` a WHERE `no_induk` = '$no_induk' LIMIT 1");
if ($cekno_induk->num_rows <= 0) {
    $_SESSION['errors'] = ['no_induk' => 'no_induk salah'];
    header('Location: http://localhost/wartaberita1.0/index.php');
	die;
}

$anggota = $cekno_induk->fetch_array();

// cek password
if ($password != $anggota['password']) {
    $_SESSION['errors'] = ['no_induk' => ' password salah'];
    header('Location: http://localhost/wartaberita1.0/index.php');
	die;
}

$last_login = date('Y-m-d');
$updateLastLogin = $koneksi->query(
    "UPDATE `anggota` SET `last_login` = '$last_login' WHERE `no_induk` = '".$anggota['no_induk']."'");
    
$_SESSION['logged_in'] = TRUE;
$_SESSION['current_id'] = $anggota['no_induk'];
$_SESSION['current_anggota'] = $anggota;

switch ($anggota['status']){
    case "Wartawan":
        header ('location: ../wartaberita1.0/wartawann.php');
        break;
    case "Koordinator lapangan":
        header ('location: ../orca/pesan.php?tanggal=');
        break;
    case "Admin":
        header ('location: ../wartaberita1.0/admin.php');
        break;
    default:
        $_SESSION['errors'] = ['no_induk' => 'NIM/NIP/Username Tidak Terdaftar'];
        header('Location: ../wartaberita1.0/index.php');
}
