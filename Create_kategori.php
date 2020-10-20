<?php

require_once('Connections/koneksi.php');
$nama_kategori = $_POST['nama_kategori'];
$no_induk = $_POST['no_induk'];
	//die(print_r($_POST));

$query = "INSERT INTO `kategori` (`id_kategori`, 'nama_kategori', `no_induk`) VALUES (NULL, '".$nama_kategori."', '".$no_induk."');";
	//die($query);
$hasil = $koneksi->query($query);
if($hasil){
	echo ("INPUT DATA BERHASIL");
}else{
	echo ("INPUT DATA GAGAL");
}
	//die(print_r($koneksi));
?>