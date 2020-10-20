<!--File: view_books.phpDeskripsi  :  menampilkan  data  buku  menggunakan  mysqli  dengan  pendekatan  prosedural-->
<!DOCTYPE  HTML  PUBLIC  "-//W3C//DTD  HTML  4.01  Transitional//EN""http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
	<meta  http-equiv="Content-Type"  content="text/html;  charset=iso-8859-1">
	<title>Displaying  in  an  HTML  table</title>
</head>
<body>
	<table  border="1">
		<tr>
			<th>id_komentar</th>
			<th>id_posting</th>
			<th>id_anggota</th>
			<th>isi_komentar</th>
			<th>tanggal_waktu_komentar</th>
		</tr>
		<?php
		//Include  our  login  information
		require_once('Connections/koneksi.php');
		$query  =  "  SELECT  *  FROM  komentar ";
		//  Execute  the  query
		$result  =  mysqli_query($koneksi,$query);
		if  (!$result){die  ("Could  not  query  the  database:  <br  />".  mysqli_error($koneksi));}
		//  Fetch  and  display  the  results
		while  ($row  =  mysqli_fetch_array($result)){echo  '<tr>';
		echo  '<td><a href="view_komentar_byid.php?id_komentar='.$row['id_komentar'].'">'.$row['id_komentar'].'</a></td>';
		echo  '<td>'.$row['id_posting'].'</td>  ';
		echo  '<td>'.$row['id_anggota'].'</td>  ';
		echo  '<td>'.$row['isi_komentar'].'</td>';
		echo  '<td>'.$row['tanggal_waktu_komentar'].'</td>';
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