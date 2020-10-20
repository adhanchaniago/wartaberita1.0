<?php session_start();

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

// no_induk yang sedang login
$current_id = isset($_SESSION['current_id']) ? $_SESSION['current_id'] : null;

?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="stylewartawan.css">
  <link href='https://fonts.googleapis.com/css?family=Aclonica' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Marko One' rel='stylesheet'>
</head>
<body>

  <div class="header">
    <h2>WARTABERITA</h2>
      <a href="logout.php" class="logoutbtn">Logout</a>
      &nbsp; &nbsp; &nbsp; 
      <a href="view_posting.php" class="logoutbtn">Kelola Berita</a>
  </div>

      <div class="row">
        <div class="leftcolumn">
          <?php foreach ($posts as $post): ?>
            <div class="card">

              <?php // tampilkan tombol delete & edit jika pemilik posting adalah anggota yang sedang login
                if ($current_id == $post['no_induk']): ?>
                <a href="hapus_posting.php?id_posting=<?php echo $post['id_posting'] ?>" onclick="return confirm('Apakah anda yakin?')">
                  <button style="float: right; margin-left: 5px">Delete</button>
                </a>
                <a href="edit_posting.php?id_posting=<?php echo $post['id_posting'] ?>">
                  <button style="float: right; margin-left: 5px">Edit</button>
                </a>
              <?php endif; ?>

              <h2><a href="wartawan.php?id_posting=<?php echo $post['id_posting'] ?>"><?php echo $post['judul'] ?></a></h2>
              <h5>Created at <?php echo strftime('%A, %d %B %Y', strtotime($post['tanggal_posting'])) ?></h5>
              <div>
                <p><?php echo $post['deskripsi'] ?></p>
                <p><?php echo $post ['file_gambar']?></p>
              </div>
              <!--
              <h5>
                <?php echo $post['n_komentar'] ?> komentar | <?php echo $post['n_like'] ?> suka
                <?php echo $current_id == $post['no_induk'] ?  '& '.$post['n_dislike'].' tidak suka' : '' ?>
              </h5>
            -->
              <?php // tampilkan tombol like / dislike & data komentar jika pengunjung sudah login
                if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) :  ?>
                <!--
                <div>
                  <form action="suka.php" method="POST">
                  <input type="hidden" name="id_posting" value="<?php echo $post['id_posting'] ?>">
                  <table>
                    <tr>
                      <td>
                          <button type="submit" name="is_like" value="1" id="like"><img src="img/like.png"></button>
                      </td>
                      <td>
                          <button type="submit" name="is_like" value="0" id="dislike"><img src="img/dislike.png"></button>
                      </td>
                    </tr>
                  </table>
                  </form>
                </div>
              -->
              <!--
                <div>
                  <table style="width: 100%">
                    <?php foreach($komentar_post[$post['id_posting']] as $komentar): ?>
                    <tr style="background: rgba(255,255,255, 0.5)">
                      <td>
                        <b><?php echo $komentar['nama'] ?></b> pada <small><?php echo $komentar['tanggal_waktu_komentar'] ?></small>
                        <br><?php echo $komentar['isi_komentar'] ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                      <td>
                        <form action="create_komentar.php" method="POST">
                          <input type="hidden" name="id_posting" value="<?php echo $post['id_posting'] ?>">
                          KOMENTAR: <br>
                          <textarea cols="30" rows="5" id="komentar" placeholder="Tulis komentar...." name="isi_komentar"></textarea><br>
                          <input type="submit" id="crud" value="Kirim komentar" name="komentar"/>
                        </form>
                      </td>
                    </tr>
                  </table>
                </div>
              -->
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
          <!-- <div class="card">
            <button type="submit" id="crud" name="delete" style="float: right;">Delete</button>
            <h2>TITLE HEADING</h2>
            <h5>Title description, Dec 7, 2017</h5>
            <div class="posting">
              <img src="img/bird.jpg" alt="gambar">
              <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco unt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco unt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco unt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco unt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco unt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco unt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..</p>
            </div>
            <?php if(isset($_SESSION['logged_in'])) :  ?>
            <div>
              <table>
                <tr>
                  <td>
                    <form action="Masuk.php">
                      <button id="like"><img src="img/like.png"></button>
                    </form>
                  </td>
                  <td>
                    <form action="Masuk.php">
                      <button id="dislike"><img src="img/dislike.png"></button>
                    </form>
                  </td>
                </tr>
              </table>
            </div>
            <div>
              <table>
                <tr>
                  <td>KOMENTAR:</td>
                </tr>
                <tr>
                  <td><textarea cols="30" rows="5" id="komentar" placeholder="Tulis komentar...."></textarea></td>
                </tr>
                <tr>
                  <td><input type="submit" id="crud" value="Kirim komentar" name="komentar"/>
                    <input type="hidden" name="tanggal_waktu_komentar" value="<?php echo date('Y-m-d')?>">
                    <input type="hidden" name="no_induk" value="<?php echo $_SESSION['current_id']?>">
                  </td>
                </tr>
              </table>
            </div>
            <?php endif; ?>
          </div> -->
        </div>

        <div class="rightcolumn">
          <div class="card">
            <td>
                  <h2 class="text-white">Biro dan Desk</h2>
                    <a href="wartawan.php"><button>Semua</button></a>
                  
                  <?php foreach ($daftarKategori as $kategori): ?>
                    <a href="wartawan.php?id_kategori=<?php echo $kategori['id_kategori'] ?>"><button><?php echo $kategori['nama_kategori'] ?></button></a>
                  <?php endforeach; ?>

              </td>
          </div>
        </div>
    </div>

<div class="footer">
  <h5>&#169 2018 by Suara Merdeka</h5>
</div>

</body>
</html>
