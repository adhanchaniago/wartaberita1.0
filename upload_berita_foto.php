<?php
session_start();
//script php dimodifikasi berdasarkan script
//http://www.phpeasystep.com/phptu/18.html

//koneksi ke database
require_once('Connections/koneksi.php');

//menangkap posting dari field input form
$judul        = $_POST['judul'];
$tanggal_posting = date('Y-m-d');
$no_induk = $_SESSION['current_id'];

$namafolder="gambar/"; //folder tempat menyimpan file
if (!empty($_FILES["filegbr"]["tmp_name"]))
{
$jenis_gambar=$_FILES['filegbr']['type']; //memeriksa format gambar
if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg")
{
	$lampiran = $namafolder . basename($_FILES['filegbr']['name']);

//mengupload gambar dan update row table database dengan path folder dan nama image
	if (move_uploaded_file($_FILES['filegbr']['tmp_name'], $lampiran)) {

		$query_insert = "INSERT INTO `posting_berita_foto` (`judul`,`tanggal_posting`,`no_induk`,`image`)
		VALUES ('".$judul."',(CURRENT_TIMESTAMP),'".$no_induk."','".$lampiran."')";
		$insert = mysqli_query($query_insert);

		echo ("INPUT DATA BERHASIL");
	header("Location: http://localhost/wartaberita1.0/berita_foto.php");
//Jika gagal upload, tampilkan pesan Gagal
	} else {
		echo "Gambar gagal dikirim";
	}
} else {
	echo "Jenis gambar yang anda kirim salah. Harus .jpg";
}
} else {
	echo "Anda belum memilih gambar";
}
?>