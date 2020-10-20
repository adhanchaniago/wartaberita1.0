<?php 
	$id_kategori=$_GET['id_kategori']; 
	require_once('Connections/koneksi.php');
	
	$query="SELECT * FROM `kategori` WHERE `id_kategori` = ".$id_kategori."";
	$result  =  mysqli_query($koneksi,$query);
	die(print_r($result));
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php foreach ($result as $kategori) : ?>
		<p><?php echo $kategori['isi_kategori']; ?></p>
	<?php endforeach; ?>
</body>
</html>