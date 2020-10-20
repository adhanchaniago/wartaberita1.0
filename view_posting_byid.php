<?php 
	$id_posting=$_GET['id_posting']; 
	require_once('Connections/koneksi.php');
	
	$query="SELECT * FROM `posting` WHERE `id_posting` = ".$id_posting."";
	$result  =  mysqli_query($koneksi,$query);
	die(print_r($result));
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php foreach ($result as $posting) : ?>
		<h2><?php echo $posting['judul']; ?></h2>
		<p><?php echo $posting['deskripsi']; ?></p>
	<?php endforeach; ?>
</body>
</html>