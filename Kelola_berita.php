<?php
session_start();
require_once('Connections/koneksi.php');
// query ambil semua detail posting, nama_kategori, nama anggota, jumlah komentar, like, dislike
$query = "SELECT p.*, k.nama_kategori, a.nama, COALESCE(l.n_like,0) n_like, COALESCE(l.n_dislike, 0) n_dislike FROM ( SELECT post.*, COUNT(komentar.id_posting) as n_komentar FROM `posting` post LEFT JOIN komentar USING(`id_posting`) GROUP BY post.id_posting ) p LEFT JOIN `kategori` k USING (`id_kategori`) LEFT JOIN `anggota` a USING (`no_induk`) LEFT JOIN (SELECT `like`.`id_posting`, SUM(`like`.is_like) n_like, SUM(`like`.is_dislike) n_dislike FROM `like` GROUP BY `like`.id_posting) l USING (`id_posting`)";

// jika ada parameter ?id_posting maka tampilkan satu posting dengant id_posting tersebut.
if (isset($_GET['id_posting']) && ! empty(trim($_GET['id_posting']))) {
	$query .= " WHERE p.id_posting = '".$_GET['id_posting']."' LIMIT 1";
} 
// jika ada parameter ?id_kategori maka tampilkan semua posting dengan id_kategori tersebut.
elseif (isset($_GET['id_kategori']) && ! empty(trim($_GET['id_kategori']))) {
	$query .= " WHERE p.id_kategori = '".$_GET['id_kategori']."'";
}

$getPosting = $koneksi->query($query);

// inisiasi posts
$posts = [];

if ($getPosting->num_rows > 0) {
  // tampung hasil query detail posting yang didapat
	$posts = $getPosting->fetch_all(MYSQLI_ASSOC);

  // tampung semua id_posting yang didapat
	$posts_id = [];
	foreach ($posts as $post) {
		$posts_id[] = $post['id_posting'];
	}
  // ambil semua komentar yang ada pada tiap-tiap posting
	$getKomentar = $koneksi->query(
		"SELECT k.*, a.nama FROM `komentar` k LEFT JOIN `anggota` a USING(`no_induk`) WHERE k.`id_posting` IN (".implode(', ', $posts_id).")"
	);
  // inisiasi komentar_post
	$komentar_post = [];
	foreach($posts_id as $id_posting) {
		$komentar_post[$id_posting] = [];
	}
// ambil semua kategori
	$getKategori = $koneksi->query("SELECT * FROM `kategori`");
	if ($getKategori->num_rows > 0) {
		$daftarKategori = $getKategori->fetch_all(MYSQLI_ASSOC);
	} else {
		$daftarKategori = [];
	}
  // tampung semua komentar dan dipilah kedalam array sesuai id_postingnya
  // if ($getKomentar->num_rows > 0) {
  //   $daftarKomentar = $getKomentar->fetch_all(MYSQLI_ASSOC);

  //   foreach ($posts_id as $id_posting) {
  //     foreach ($daftarKomentar as $komentar) {
  //       if ($komentar['id_posting'] == $id_posting) {
  //         $komentar_post[$id_posting][] = $komentar;
  //       }
  //     }
  //   }
  // }
}



// ambil semua kategori yang ada.
$getKategori = $koneksi->query("SELECT * FROM `kategori`");
// tampung kedalam variabel
if ($getKategori->num_rows > 0) {
	$daftarKategori = $getKategori->fetch_all(MYSQLI_ASSOC);
} else {
	$daftarKategori = [];
}

$query = "SELECT p.*, k.nama_kategori FROM `posting` p LEFT JOIN `kategori` k ON p.id_kategori = k.id_kategori WHERE p.`no_induk` = '".$_SESSION['current_id']."'";
$result = $koneksi->query($query);

// tampung ke dalam variabel
if ($result->num_rows > 0) {
	$daftarPosting = $result->fetch_all(MYSQLI_ASSOC);
} else {
	$daftarPosting = [];
}

// no_induk yang sedang login
$current_id = isset($_SESSION['current_id']) ? $_SESSION['current_id'] : null;

// // cek sudah login atau belum
// if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
// 	header('Location: ../wartaberita1.0/');
// 	$_SESSION['errors'] = ['no_induk' => 'Silahkan Login'];
// 	die;
// }

// if(isset($_SESSION['logged_in'])){
// 	$no_induk = $_SESSION['current_id'];
// 	if($_SESSION['current_id'] == 'Wartawan'){
// 	$sql = "SELECT * FROM anggota WHERE no_induk = 'Wartawan'";
// 	$result = mysqli_query($koneksi, $sql);
// 	if(!$result){
// 		die("Could not query the database: <br />".mysqli_error($link));
// 	}
// 	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
// 	}
// 	else{
// 		header('Location: ../wartaberita1.0/logout.php');
// 		$_SESSION['errors'] = ['no_induk' => 'Silahkan Login'];
// 		die;
// 	}
// }
$sql = "SELECT * FROM anggota WHERE no_induk = '$current_id'";
$result2 = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_array($result2,MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kelola Berita | Wartaberita</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
	<div class="container mt-5">
		<div class="row sidebar">
			<i id="collapse" class="fas fa-bars" onclick="collapse()"></i>
			<i id="hide" class="fas fa-times" onclick="hide()"></i>
			<div id="sidebar" class="col-lg-2 text-center">
				<figure class="figure">
					<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" alt="background" class="img-thumbnail shadow"><br>
					<div class="badge badge-pill badge-primary"><?php echo ''.$row['status'].''?></div> <br>
					<figcaption><?php echo ''.$row['nama'].'';?></figcaption>
					<caption><?php echo ''.$row['no_induk'].'';?></caption>
				</figure>
				<a href="wartawann.php" class="btn btn-primary btn-block mr-5">
					<i class="fas fa-door-open"></i> &nbsp;Kelola Berita
				</a>
				<a href=riwayat_berita.php class="btn btn-secondary btn-block my-2">
					<i class="fas fa-bell"></i> &nbsp; Daftar Berita
				</a>
				<br>
				<div class="text-left"><b style="color: #9C9C9C">PROFIL</b></div>
				<a href=ganti_password.php class="btn btn-secondary btn-block my-2">
					<i class="fas fa-pen"></i> &nbsp; Ubah Profil
				</a>
				<a href=logout.php class="btn btn-secondary btn-block my-2">
					<i class="fas fa-sign-out-alt"></i> &nbsp; Keluar
				</a>
			</div>
			<div id="content" class="col-lg-10">
				<h1>Kelola Berita</h1>
				<?php if (isset($_SESSION['errors'])){ ?>
					<div class="alert alert-danger alert-bottom alert-dismissible fade show text-center" role="alert"> 
						<?php echo $_SESSION['errors']; ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php unset($_SESSION['errors']);}?>
					<?php if (isset($_SESSION['success'])){ ?>
						<div class="alert alert-success alert-bottom alert-dismissible fade show text-center" role="alert"> 
							<?php echo $_SESSION['success']; ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<?php unset($_SESSION['success']);}?>
		
			</div>
		</div>
	</div>
	<script>
		function hide(){
			document.getElementById('sidebar').style.visibility = "hidden";
			document.getElementById('content').style.visibility = "visible";
			document.getElementById('collapse').style.visibility = "visible";
			document.getElementById('hide').style.visibility = "hidden";
		}
		function collapse(){
			document.getElementById('sidebar').style.visibility = "visible";
			document.getElementById('content').style.visibility = "hidden";
			document.getElementById('collapse').style.visibility = "hidden";
			document.getElementById('hide').style.visibility = "visible";
		}
	</script>

</body>
</html>