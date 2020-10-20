 <?php
 session_start();
  // cek jika anggota sudah login
 if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
 	session_abort();
 	die;
 }
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<style>p.indent{ padding-left: 1.8em }</style>
 	<meta charset="utf-8">
 	<title>Wartaberita</title>
 	<meta content="width=device-width, initial-scale=1.0" name="viewport">
 	<meta content="" name="keywords">
 	<meta content="" name="description">

 	<!-- Favicons -->
 	<link href="img/favicon.png" rel="icon">
 	<link href="img/apple-touch-icon.png" rel="apple-touch-icon">

 	<!-- Google Fonts -->
 	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

 	<!-- Bootstrap CSS File -->
 	<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

 	<!-- Libraries CSS Files -->
 	<link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
 	<link href="lib/animate/animate.min.css" rel="stylesheet">
 	<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
 	<link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
 	<link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

 	<!-- Main Stylesheet File -->
 	<link href="css2/style.css" rel="stylesheet">

  <!-- =======================================================
    Theme Name: BizPage
    Theme URL: https://bootstrapmade.com/bizpage-bootstrap-business-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
    ======================================================= -->
</head>

<body>

  <!--==========================
    Header
    ============================-->
    <header id="header">
    	<div id="logo" class="pull-left">
                <h1><a>Wartaberita</a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="#intro"><img src="img/logo.png" alt="" title="" /></a>-->
            </div>
            <div>
    		<nav id="nav-menu-container">
    			<ul class="nav-menu">
    				<li><a href="index.php">Login</a></li>
    				<li><a href="about_us.php">About Us</a></li>
    				<li  class="menu-active"><a href="contact.php">Contact</a></li>
    			</ul>
    		</nav><!-- #nav-menu-container -->
    	</div>
    </header><!-- #header -->


 <!--==========================
      Contact Section
      ============================-->
      <section id="contact"">
      	<div class="container">

      		<div class="section-header">
      			<h3>Contact Us</h3>
      			<p>Hubungi admin jika terdapat masalah terkait sistem</p>
      		</div>

      		<div class="row contact-info">

      			<div class="col-md-4">
      				<div class="contact-address">
      					<i class="ion-ios-location-outline"></i>
      					<h3>Address</h3>
      					<address>Jl. Pandanaran No. 30, Semarang</address>
      				</div>
      			</div>

      			<div class="col-md-4">
      				<div class="contact-phone">
      					<i class="ion-ios-telephone-outline"></i>
      					<h3>Phone Number</h3>
      					<p><a href="tel:081215763693">081215763693</a></p>
      				</div>
      			</div>

      			<div class="col-md-4">
      				<div class="contact-email">
      					<i class="ion-ios-email-outline"></i>
      					<h3>Email</h3>
      					<p><a href="mailto:red_sumer@yahoo.com">red_sumer@yahoo.com</a></p>
      				</div>
      			</div>

      		</div>

      	</div>
      </section><!-- #contact -->
  </body>
