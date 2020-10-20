<?php
  session_start();
  // cek jika anggota sudah login
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header('Location: http://localhost/miniblog/');
    die;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="stylemasuk.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 
</head>
<body>

<div class="container">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header" style="padding:35px 50px;">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4><span class="glyphicon glyphicon-lock"></span> Masuk</h4>
    </div>
    <div class="modal-body" style="padding:40px 50px;">
      <?php if (isset($_SESSION['errors'])): ?>
        <ul>
          <?php foreach($_SESSION['errors'] as $error): ?> 
            <li><?php echo $error ?></li>
          <?php endforeach; ?>
        </ul>
      <?php unset($_SESSION['errors']); endif; ?>
      <form role="form" method="POST" action="proses_masuk.php">
        <div class="form-group">
          <label for="email"> Email</label>
          <input type="text" name="email" class="form-control" id="email" placeholder="Masukkan Email">
        </div>
        <div class="form-group">
          <label for="ksd"> Kata Sandi</label>
          <input type="password" name="password" class="form-control" id="ksd" placeholder="Masukkan Kata Sandi">
        </div>
          <button type="submit" name="Masuk" class="btn btn-success btn-block"> Masuk</button>
      </form>
    </div>
    <div class="modal-footer">
      <br>
      <p>Bukan member? <a href="Daftar.php">Daftar</a></p>
    </div>
  </div>
</div>
</body>
</html>
