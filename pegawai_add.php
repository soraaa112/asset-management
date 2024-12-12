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

	if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
		# Pegawai terpilih
		$kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : $_SESSION['SES_UNIT'];
		$kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;
	}

	# Tombol Simpan diklik
	if (isset($_POST['btnSimpan'])) {
		# Baca Variabel Form
		$txtNama		= $_POST['txtNama'];
		$cmbKelamin		= $_POST['cmbKelamin'];
		$txtAlamat		= $_POST['txtAlamat'];
		$txtTelepon		= $_POST['txtTelepon'];
		$cmbDepartemen	= $_POST['cmbDepartemen'];

		# Validasi form, jika kosong sampaikan pesan error
		$pesanError = array();
		if (trim($txtNama) == "") {
			$pesanError[] = "Data <b>Nama Pegawai</b> tidak boleh kosong, silahkan dilengkapi !";
		}
		if (trim($cmbDepartemen) == "Kosong") {
			$pesanError[] = "Data <b>Departemen</b> belum dipilih, silahkan pilih pada Combo !";
		}
		if (trim($cmbKelamin) == "Kosong") {
			$pesanError[] = "Data <b>Kelamin</b> belum dipilih, silahkan pilih pada Combo !";
		}
		if (trim($txtAlamat) == "") {
			$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong, silahkan dilengkapi !";
		}
		if (trim($txtTelepon) == "") {
			$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, silahkan dilengkapi !";
		}
		# Validasi Nama lokasi, jika sudah ada akan ditolak
		$cekSql = "SELECT * FROM pegawai WHERE kd_departemen='$cmbDepartemen' AND nm_pegawai='$txtNama'";
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
			# SIMPAN DATA KE DATABASE. 
			// Jika tidak menemukan error, simpan data ke database	
			$kodeBaru	= buatKode5($koneksidb, "pegawai", "P");
			$mySql	= "INSERT INTO pegawai (kd_pegawai, nm_pegawai, jns_kelamin, alamat, no_telepon, kd_departemen) 
					VALUES ('$kodeBaru',
							'$txtNama',
							'$cmbKelamin',
							'$txtAlamat',
							'$txtTelepon',
							'$cmbDepartemen')";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Pegawai Berhasil Ditambah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Data'>";
			}
			exit;
		}
	} // Penutup Tombol Simpan

	# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
	$dataKode	= buatKode5($koneksidb, "pegawai", "P");
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataKelamin = isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
	$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
	$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
	?>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
		<table width="100%" cellpadding="2" cellspacing="1" class="table-list">
			<tr>
				<th colspan="3">TAMBAH DATA PEGAWAI </th>
			</tr>
			<tr>
				<td width="15%"><b>Kode</b></td>
				<td width="1%"><b>:</b></td>
				<td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="26" maxlength="4" readonly="readonly" /></td>
			</tr>
			<tr>
				<td><b>Nama Pegawai </b></td>
				<td><b>:</b></td>
				<td><input name="txtNama" value="<?php echo $dataNama; ?>" size="26" maxlength="100" /></td>
			</tr>
			<tr>
				<td><strong>Departemen </strong></td>
				<td><strong>:</strong></td>
				<td>
					<?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) { ?>
						<select name="cmbDepartemen" data-live-search="true" class="selectpicker">
							<?php
							$mySql = "SELECT * FROM departemen WHERE nm_departemen='$_SESSION[SES_UNIT]' ORDER BY kd_departemen";
							$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
							while ($myData = mysql_fetch_array($myQry)) {
								if ($kodeDepartemen == $myData['kd_departemen']) {
									$cek = " selected";
								} else {
									$cek = "";
								}
								echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen]</option>";
							}
							$mySql = "";
							?>
						</select>
					<?php } else { ?>
						<select name="cmbDepartemen" data-live-search="true" class="selectpicker">
							<option value="Kosong"> Pilih Departemen </option>
							<?php
							$mySql = "SELECT * FROM departemen ORDER BY kd_departemen";
							$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
							while ($myData = mysql_fetch_array($myQry)) {
								if ($kodeDepartemen == $myData['kd_departemen']) {
									$cek = " selected";
								} else {
									$cek = "";
								}
								echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen]</option>";
							}
							$mySql = "";
							?>
						</select>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td><b>Kelamin</b></td>
				<td><b>:</b></td>
				<td><b>
						<select name="cmbKelamin" data-live-search="true" class="selectpicker">
							<option value="Kosong"> Pilih Jenis Kelamin </option>
							<?php
							$pilihan	= array("Laki-laki", "Perempuan");
							foreach ($pilihan as $nilai) {
								if ($dataKelamin == $nilai) {
									$cek = " selected";
								} else {
									$cek = "";
								}
								echo "<option value='$nilai' $cek>$nilai</option>";
							}
							?>
						</select>
					</b></td>
			</tr>
			<tr>
				<td><b>Alamat Lengkap </b></td>
				<td><b>:</b></td>
				<td><textarea name="txtAlamat" cols="28" rows="3"><?php echo $dataAlamat; ?></textarea></td>
			</tr>
			<tr>
				<td><b>No Telepon </b></td>
				<td><b>:</b></td>
				<td><input name="txtTelepon" value="<?php echo $dataTelepon; ?>" size="26" maxlength="20" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input type="submit" name="btnSimpan" value=" Simpan ">
					<a href="?open=Pegawai-Data">
						<input type="button" name="" value=" Kembali " />
					</a>
				</td>
			</tr>
		</table>
	</form>