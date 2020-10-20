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
//  header('Location: ../wartaberita1.0/');
//  $_SESSION['errors'] = ['no_induk' => 'Silahkan Login'];
//  die;
// }

// if(isset($_SESSION['logged_in'])){
//  $no_induk = $_SESSION['current_id'];
//  if($_SESSION['current_id'] == 'Wartawan'){
//  $sql = "SELECT * FROM anggota WHERE no_induk = 'Wartawan'";
//  $result = mysqli_query($koneksi, $sql);
//  if(!$result){
//    die("Could not query the database: <br />".mysqli_error($link));
//  }
//  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
//  }
//  else{
//    header('Location: ../wartaberita1.0/logout.php');
//    $_SESSION['errors'] = ['no_induk' => 'Silahkan Login'];
//    die;
//  }
// }
$sql = "SELECT * FROM anggota WHERE no_induk = '$current_id'";
$result2 = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_array($result2,MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WARTAberita | Kelola Berita</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  	folder instead of downloading all of them to reduce the load. -->
  	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  	<!-- Morris chart -->
  	<link rel="stylesheet" href="bower_components/morris.js/morris.css">
  	<!-- jvectormap -->
  	<link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  	<!-- Date Picker -->
  	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  	<!-- Daterange picker -->
  	<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  	<!-- bootstrap wysihtml5 - text editor -->
  	<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green sidebar-mini">
	<div class="wrapper">

		<header class="main-header">
			<!-- Logo -->
			<a href="index2.html" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>W</b>bt</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>WARTA</b>berita</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- Messages: style can be found in dropdown.less-->

						<!-- Notifications: style can be found in dropdown.less -->

						<!-- Tasks: style can be found in dropdown.less -->

						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo ''.$row['nama'].'';?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" class="img-circle" alt="User Image">

									<p>
										<?php echo ''.$row['nama'].'';?>&nbsp-&nbsp<?php echo ''.$row['status'].''?>
										<small><?php echo ''.$row['no_induk'].'';?></small>
									</p>
								</li>
								<!-- Menu Body -->

								<!-- Menu Footer-->
								<li class="user-footer">

									<div class="text-center">
										<a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
						<!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li> -->
    </ul>
</div>
</nav>

</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?php echo ''.$row['nama'].'';?></p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<br>

		<!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
    	<li class="header">Kelola Berita</li>
    	<li class="treeview">
    		<a href="#">
    			<i class="fa fa-edit"></i> <span>Input Berita</span>
    			<span class="pull-right-container">
    				<i class="fa fa-angle-left pull-right"></i>
    			</span>
    		</a>
    		<ul class="treeview-menu">
    			<li ><a href="wartawann.php"><i class="fa fa-circle-o"></i> Berita Teks</a></li>
    			<li ><a href="berita_foto.php"><i class="fa fa-circle-o"></i> Berita Foto</a></li>
    		</ul>
    	</li>
    	<li class="active treeview">
    		<a href="#">
    			<i class="fa fa-table"></i> <span>Riwayat</span>
    			<span class="pull-right-container">
    				<i class="fa fa-angle-left pull-right"></i>
    			</span>
    		</a>
    		<ul class="treeview-menu">
    			<li class="active"><a href="riwayat_berita.php"><i class="fa fa-circle-o"></i> Berita Teks</a></li>
    			<li><a href="riwayat_berita_foto.php"><i class="fa fa-circle-o"></i> Berita Foto</a></li>
    		</ul>
    	</li>
    </li>
    <li class="header">Kelola Akun</li>
    <li><a href="ganti_password.php"><i class="fa fa-circle-o text-red"></i> <span>Ubah Password</span></a></li>
    <li><a href="ganti_foto_profil.php"><i class="fa fa-circle-o text-yellow"></i> <span>Ubah Foto Profil</span></a></li>
    <!-- <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
</ul>
</section>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Kelola Berita
			<small></small>
		</h1>
		<br>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Kelola Berita</a></li>
			<li class="active">Input Berita Teks</li>
		</ol>
	</section>

	<!-- Main content -->
	<div class="box box-primary">
		<div class="col-lg-7">
			<div class="box-header with-border">
				<h1>Riwayat Berita Teks</h1>
			</div>

			<!-- DataTales Example -->
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<!-- <h6 class="m-0 font-weight-bold text-primary">Data Table Berita Teks</h6> -->
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered dt-responsive" id="datatables" cellspacing="0">
							<thead>
								<tr>
									<th>ID</th>
									<th>Biro dan Desk</th>
									<th>Judul</th>
									<th>Isi Berita</th>
									<th>File Gambar</th>
									<th>Tanggal Posting</th>
									<th>Kelola</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($daftarPosting) > 0) {
									foreach($daftarPosting as $row): ?>
										<tr>
											<td><?php echo $row['id_posting'] ?></td>
											<td><?php echo $row['nama_kategori'] ?></td>
											<td><?php echo $row['judul'] ?></td>
											<td style="width: 40%;"><?php echo $row['deskripsi'] ?></td>
											<td><?php echo $row['file_gambar'] ?></td>
											<td><?php echo $row['tanggal_posting'] ?></td>
											<td>
												<a href="edit_postingg.php?id_posting=<?php echo $row['id_posting'] ?>">Edit</a>
												<a href="hapus_posting.php?id_posting=<?php echo $row['id_posting'] ?>"
													onclick="return confirm('Apakah anda yakin?');">Delete</a>

													<!-- <a href="wartawan.php?id_posting=<?php echo $row['id_posting'] ?>">Lihat</a> -->
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
											<!-- <tr>
												<th colspan="6"> Jumlah Berita = <?php echo $result->num_rows ?></th>
											</tr> -->
										<?php } else { ?>
											<tr>
												<td colspan="6" style="text-align:center"> Anda tidak memiliki postingan</td>
											</tr>
										<?php } ?> 
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 2.4.12
			</div>
			<strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
			reserved.
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark" style="display: none;">
			<!-- Create the tabs -->
			<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
				<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
				<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<!-- Home tab content -->
				<div class="tab-pane" id="control-sidebar-home-tab">
					<h3 class="control-sidebar-heading">Recent Activity</h3>
					<ul class="control-sidebar-menu">
						<li>
							<a href="javascript:void(0)">
								<i class="menu-icon fa fa-birthday-cake bg-red"></i>

								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

									<p>Will be 23 on April 24th</p>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<i class="menu-icon fa fa-user bg-yellow"></i>

								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

									<p>New phone +1(800)555-1234</p>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

									<p>nora@example.com</p>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<i class="menu-icon fa fa-file-code-o bg-green"></i>

								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

									<p>Execution time 5 seconds</p>
								</div>
							</a>
						</li>
					</ul>
					<!-- /.control-sidebar-menu -->

					<h3 class="control-sidebar-heading">Tasks Progress</h3>
					<ul class="control-sidebar-menu">
						<li>
							<a href="javascript:void(0)">
								<h4 class="control-sidebar-subheading">
									Custom Template Design
									<span class="label label-danger pull-right">70%</span>
								</h4>

								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-danger" style="width: 70%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<h4 class="control-sidebar-subheading">
									Update Resume
									<span class="label label-success pull-right">95%</span>
								</h4>

								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-success" style="width: 95%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<h4 class="control-sidebar-subheading">
									Laravel Integration
									<span class="label label-warning pull-right">50%</span>
								</h4>

								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-warning" style="width: 50%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<h4 class="control-sidebar-subheading">
									Back End Framework
									<span class="label label-primary pull-right">68%</span>
								</h4>

								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-primary" style="width: 68%"></div>
								</div>
							</a>
						</li>
					</ul>
					<!-- /.control-sidebar-menu -->

				</div>
				<!-- /.tab-pane -->
				<!-- Stats tab content -->
				<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
				<!-- /.tab-pane -->
				<!-- Settings tab content -->
				<div class="tab-pane" id="control-sidebar-settings-tab">
					<form method="post">
						<h3 class="control-sidebar-heading">General Settings</h3>

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Report panel usage
								<input type="checkbox" class="pull-right" checked>
							</label>

							<p>
								Some information about this general settings option
							</p>
						</div>
						<!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Allow mail redirect
								<input type="checkbox" class="pull-right" checked>
							</label>

							<p>
								Other sets of options are available
							</p>
						</div>
						<!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Expose author name in posts
								<input type="checkbox" class="pull-right" checked>
							</label>

							<p>
								Allow the user to show his name in blog posts
							</p>
						</div>
						<!-- /.form-group -->

						<h3 class="control-sidebar-heading">Chat Settings</h3>

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Show me as online
								<input type="checkbox" class="pull-right" checked>
							</label>
						</div>
						<!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Turn off notifications
								<input type="checkbox" class="pull-right">
							</label>
						</div>
						<!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Delete chat history
								<a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
							</label>
						</div>
						<!-- /.form-group -->
					</form>
				</div>
				<!-- /.tab-pane -->
			</div>
		</aside>
		<!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  	immediately after the control sidebar -->
  	<div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
  	$.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Morris.js charts -->
  <script src="bower_components/raphael/raphael.min.js"></script>
  <script src="bower_components/morris.js/morris.min.js"></script>
  <!-- Sparkline -->
  <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="bower_components/moment/min/moment.min.js"></script>
  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript">
  	$(document).ready( function () {
  		$('#datatables').DataTable();
  	} );
  </script>
</body>
</html>
