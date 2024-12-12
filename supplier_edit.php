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
		$txtNama		= str_replace("'", "&acute;", $txtNama); // menghalangi penulisan tanda petik satu (')

		$txtAlamat		= $_POST['txtAlamat'];
		$txtAlamat		= str_replace("'", "&acute;", $txtAlamat); // menghalangi penulisan tanda petik satu (')

		$txtTelepon		= $_POST['txtTelepon'];

		# Validasi form, jika kosong sampaikan pesan error
		$pesanError = array();
		if (trim($_POST['txtNama']) == "") {
			$pesanError[] = "Data <b>Nama Supplier</b> tidak boleh kosong !";
		}
		// if (trim($_POST['txtAlamat']) == "") {
		// 	$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong !";
		// }
		// if (trim($_POST['txtTelepon']) == "") {
		// 	$pesanError[] = "Data <b>No Telepon</b> tidak boleh kosong !";
		// }

		# Validasi Nama Supplier, jika sudah ada akan ditolak
		$Kode	= $_POST['txtKode'];
		$cekSql	= "SELECT * FROM supplier WHERE nm_supplier='$txtNama' AND NOT(kd_supplier='$Kode')";
		$cekQry	= mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			$pesanError[] = "Maaf, Supplier <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
			# SIMPAN PERUBAHAN DATA, Jika jumlah error pesanError tidak ada, simpan datanya
			$Kode	= $_POST['txtKode'];
			$mySql	= "UPDATE supplier SET nm_supplier='$txtNama', alamat='$txtAlamat',
						no_telepon='$txtTelepon' WHERE kd_supplier ='$Kode'";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Supplier Berhasil Diubah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Supplier-Data'>";
			}
			exit;
		}
	} // Penutup Tombol Simpan

	# MENGAMBIL DATA YANG DIEDIT, SESUAI KODE YANG DIDAPAT DARI URL
	$Kode	= $_GET['Kode'];
	$mySql	= "SELECT * FROM supplier WHERE kd_supplier='$Kode'";
	$myQry	= mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
	$dataKode	= $myData['kd_supplier'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_supplier'];
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
	$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	?>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
		<table class="table-list" width="100%">
			<tr>
				<th colspan="3">UBAH DATA SUPPLIER </th>
			</tr>
			<tr>
				<td width="15%"><b>Kode</b></td>
				<td width="1%"><b>:</b></td>
				<td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="25" maxlength="10" readonly="readonly" />
					<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
				</td>
			</tr>
			<tr>
				<td><b>Nama Supplier </b></td>
				<td><b>:</b></td>
				<td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="25" maxlength="200" /></td>
			</tr>
			<tr>
				<td><b>Alamat Lengkap </b></td>
				<td><b>:</b></td>
				<td><textarea name="txtAlamat" cols="27" rows="3"><?php echo $dataAlamat; ?></textarea></td>
			</tr>
			<tr>
				<td><b>No Telepon </b></td>
				<td><b>:</b></td>
				<td><input name="txtTelepon" value="<?php echo $dataTelepon; ?>" size="25" maxlength="200" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input type="submit" name="btnSimpan" value=" Simpan ">
					<a href="?open=Supplier-Data">
						<input type="button" value=" Kembali " />
					</a>
				</td>
			</tr>
		</table>
	</form>