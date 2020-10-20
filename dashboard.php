<?php
session_start();
require_once('Connections/koneksi.php');
// query ambil semua detail posting, nama_kategori, nama anggota, jumlah komentar, like, dislike
$query = "SELECT p.*, k.nama_kategori FROM `posting` p LEFT JOIN `kategori` k ON p.id_kategori = k.id_kategori WHERE p.`no_induk` = '".$_SESSION['current_id']."'";
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

$result = $koneksi->query($query);
$query = "SELECT p.*, k.nama_kategori FROM `posting` p LEFT JOIN `kategori` k ON p.id_kategori = k.id_kategori WHERE p.`no_induk` = '".$_SESSION['current_id']."'";

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
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Dashboard | Wartaberita</title>
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">

	<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	 -->


	<!-- <div class="container mt-5">
		<div class="row sidebar">
			<i id="collapse" class="fas fa-bars" onclick="collapse()"></i>
			<i id="hide" class="fas fa-times" onclick="hide()"></i> -->


			<!-- Page Wrap per -->
			<div id="wrapper">

				<!-- Sidebar -->
				<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

					<!-- Sidebar - Brand -->
					

					<figure class="figure">
						<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" alt="background" class="img-thumbnail shadow"><br>
						<div class="badge badge-pill badge-primary"><?php echo ''.$row['status'].''?></div> <br>
						<figcaption><?php echo ''.$row['nama'].'';?></figcaption>
						<caption><?php echo ''.$row['no_induk'].'';?></caption>
					</figure>


						<!-- <figure class="figure">
							<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" alt="background" class="img-thumbnail shadow"><br>
							<div class="badge badge-pill badge-primary"><?php echo ''.$row['status'].''?></div> <br>
							<figcaption><?php echo ''.$row['nama'].'';?></figcaption>
							<caption><?php echo ''.$row['no_induk'].'';?></caption>
						</figure> -->


						<!-- Divider -->
						<hr class="sidebar-divider my-0">

						<!-- Nav Item - Dashboard -->
						<li class="nav-item active">
							<a class="nav-link" href="dashboard.php">
								<i class="fas fa-fw fa-tachometer-alt"></i>
								<span>Dashboard</span></a>
							</li>

							<!-- Divider -->
							<hr class="sidebar-divider">

							<!-- Heading -->
							<div class="sidebar-heading">
								Berita
							</div>

							<!-- Nav Item - Pages Collapse Menu -->
							<li class="nav-item">
								<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
									<i class="fas fa-fw fa-cog"></i>
									<span>Input Berita</span>
								</a>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
									<div class="bg-white py-2 collapse-inner rounded">
										<h6 class="collapse-header">Pilih tipe berita:</h6>
										<a class="collapse-item" href="wartawann.php">Berita Teks</a>
										<a class="collapse-item" href="berita_foto.php">Berita Foto</a>
									</div>
								</div>
							</li>

							<!-- Nav Item - Utilities Collapse Menu -->
							<li class="nav-item">
								<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
									<i class="fas fa-fw fa-wrench"></i>
									<span>Riwayat berita</span>
								</a>
								<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
									<div class="bg-white py-2 collapse-inner rounded">
										<h6 class="collapse-header">Pilih riwayat berita:</h6>
										<a class="collapse-item" href="riwayat_berita.php">Berita teks</a>
										<a class="collapse-item" href="riwayat_berita_foto.php">Berita Foto</a>
									</div>
								</div>
							</li>

							<!-- Divider -->
							<hr class="sidebar-divider">

							<!-- Heading -->
							<div class="sidebar-heading">
								Profil
							</div>

							<!-- Nav Item - Pages Collapse Menu -->
							<li class="nav-item">
								<a class="nav-link" href="ganti_password.php">
									<i class="fas fa-fw fa-folder"></i>
									<span>Kelola Akun</span>
								</a>
								<!-- <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
									<div class="bg-white py-2 collapse-inner rounded">
										<h6 class="collapse-header">Login Screens:</h6>
										<a class="collapse-item" href="login.html">Ubah Foto Profil</a>
										<a class="collapse-item" href="register.html">Ubah Kata Sandi</a>
										<div class="collapse-divider"></div>
									</div>
								</div>  -->
							</li>



							<!-- Nav Item - Charts -->
							<li class="nav-item">
								<a class="nav-link" href=logout.php>
									<i class="fas fa-sign-out-alt"></i> &nbsp;
									<span>Logout</span></a>
								</li>

								<!-- Nav Item - Tables -->
								
								<!-- Divider -->
								<hr class="sidebar-divider d-none d-md-block">

								<!-- Sidebar Toggler (Sidebar) -->
								<div class="text-center d-none d-md-inline">
									<button class="rounded-circle border-0" id="sidebarToggle"></button>
								</div> 

							</ul>
							<!-- End of Sidebar -->



							<!-- <div id="sidebar" class="col-lg-2 text-center">
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
							</div>  -->

							<!-- Content Wrapper -->
							<div id="content-wrapper" class="d-flex flex-column">

								<div id="content">
									<!-- Topbar -->
									<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

										<!-- Sidebar Toggle (Topbar) -->
										<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
											<i class="fa fa-bars"></i>
										</button>

										<!-- Topbar Search -->
          <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
        </form> -->

        <!-- Topbar Navbar -->

        <ul class="navbar-nav ml-auto">

        	<!-- Nav Item - Search Dropdown (Visible Only XS) -->
        	<li class="nav-item dropdown no-arrow d-sm-none">
        		<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			<i class="fas fa-search fa-fw"></i>
        		</a>
        		<!-- Dropdown - Messages -->
        		<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
        			<form class="form-inline mr-auto w-100 navbar-search">
        				<div class="input-group">
        					<input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        					<div class="input-group-append">
        						<button class="btn btn-primary" type="button">
        							<i class="fas fa-search fa-sm"></i>
        						</button>
        					</div>
        				</div>
        			</form>
        		</div>
        	</li>


        	<!-- Nav Item - User Information -->
        	<li class="nav-item dropdown no-arrow">
        		
        		<a class="mr-2 d-none d-lg-inline text-gray-600 medium" href="index.html">
	      		<!--  <div class="sidebar-brand-icon rotate-n-15">
	       		   <i class="fas fa-laugh-wink"></i>
	       		</div> -->
	       		<div class="sidebar-brand-text mx-3">Wartaberita</div>
	       	</a>



        		<!-- <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo ''.$row['nama'].'';?></span>
        			<br>
        			<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo ''.$row['status'].''?></span>


        			<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" alt="background" class="img-profile rounded-circle"> -->
							<!-- <div class="badge badge-pill badge-primary"><?php echo ''.$row['status'].''?></div>
							<br>
							<figcaption><?php echo ''.$row['nama'].'';?></figcaption>
							<caption><?php echo ''.$row['no_induk'].'';?></caption> -->


							<!-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> -->
							<!-- 	</a> -->




							<!-- Dropdown - User Information -->
					<!-- 	<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
							<a class="dropdown-item" href="#">
								<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
								Profile
							</a>
							<a class="dropdown-item" href="#">
								<i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
								Settings
							</a>
							<a class="dropdown-item" href="#">
								<i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
								Activity Log
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
								<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
								Logout
							</a>
						</div> -->
						<!-- </li> -->

					</ul>

				</nav>
				<!-- End of Topbar -->

				<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	

				<!-- Main Content -->
				<!-- <div id="content" class="col-lg-10">
					<h1>Dashboard Berita</h1>
					<div class="leftcolumn">
						<?php foreach ($posts as $post): ?>
							<div class="card">

              <?php // tampilkan tombol delete & edit jika pemilik posting adalah anggota yang sedang login
              if ($current_id == $post['no_induk']): ?>
              	<a href="edit_posting.php?id_posting=<?php echo $post['id_posting'] ?>">
              		<button style="float: right; margin-left: 5px">Edit</button>
              	</a>
              <?php endif; ?>

              <h2><a href="index.php?id_posting=<?php echo $post['id_posting'] ?>"><?php echo $post['judul'] ?></a></h2>
              <h5>Created at <?php echo strftime('%A, %d %B %Y', strtotime($post['tanggal_posting'])) ?></h5>
              <div>
              	<p><?php echo $post['deskripsi'] ?></p>
              </div>
          </div>
      <?php endforeach; ?>
  </div>

  <div class="rightcolumn">
  	<div class="card">
  		<td>
  			<h2 class="text-white">Filter Product by Category</h2>
  			<a href="index.php"><button>Semua</button></a>

  			<?php foreach ($daftarKategori as $kategori): ?>
  				<a href="index.php?id_kategori=<?php echo $kategori['id_kategori'] ?>"><button><?php echo $kategori['nama_kategori'] ?></button></a>
  			<?php endforeach; ?>

  		</td>
  	</div>
  </div>
</div> -->

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