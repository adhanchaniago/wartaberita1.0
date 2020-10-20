 <?php 
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
  header('Location: http://localhost/miniblog/');
  die;
}
if (isset($_SESSION['errors'])) {
  $errors = $_SESSION['errors'];
  unset($_SESSION['errors']);
}
if (isset($_SESSION['notif'])) {
  $notif = $_SESSION['notif'];
  unset($_SESSION['notif']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="styledaftar.css">
</head>
<body>
  <form class="modal-content" action="proses_daftar.php" method="POST">
    <div class="container">
      <h1>Daftar</h1>
      <p>Silahkan isi form dibawah ini untuk membuat akun</p>
      <?php
        if (isset($notif)) {
          echo "<hr>";
          echo "<h4>" . $notif . "</h4>";
        }
      ?>
      <?php if (isset($errors)): ?>
      <ul>
        <?php foreach($errors as $error): ?> 
          <li><?php echo $error ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
      <hr>
      <label for="nama"><b>Nama</b></label>
      <input type="text" class="form-control <?php echo(isset($errors['nama'])) ? 'is-invalid' : ''?>" placeholder="Isi Nama" name="nama" required>
      
      <label for="email"><b>Email</b></label>
      <input type="text" class="form-control <?php echo(isset($errors['email'])) ? 'is-invalid' : ''?>" placeholder="Isi Email" name="email" required>

      <label for="password"><b>Kata Sandi</b></label>
      <input type="password" class="form-control <?php echo(isset($errors['password'])) ? 'is-invalid' : ''?>" placeholder="Isi Kata Sandi" name="password" required>
      
      <label for="password"><b>Ulangi Kata Sandi</b></label>
      <input type="password" class="form-control" placeholder="Ulangi Kata Sandi" name="password2" required>
      
      <label for="deskripsi_diri"><b>Deskripsi Diri</b></label>
      <input type="text" class="form-control <?php echo(isset($errors['deskripsi_diri'])) ? 'is-invalid' : ''?>" placeholder="Isi deskripsi" name="deskripsi_diri" maxlength="50" required>

      <div class="clearfix">
        <a href="index.php"><button type="button" class="cancelbtn">Batal</button></a>
        <button type="submit" class="signupbtn">Daftar</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>
