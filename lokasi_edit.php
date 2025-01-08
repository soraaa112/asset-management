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

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Lokasi-Data'>";
	}

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

	</SCRIPT>
	<div class="table-border">
		<h2>UBAH DATA LOKASI</h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group">
					<label for="textfield" class="col-lg-2 control-label">Kode</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="textfield" id="textfield" readonly value="<?php echo $dataKode; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="txtNama" class="col-lg-2 control-label">Nama Lokasi</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtNama" id="txtNama" value="<?php echo $dataNama; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="cmbDepartemen" class="col-lg-2 control-label">Departemen</label>
					<div class="col-lg-4">
						<select name="cmbDepartemen" id="cmbDepartemen" data-live-search="true" class="selectpicker show-tick form-control" autocomplete="off" style="display: block; margin-bottom: 10px;">
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
					</div>
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
		</form>
	</div>