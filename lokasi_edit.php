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

	# MEMBACA TOMBOL SIMPAN
	if (isset($_POST['btnSimpan'])) {
		# Baca Variabel Form
		$txtNama		= $_POST['txtNama'];
		$txtNama		= str_replace("'", "&acute;", $txtNama); // menghalangi penulisan tanda petik satu (')
		$cmbDepartemen	= $_POST['cmbDepartemen'];

		# Validasi form, jika kosong sampaikan pesan error
		$pesanError = array();
		if (trim($txtNama) == "") {
			$pesanError[] = "Data <b>Nama Lokasi</b> tidak boleh kosong !";
		}
		if (trim($cmbDepartemen) == "Kosong") {
			$pesanError[] = "Data <b>Departemen</b> belum dipilih, silahkan pilih pada Combo !";
		}

		# Validasi Nama lokasi, jika sudah ada akan ditolak
		$Kode	= $_POST['txtKode'];
		$cekSql = "SELECT * FROM lokasi WHERE kd_departemen='$cmbDepartemen' AND nm_lokasi='$txtNama' AND NOT(kd_lokasi='$Kode')";
		$cekQry = mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			$pesanError[] = "Maaf, Nama Lokasi : <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
			$mySql	= "UPDATE lokasi SET nm_lokasi='$txtNama', kd_departemen='$cmbDepartemen' WHERE kd_lokasi ='$Kode'";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Lokasi Berhasil Diubah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Lokasi-Data'>";
			}
			exit;
		}
	} // Penutup Tombol Simpan

	# TAMPILKAN DATA LOGIN UNTUK DIEDIT
	$Kode	 = $_GET['Kode'];
	$mySql	 = "SELECT * FROM lokasi WHERE kd_lokasi='$Kode'";
	$myQry	 = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
	$myData	 = mysql_fetch_array($myQry);

	// Menyimpan data ke variabel temporary (sementara)
	$dataKode		= $myData['kd_lokasi'];
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_lokasi'];
	$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $myData['kd_departemen'];
	?>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
		<table class="table-list" width="100%">
			<tr>
				<th colspan="3">UBAH DATA LOKASI </th>
			</tr>
			<tr>
				<td width="15%"><b>Kode</b></td>
				<td width="1%"><b>:</b></td>
				<td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="26" maxlength="4" readonly="readonly" />
					<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
				</td>
			</tr>
			<tr>
				<td><b>Nama Lokasi </b></td>
				<td><b>:</b></td>
				<td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="26" maxlength="100" /></td>
			</tr>
			<tr>
				<td><strong>Departemen </strong></td>
				<td><strong>:</strong></td>
				<td>
					<select name="cmbDepartemen" data-live-search="true" class="selectpicker">
						<option value="Kosong"> Pilih Departemen </option>
						<?php
						$mySql = "SELECT * FROM departemen ORDER BY kd_departemen";
						$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
						while ($myData = mysql_fetch_array($myQry)) {
							if ($dataDepartemen == $myData['kd_departemen']) {
								$cek = " selected";
							} else {
								$cek = "";
							}
							echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen]</option>";
						}
						$mySql = "";
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input type="submit" name="btnSimpan" value=" Simpan ">
					<a href="?open=Lokasi-Data">
						<input type="button" value=" Kembali " />
					</a>
				</td>
			</tr>
		</table>
	</form>