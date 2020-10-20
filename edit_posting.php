<?php
session_start();
// cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: http://localhost/wartaberita1.0/');
	die;
}

// harus ada parameter ?id_posting
if (! isset($_GET['id_posting'])) {
    header('Location: http://localhost/wartaberita1.0/wartawann.php');
	die;
}

require_once('Connections/koneksi.php');
$id_posting = $_GET['id_posting'];

$getPosting = $koneksi->query(
    "SELECT * FROM `posting` WHERE `id_posting` = '$id_posting' AND `no_induk` = '".$_SESSION['current_id']."' LIMIT 1");

// jika posting tidak ada
if ($getPosting->num_rows <= 0) {
    header('Location: http://localhost/wartaberita1.0/wartawann.php');
	die;
}

// simpan posting ke dalam variabel
$posting = $getPosting->fetch_array();

// ambil semua kategori
$getKategori = $koneksi->query("SELECT * FROM `kategori`");
if ($getKategori->num_rows > 0) {
	$daftarKategori = $getKategori->fetch_all(MYSQLI_ASSOC);
} else {
	$daftarKategori = [];
}
?>

<html>
<head>
	<meta  http-equiv="Content-Type"  content="text/html;  charset=iso-8859-1">
	<title>Edit Berita</title>
</head>
<body>
<div class="newpost">
	<form method="POST" action="update_posting.php">
        <input type="hidden" name="id_posting" value="<?php echo $posting['id_posting'] ?>">
		<table>
			<tr>
				<td>Judul</td>
				<td>:</td>
				<td><textarea name="judul" id="judul" cols="105" rows="1" placeholder="Judul"><?php echo $posting['judul'] ?></textarea></td>
			</tr>
			<tr>
				<td>Biro dan Desk</td>
				<td>:</td>
				<td>
				<select id="kategori" name="id_kategori">
					<option value="0">--Pilih Biro/Desk--</option>
					<?php foreach($daftarKategori as $kategori): ?>
					<option value="<?php echo $kategori['id_kategori'] ?>" <?php echo $posting['id_kategori'] == $kategori['id_kategori'] ? " selected" : "" ?>><?php echo $kategori['nama_kategori'] ?></option>
					<?php endforeach; ?> 
				</select>
				</td>
			</tr>
			<tr>
				<td style="vertical-align: top;">Isi Berita</td>
				<td style="vertical-align: top;">:</td>
				<td><textarea name="deskripsi" cols="105" rows="10" placeholder="Tulis post"><?php echo $posting['deskripsi'] ?></textarea></td>
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
					<button type="submit" class="btn btn-primary my-2" value='Save name' name='but_upload'>Edit Berita</button>
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>