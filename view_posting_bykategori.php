<!DOCTYPE  HTML  PUBLIC  "-//W3C//DTD  HTML  4.01  Transitional//EN""http://www.w3.org/TR/html401/loose.dtd">
<html>
    <head>
        <meta  http-equiv="Content-Type"  content="text/html;  charset=iso-8859-1">
        <title>Read posting by kategori</title>
    </head>
    <body>
        <?php
            //  Include  our  login  information
                require_once('koneksi.php');

                //  Connect
                $koneksi = mysqli_connect($hostname, $username, $password, $database);
                if (mysqli_connect_errno()) {
                    die  ("Could  not  connect  to  the  database:  <br  />".  mysqli_connect_error(  ));
                }

                $kategori = $_GET['id_kategori'];

                //Asign  a  query
                $query  =  "SELECT * FROM `posting` WHERE (`id_kategori` = ".$kategori.")";
    
                //  Execute  the  query
                $result  =  mysqli_query($koneksi,$query); 
                if  (!$result){die  ("Could  not  query  the  database:  <br  />".  mysqli_error($koneksi));}

                

                //  Fetch  and  display  the  results
                while  ($row  =  mysqli_fetch_assoc($result)){
                    echo  '<div style=border:solid>';
                    echo  'id_posting :  '.$row['id_posting']  .  '<br  />';
                    echo  'id_kategori:  '.$row['id_kategori']  .  '<br  />';
                    echo  'judul:  <a href="view_posting_byid.php/?id_posting='.$row['id_posting'].'">'.$row['judul']  .  '</a><br  />  ';
                    echo  'deskripsi:  '.$row['deskripsi']  .  '<br  />  ';
                    // echo '<img width="100px" src="/project/img/posting/'.$row['gambar_posting'].'" /><br>';
                    echo  'tanggal_posting:  '.$row['tanggal_posting']  .  '<br  />  ';
                    echo  'id_anggota:  '.$row['id_anggota']  .  '<br  />  ';
                    echo '</div>';
                }
              
                echo  '</table>';
                echo  '<br  />';
                mysqli_close($koneksi);
            ?>
       
    </body>
</html>