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
    				<li class="menu-active"><a href="index.php">Login</a></li>
    				<li><a href="about_us.php">About Us</a></li>
    				<li><a href="contact.php">Contact</a></li>
    			</ul>
    		</nav><!-- #nav-menu-container -->
    	</div>
    </header><!-- #header -->

  <!--==========================
    Intro Section
    ============================-->
    <section id="intro">
    	<div class="intro-container">
    		<div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

    			<ol class="carousel-indicators"></ol>

    			<div class="carousel-inner" role="listbox">

    				<div class="carousel-item active">
    					<div class="carousel-background"><img src="img/intro-carousel/1.jpg" alt=""></div>
    					<div class="carousel-container">
    						<div class="carousel-content">
    							<h2>Ready to Work?</h2>

    		
    						</div>
    					</div>
    				</div>
    				<div class="carousel-item" id="featured-login">
    					<div class="carousel-background"><img src="img/intro-carousel/5.jpg" alt=""></div>
    					<div class="carousel-container">
    						<div class="carousel-content">
    							<h2>Login</h2>
    							<div class="card-body py-3" id="form">
    								<?php if (isset($_SESSION['errors'])): ?>
    									<div>
    										<?php foreach($_SESSION['errors'] as $error): ?> 
    											<p  role="alert"><?php echo $error ?></p>
    										<?php endforeach; ?>
    									</div>
    									<?php unset($_SESSION['errors']); endif; ?>
    									<form role="form" method="POST" action="proses_masuk.php">
    										<div class="form-group my-3">
    											<label for="no_induk"></label>
    											<input type="text" name="no_induk" class="form-control" placeholder="NIK" id="no_induk" required>
    										</div>
    										<div class="form-group my-3">
    											<label for="password"></label>
    											<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
    										</div>
    										<button type="submit" name="log_in" class="btn btn-primary btn-block my-4"><div class="text-center">SIGN IN</div></button>
    									</form>
    									<p class=text-center style="color:white"><i>Hubungi Administrator jika lupa password</i></p>
    								</div>
    							</div>
    						</div>
    					</div>
    				</section>

    			</div>

    			<a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
    				<span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
    				<span class="sr-only">Previous</span>
    			</a>

    			<a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
    				<span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
    				<span class="sr-only">Next</span>
    			</a>

    		</div>
    	</div>
    </section><!-- #intro -->

  <!--==========================
    Footer
    ============================-->


    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <!-- Uncomment below i you want to use a preloader -->
    <!-- <div id="preloader"></div> -->

    <!-- JavaScript Libraries -->
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery/jquery-migrate.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/superfish/hoverIntent.js"></script>
    <script src="lib/superfish/superfish.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/touchSwipe/jquery.touchSwipe.min.js"></script>
    <!-- Contact Form JavaScript File -->
    <script src="contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="js2/main.js"></script>

</body>
</html>
