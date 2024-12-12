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

	# Tombol Simpan diklik
	if (isset($_POST['btnSimpan'])) {
		# BACA DATA DALAM FORM, masukkan datake variabel
		$txtNama		= $_POST['txtNama'];
		$txtUsername	= $_POST['txtUsername'];
		$txtPassword	= $_POST['txtPassword'];
		$txtTelepon		= $_POST['txtTelepon'];
		$cmbLevel		= $_POST['cmbLevel'];
		$cmbDepartemen	= $_POST['cmbDepartemen'];

		# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
		$pesanError = array();
		if (trim($txtNama) == "") {
			$pesanError[] = "Data <b>Nama Petugas</b> tidak boleh kosong, silahkan diisi !";
		}
		if (trim($txtUsername) == "") {
			$pesanError[] = "Data <b>Username</b> tidak boleh kosong, silahkan diisi !";
		}
		if (trim($cmbDepartemen) == "Kosong") {
			$pesanError[] = "Data <b>Unit</b> tidak boleh kosong, silahkan diisi !";
		}
		if (trim($cmbLevel) == "Kosong") {
			$pesanError[] = "Data <b>Level login</b> belum dipilih, silahkan dipilih dari Combo !";
		}

		# VALIDASI petugas LOGIN (username), jika sudah ada akan ditolak
		$Kode	= $_POST['txtKode'];
		$cekSql	= "SELECT * FROM petugas WHERE username='$txtUsername' AND NOT(kd_petugas ='$Kode')";
		$cekQry	= mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			$pesanError[] = "Username : <b> $txtUsername </b> sudah ada, ganti dengan yang lain";
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
			# Cek Password baru
			if (trim($txtPassword) == "") {
				$txtPassLama	= $_POST['txtPassLama'];
				$sqlPasword = "password='$txtPassLama'";
			} else {
				$sqlPasword = "password ='" . md5($txtPassword) . "'";
			}
			# SIMPAN DATA KE DATABASE (Jika tidak menemukan error, simpan data ke database)
			$Kode	= $_POST['txtKode'];
			$mySql  = "UPDATE petugas SET nm_petugas='$txtNama', username='$txtUsername', no_telepon='$txtTelepon', level='$cmbLevel', kd_departemen='$cmbDepartemen', $sqlPasword WHERE kd_petugas='$Kode'";
			$myQry = mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
			    echo "<script>alert('Data Pengguna Berhasil Diubah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Petugas-Data'>";
			}
			exit;
		}
	} // Penutup Tombol Simpan


	# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
	$Kode	= $_GET['Kode'];
	$mySql	= "SELECT * FROM petugas WHERE kd_petugas='$Kode'";
	$myQry	= mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	// Data Variabel Temporary (sementara)
	$dataKode		= $myData['kd_petugas'];
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_petugas'];
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
	$dataPassword	= isset($_POST['txtPassword']) ? $_POST['txtPassword'] : $myData['password'];
	$dataTelepon	= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $myData['level'];
	$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $myData['kd_departemen'];
	?>

	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
		<table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
			<tr>
				<th colspan="3"><b>UBAH DATA PETUGAS</b></th>
			</tr>
			<tr>
				<td width="178"><b>Kode</b></td>
				<td width="5"><b>:</b></td>
				<td width="1106"> <input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="26" maxlength="5" readonly="readonly" />
					<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
				</td>
			</tr>
			<tr>
				<td><b>Nama Petugas </b></td>
				<td><b>:</b></td>
				<td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="26" maxlength="100" /></td>
			</tr>
			<tr>
				<td><b>No. Telepon </b></td>
				<td><b>:</b></td>
				<td><input name="txtTelepon" type="text" value="<?php echo $dataTelepon; ?>" size="26" maxlength="20" /></td>
			</tr>
			<tr>
				<td><b>Username</b></td>
				<td><b>:</b></td>
				<td><input name="txtUsername" type="text" value="<?php echo $dataUsername; ?>" size="26" maxlength="20" /></td>
			</tr>
			<tr>
				<td><strong>Departemen</strong></td>
				<td><strong>:</strong></td>
				<td><select name="cmbDepartemen" data-live-search="true" class="selectpicker">
						<option value="Kosong"> Pilih Departemen </option>
						<?php
						// Menampilkan data Departemen
						$mySql = "SELECT * FROM departemen ORDER BY kd_departemen";
						$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
						while ($myData = mysql_fetch_array($myQry)) {
							if ($myData['kd_departemen'] == $dataDepartemen) {
								$cek = " selected";
							} else {
								$cek = "";
							}
							echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen] </option>";
						}
						?>
					</select></td>
			</tr>
			<tr>
				<td><b>Password</b></td>
				<td><b>:</b></td>
				<td><input name="txtPassword" type="password" size="26" maxlength="20" />
					<input name="txtPassLama" type="hidden" value="<?php echo $dataPassword ?>" />
				</td>
			</tr>
			<tr>
				<td><b>Level</b></td>
				<td><b>:</b></td>
				<td><b>
						<select name="cmbLevel" data-live-search="true" class="selectpicker">
							<option value="Kosong"> Pilih Level </option>
							<?php
							$pilihan	= array("Petugas", "Admin", "Operator");
							foreach ($pilihan as $nilai) {
								if ($dataLevel == $nilai) {
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
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>
					<input type="submit" name="btnSimpan" value=" Simpan " />
					<a href="?open=Petugas-Data">
						<input type="button" value=" Kembali " />
					</a>
				</td>
			</tr>
		</table>
	</form>