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
			$mySql	= "UPDATE pegawai SET nm_pegawai='$txtNama', jns_kelamin='$cmbKelamin', alamat='$txtAlamat',
					no_telepon='$txtTelepon',  kd_departemen='$cmbDepartemen' WHERE kd_pegawai ='$Kode'";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Pegawai Berhasil Diubah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Data'>";
			}
			exit;
		}
	} // Penutup Tombol Simpan

	# MENGAMBIL DATA YANG DIEDIT, SESUAI KODE YANG DIDAPAT DARI URL
	$Kode	= $_GET['Kode'];
	$mySql	= "SELECT * FROM pegawai WHERE kd_pegawai='$Kode'";
	$myQry	= mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
	$dataKode	= $myData['kd_pegawai'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_pegawai'];
	$dataKelamin = isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : $myData['jns_kelamin'];
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
	$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $myData['kd_departemen'];
	?>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
		<table class="table-list" width="100%">
			<tr>
				<th colspan="3">UBAH DATA PEGAWAI </th>
			</tr>
			<tr>
				<td width="15%"><b>Kode</b></td>
				<td width="1%"><b>:</b></td>
				<td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="26" maxlength="4" readonly="readonly" />
					<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
				</td>
			</tr>
			<tr>
				<td><b>Nama Pegawai </b></td>
				<td><b>:</b></td>
				<td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="26" maxlength="100" /></td>
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
					<?php } else { ?>
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