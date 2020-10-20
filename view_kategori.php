<!--File: view_books.phpDeskripsi  :  menampilkan  data  buku  menggunakan  mysqli  dengan  pendekatan  prosedural-->
<!DOCTYPE  HTML  PUBLIC  "-//W3C//DTD  HTML  4.01  Transitional//EN""http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
	<meta  http-equiv="Content-Type"  content="text/html;  charset=iso-8859-1">
	<title>Biro dan Desk</title>
</head>
<body>
	<table  border="1">
		<tr>
			<th>id_kategori</th>
			<th>nama_kategori</th>
			<th>no_induk</th>
		</tr>
		<?php
		//Include  our  login  information
		require_once('Connections/koneksi.php');
		$query  =  "  SELECT  *  FROM  kategori ";
		//  Execute  the  query
		$result  =  mysqli_query($koneksi,$query);
		if  (!$result){die  ("Could  not  query  the  database:  <br  />".  mysqli_error($koneksi));}
		//  Fetch  and  display  the  results
		while  ($row  =  mysqli_fetch_array($result)){echo  '<tr>';
		echo  '<td><a href="view_kategori_byid.php?id_komentar='.$row['id_kategori'].'">'.$row['id_kategori'].'</a></td>';
		echo  '<td>'.$row['nama_kategori'].'</td>  ';
		echo  '<td>'.$row['no_induk'].'</td>  ';
		echo  '</tr>';
	}
	echo  '</table>';
	echo  '<br  />';
	echo  'Total  Rows  =  '.mysqli_num_rows($result).'<br  />';
	mysqli_close($koneksi);
	?>
</table>
</body>
</html>