<body>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
	<?php
	include_once "library/inc.seslogin.php";

	# TOMBOL SIMPAN DIKLIK
	if (isset($_POST['btnSimpan'])) {
		# Baca Variabel Form
		$txtNama		= $_POST['txtNama'];

		# Validasi form, jika kosong sampaikan pesan error
		$pesanError = array();
		if (trim($txtNama) == "") {
			$pesanError[] = "Data <b>Nama Departemen</b> tidak boleh kosong !";
		}

		# Validasi Nama Departemen, jika sudah ada akan ditolak
		$cekSql = "SELECT * FROM departemen WHERE nm_departemen='$txtNama'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			$pesanError[] = "Maaf, Departemen <b> $txtNama </b> sudah ada, ganti dengan yang lain";
		}

		# JIKA ADA PESAN ERROR DARI VALIDASI
		if (count($pesanError) >= 1) {
			echo "<div class='mssgBox'>";
			echo "<img src='images/attention.png'> <br><hr>";
			$noPesan = 0;
			foreach ($pesanError as $indeks => $pesan_tampil) {
				$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
			}
			echo "</div> <br>";
		} else {
			# SIMPAN DATA KE DATABASE. 
			// Jika tidak menemukan error, simpan data ke database
			$kodeBaru	= buatKode4($koneksidb, "departemen", "D");
			$mySql	= "INSERT INTO departemen (kd_departemen, nm_departemen) VALUES ('$kodeBaru', '$txtNama')";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Departemen Berhasil Ditambah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Departemen-Data'>";
			}
			exit;
		}
	} // Penutup Tombol Simpan

	# MASUKKAN DATA KE VARIABEL
	// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
	$dataKode	= buatKode4($koneksidb, "departemen", "D");
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	?>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
		<table class="table-list" width="100%">
			<tr>
				<th colspan="3">TAMBAH DATA DEPARTEMEN </th>
			</tr>
			<tr>
				<td width="15%"><b>Kode</b></td>
				<td width="1%"><b>:</b></td>
				<td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="25" maxlength="4" readonly="readonly" /></td>
			</tr>
			<tr>
				<td><b>Nama Departemen </b></td>
				<td><b>:</b></td>
				<td><input name="txtNama" value="<?php echo $dataNama; ?>" size="25" maxlength="100" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input type="submit" name="btnSimpan" value=" Simpan ">
					<a href="?open=Departemen-Data">
						<input type="button" value=" Kembali " />
					</a>
				</td>
			</tr>
		</table>
	</form>