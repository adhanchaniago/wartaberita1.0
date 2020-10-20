<?php
require_once('Connections/koneksi.php');
session_start();

if(isset($_POST['but_upload'])){

	$name = $_FILES['file']['name'];
	$target_dir = "foto_berita/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);

 // Select file type
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 // Valid file extensions
	$extensions_arr = array("jpg","jpeg","PNG");

 // Check extension
	if(in_array($imageFileType,$extensions_arr)){

  // Insert record
		$queryy = "INSERT INTO `posting` SET `file_gambar` = '$name' WHERE `posting`.`id_posting` = '".$_SESSION['current_id']."'";
		mysqli_query($koneksi,$queryy);

  // Upload file
		move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
		$_SESSION['success'] = 'Input Berita berhasil';
		echo '<script> window.history.go(-1) </script>';

	}
	else{
		$_SESSION['errors'] = 'Input Berita gagal, silahkan pilih file yang lain';
		echo '<script> window.history.go(-1) </script>';
	}

}

// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}


require_once('Connections/koneksi.php');

$id_kategori = $_POST['id_kategori'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$tanggal_posting = date('Y-m-d');
$no_induk = $_SESSION['current_id'];
//die(print_r($_POST));


$query = "INSERT INTO `posting` (`id_kategori`, `judul`, `deskripsi`, `file_gambar`, `tanggal_posting`, `no_induk`) VALUES ('".$id_kategori."', '".$judul."', '".$deskripsi."', '".$name."', (CURRENT_TIMESTAMP), '".$no_induk."');";

	//die($query);
$hasil = $koneksi->query($query);
if($hasil){
	echo ("INPUT DATA BERHASIL");
	header("Location: http://localhost/wartaberita1.0/wartawann.php");
}else{
	echo ("INPUT DATA GAGAL");
}
	//die(print_r($koneksi));
?>