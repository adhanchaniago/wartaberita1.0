<!--File: view_books.phpDeskripsi  :  menampilkan  data  buku  menggunakan  mysqli  dengan  pendekatan  prosedural-->
<?php 
session_start(); 
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: http://localhost/wartaberita1.0');
	die;
}
require_once('Connections/koneksi.php');

// ambil semua kategori
$getKategori = $koneksi->query("SELECT * FROM `kategori`");
if ($getKategori->num_rows > 0) {
	$daftarKategori = $getKategori->fetch_all(MYSQLI_ASSOC);
} else {
	$daftarKategori = [];
}

// query ambil semua posting yang dimiliki anggota
$query = "SELECT p.*, k.nama_kategori FROM `posting` p LEFT JOIN `kategori` k ON p.id_kategori = k.id_kategori WHERE p.`no_induk` = '".$_SESSION['current_id']."'";
$result = $koneksi->query($query);

// tampung ke dalam variabel
if ($result->num_rows > 0) {
	$daftarPosting = $result->fetch_all(MYSQLI_ASSOC);
} else {
	$daftarPosting = [];
}
?>
<!DOCTYPE  HTML  PUBLIC  "-//W3C//DTD  HTML  4.01  Transitional//EN""http://www.w3.org/TR/html401/loose.dtd">

<html>
<head>
	<meta  http-equiv="Content-Type"  content="text/html;  charset=iso-8859-1">
	<title>Kelola Berita</title>
</head>
<body>
<div class="newpost">
	<form method="POST" action="Create_posting.php">
		<table>
			<tr>
				<td>Judul</td>
				<td>:</td>
				<td><textarea name="judul" id="judul" cols="105" rows="1" placeholder="Judul"></textarea></td>
			</tr>
			<tr>
				<td>Biro dan Desk</td>
				<td>:</td>
				<td>
				<select id="kategori" name="id_kategori">
					<option value="0">--Pilih Biro/Desk--</option>
					<?php foreach($daftarKategori as $kategori): ?>
					<option value="<?php echo $kategori['id_kategori'] ?>"><?php echo $kategori['nama_kategori'] ?></option>
					<?php endforeach; ?> 
				</select>
				</td>
			</tr>
			<tr>
				<td style="vertical-align: top;">Isi Berita</td>
				<td style="vertical-align: top;">:</td>
				<td><textarea name="deskripsi" cols="105" rows="10" placeholder="Tulis Berita"></textarea></td>
			</tr>   
			<tr>
				<td>Gambar</td>
				<td>:</td>
				<td><form method="POST" action="upload_foto_berita.php" enctype='multipart/form-data'>
				<input type='file' name='file'><br>
				</form>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary my-2" value='Save name' name='but_upload'>Kirim Berita</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<hr>
<div style="overflow-x: scroll">
<table style="width: 800px;" border="1">
	<tr>
		<th>Aksi</th>
		<th>ID</th>
		<th>Biro dan Desk</th>
		<th>Judul</th>
		<th>Isi Berita</th>
		<th>File Gambar</th>
		<th>Tanggal Posting</th>
	</tr>
<?php
if (count($daftarPosting) > 0) {
	foreach($daftarPosting as $row): ?>
	<tr>
		<td>
			<a href="hapus_posting.php?id_posting=<?php echo $row['id_posting'] ?>"
				onclick="return confirm('Apakah anda yakin?');">Delete</a> |
			<a href="edit_posting.php?id_posting=<?php echo $row['id_posting'] ?>">Edit</a> |
			<a href="wartawan.php?id_posting=<?php echo $row['id_posting'] ?>">Lihat</a>
		</td>
		<td><?php echo $row['id_posting'] ?></td>
		<td><?php echo $row['nama_kategori'] ?></td>
		<td><?php echo $row['judul'] ?></td>
		<td><?php echo $row['deskripsi'] ?></td>
		<td><?php echo $row['file_gambar'] ?></td>
		<td><?php echo $row['tanggal_posting'] ?></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<th colspan="6"> Total Rows = <?php echo $result->num_rows ?></th>
	</tr>
<?php } else { ?>
	<tr>
		<td colspan="6" style="text-align:center"> Anda tidak memiliki postingan</td>
	</tr>
<?php } ?> 
</table>
</div>
</body>
</html>