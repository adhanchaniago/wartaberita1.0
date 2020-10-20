<?php 
	$id_komentar=$_GET['id_komentar']; 
	require_once('Connections/koneksi.php');
	
	$query="SELECT * FROM `komentar` WHERE `id_komentar` = ".$id_komentar."";
	$result  =  mysqli_query($koneksi,$query);
	die(print_r($result));
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php foreach ($result as $komentar) : ?>
		<p><?php echo $komentar['isi_komentar']; ?></p>
	<?php endforeach; ?>
</body>
</html>