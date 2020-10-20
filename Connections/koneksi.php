<?php
	setlocale(LC_TIME, ['id_ID', 'INDONESIA']);

	$hostname="localhost";
	$username="root";
	$password="";
	$database="wartaberita1_0";

	$koneksi=mysqli_connect($hostname, $username, $password, $database);

	// Checking error
    if(mysqli_connect_errno()){
        die('Koneksi gagal: <br>'.mysqli_connect_error());
    }
?>
	