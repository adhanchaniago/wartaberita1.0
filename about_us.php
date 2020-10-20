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

        <nav lass="main-header" id="nav-menu-container">
          <ul class="nav-menu">
            <li><a href="index.php">Login</a></li>
            <li   class="menu-active"><a href="about_us.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
          </ul>
        </nav><!-- #nav-menu-container -->
      </div>
    </header><!-- #header -->


 <!--==========================
      About Us Section
      ============================-->
      <section id="about">
        <div class="container">

          <header class="section-header">
            <h3>About Us</h3>
            <p>Wartaberita adalah divisi media press dari Suara Merdeka Group yang bergerak di bidang pengelolaan data berita wartawan</p>
          </header>

          <div class="row about-cols">

            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
              <div class="about-col">
                <div class="img">
                  <img src="img/about-mission.jpg" alt="" class="img-fluid">
                  <div class="icon"><i class="ion-ios-speedometer-outline"></i></div>
                </div>
                <h2 class="title"><a>Our Mission</a></h2>
                
                
                <ol>
                  <li><p >Mengabdi kepada masyarakat dalam peningkatan kecerdasan bangsa</p></li>
                  <li><p>Memasarkan informasi yang akurat, terkini dan bertanggung jawab melalui media cetak dan elektronik dengan memberikan layanan pelanggan yang terbaik</p></li>
                  <li><p>Menghasilkan keuntungan yang optimal agar</br>
                  a. &nbsp Perusahaan makin tumbuh dan </br> &nbsp &nbsp &nbsp berkembang</br>
                  b. &nbsp Profesionalisme karyawan dapat </br> &nbsp &nbsp &nbsp ditingkatkan</br>
                  c. &nbsp Berperan secara aktif di dalam </br> &nbsp &nbsp &nbsp kehidupan sosial masyarakat</br>
                  </p></li>
                </ol>
                </p>
              </div>
            </div>

    <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
      <div class="about-col">
        <div class="img">
          <img src="img/about-vision.jpg" alt="" class="img-fluid">
          <div class="icon"><i class="ion-ios-eye-outline"></i></div>
        </div>
        <h2 class="title"><a>Our Motto</a></h2>
        <p>
          Perekat Komunitas Jawa Tengah.
        </p>
      </div>
    </div>

    <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
      <div class="about-col">
        <div class="img">
          <img src="img/about-plan.jpg" alt="" class="img-fluid">
          <div class="icon"><i class="ion-ios-list-outline"></i></div>
        </div>
        <h2 class="title"><a >Our Vision</a></h2>
        <p>
          Menjadi perusahaan pelopor industri informasi yang diakui masyarakat dan merupakan pilihan pelanggan karena bermutu serta menjadi Perekat Komunitas Jawa Tengah.
        </p>
      </div>
    </div>

    

  </div>

</div>
    </section><!-- -->
  </body>