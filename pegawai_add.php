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
	}
	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Data'>";
	}

	// Penutup Tombol Simpan

	# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
	$dataKode	= buatKode5($koneksidb, "pegawai", "P");
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataKelamin = isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
	$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
	$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
	?>
	<SCRIPT language="JavaScript">
		function submitform() {
			document.form1.submit();
		}
	</SCRIPT>
	<div class="table-border">
		<h2>TAMBAH DATA PEGAWAI</h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
			<div class="row">
				<label for="textfield" class="col-lg-2 control-label">Kode</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" name="textfield" id="textfield" value="<?php echo $dataKode; ?>" readonly autocomplete="off">
				</div>
				<label for="txtAlamat" class="col-lg-2 control-label">Alamat</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" name="txtAlamat" id="txtAlamat" value="<?php echo $dataAlamat; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
				</div>
				<div class="form-group">
					<label for="txtNama" class="col-lg-2 control-label">Nama Pegawai</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtNama" id="txtNama" value="<?php echo $dataNama; ?>" autocomplete="off">
					</div>
					<div class="form-group">
						<label for="txtTelepon" class="col-lg-2 control-label">No. Telepon</label>
						<div class="col-lg-4">
							<input type="text" class="form-control" name="txtTelepon" id="txtTelepon" value="<?php echo $dataTelepon; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
						</div>
						<div class="form-group">
							<label for="cmbKelamin" class="col-lg-2 control-label">Kelamin </label>
							<div class="col-lg-4">
								<select name="cmbKelamin" id="cmbKelamin" data-live-search="true" class="selectpicker show-tick form-control" autocomplete="off">
									<option value=""> Pilih Jenis Kelamin </option>
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
							</div>
							<label for="cmbDepartemen" class="col-lg-2 control-label">Departemen</label>
							<div class="col-lg-4">
								<select name="cmbDepartemen" id="cmbDepartemen" data-live-search="true" class="selectpicker show-tick form-control" autocomplete="off">
									<option value=""> Pilih Departemen </option>
									<?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
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
									<?php } else { ?>
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
									} ?>
								</select>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10" style="display: block; margin-top: 50px;">
									<button type="submit" name="btnSimpan" class="btn btn-success">
										<span class="glyphicon glyphicon-floppy-saved" aria-hidden="true">&nbsp;</span><b>SIMPAN</b>
									</button>
									<button type="submit" name="btnKembali" class="btn btn-danger">
										<span class="glyphicon glyphicon-chevron-left" aria-hidden="true">&nbsp;</span><b>KEMBALI</b>
									</button>
								</div>
							</div>
						</div>
		</form>
	</div>