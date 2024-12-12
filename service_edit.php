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

	// Membaca User yang Login
	$userLogin	= $_SESSION['SES_LOGIN'];

	# TAMPILKAN DATA KE FORM
	$Kode	 = $_GET['Kode'];
	$mySql = "SELECT service_item.*, service_item.keterangan as berita_acara, services.*, barang.nm_barang
	from service_item
	LEFT JOIN services on service_item.no_service=services.no_service
	LEFT JOIN supplier ON services.kd_supplier=supplier.kd_supplier
	LEFT JOIN barang_inventaris on service_item.kd_inventaris=barang_inventaris.kd_inventaris
	LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
	LEFT JOIN petugas ON services.kd_petugas=petugas.kd_petugas
	WHERE service_item.no_service='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	$dataKode           = $myData['no_service'];
	$dataLokasi			= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : $myData['lokasi'];
	$dataVendor			= isset($_POST['cmbVendor']) ? $_POST['cmbVendor'] : $myData['kd_supplier'];
	$dataKodeInventaris	= isset($_POST['txtKodeInventaris']) ? $_POST['txtKodeInventaris'] : $myData['kd_inventaris'];
	$dataKirim 	    	= isset($_POST['txtTanggalKirim']) ? $_POST['txtTanggalKirim'] : IndonesiaTgl($myData['tgl_kirim']);
	$dataKerusakan	    = isset($_POST['txtKerusakan']) ? $_POST['txtKerusakan'] : $myData['kerusakan'];
	$dataCustomer	    = isset($_POST['txtCustomer']) ? $_POST['txtCustomer'] : $myData['customer'];
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['berita_acara'];
	$dataHargaService	= isset($_POST['txtHargaService']) ? $_POST['txtHargaService'] : $myData['harga_service'];
	$dataNamaBrg	    = isset($_POST['txtNamaBrg']) ? $_POST['txtNamaBrg'] : $myData['nm_barang'];
	$dataSnAwal			= isset($_POST['txtSnAwal']) ? $_POST['txtSnAwal'] : $myData['serial_number'];
	$formSuratJalan		= $myData['surat_jalan'];

	# ========================================================================================================
	# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
	if (isset($_POST['btnSimpan'])) {
		// Baca variabel from

		$txtKodeInventaris	= $_POST['txtKodeInventaris'];
		$txtKodeInventaris	= str_replace("'", "&acute;", $txtKodeInventaris);

		$txtHargaService	= $_POST['txtHargaService'];
		$txtHargaService	= str_replace("'", "&acute;", $txtHargaService);
		$txtHargaService	= str_replace(".", "", $txtHargaService);

		$txtTanggalKirim 	= InggrisTgl($_POST['txtTanggalKirim']);
		$txtKerusakan		= $_POST['txtKerusakan'];
		$txtCustomer		= $_POST['txtCustomer'];
		$txtKeterangan		= $_POST['txtKeterangan'];
		$cmbLokasi			= $_POST['cmbLokasi'];
		$cmbVendor			= $_POST['cmbVendor'];
		$txtSnAwal			= $_POST['txtSnAwal'];
		$pesanError			= [];
		$uploaded_files 	= [];
		$errors 			= [];
		$desired_dir 		= "user_data";

		if ($formSuratJalan == "" || $formSuratJalan != "file0") {
			foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
				$file_name = $_FILES['files']['name'][$key];
				$file_size = $_FILES['files']['size'][$key];
				$file_tmp = $_FILES['files']['tmp_name'][$key];
				$file_type = $_FILES['files']['type'][$key];
				if ($file_size > 9097152) {
					$errors[] = 'File size must be less than 2 MB';
				}

				if (empty($errors) == true) {
					if (!is_file("$desired_dir/$file_name")) {
						if (move_uploaded_file($file_tmp, "$desired_dir/$file_name")) {
							$uploaded_files[] = $file_name; // Simpan nama file yang berhasil diunggah
						} else {
							$errors[] = "$file_name: Failed to upload file.";
						}
					} else {
						$errors[] = "$file_name: File already exists in the directory.";
					}
				} else {
					print_r($errors);
				}
			}
			// Menyimpan nama-nama file yang berhasil diunggah
			$fileName = !empty($uploaded_files) ? implode(';', $uploaded_files) : '';
		}

		if (trim($txtKodeInventaris) != "") {
			# Periksa Database 1, apakah Kode Inventaris yang dimasukkan ada di dalam Database
			$cekSql	= "SELECT * FROM barang_inventaris WHERE kd_inventaris='$txtKodeInventaris' or RIGHT(kd_inventaris,6) ='$txtKodeInventaris'";
			$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query" . mysql_error());
			if (mysql_num_rows($cekQry) < 1) {
				$pesanError[] = "Kode Barang <b>$txtKodeInventaris</b> tidak ditemukan dalam database!";
			}
		} else {
			$pesanError[] = "Data <b>Kode/ Label Barang</b> belum diisi, ketik secara manual atau dari <b>Barcode Reader atau Pencarian Barang</b> !";
		}

		# JIKA ADA PESAN ERROR DARI VALIDASI
		if ($pesanError) {
			echo "<div class='mssgBox'>";
			echo "<img src='images/attention.png'> <br><hr>";
			$noPesan = 0;
			foreach ($pesanError as $indeks => $pesan_tampil) {
				$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
			}
			echo "</div> <br>";
		} else {
			# SIMPAN DATA KE DATABASE
			# Jika jumlah error pesanError tidak ada
			if ($formSuratJalan == "" || $formSuratJalan != "file0") {
				$mySql	= "UPDATE services SET surat_jalan='$fileName' WHERE no_service='$dataKode'";
				mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			}

			$mySql	= "UPDATE services SET tgl_kirim='$txtTanggalKirim', lokasi='$cmbLokasi', kd_supplier='$cmbVendor' WHERE no_service='$dataKode'";
			mysql_query($mySql, $koneksidb) or die("Gagal query service " . mysql_error());

			$itemSql	= "UPDATE service_item SET kd_inventaris='$txtKodeInventaris', kerusakan='$txtKerusakan', serial_number='$txtSnAwal', keterangan='$txtKeterangan', harga_service='$txtHargaService', customer='$txtCustomer' WHERE no_service='$dataKode'";
			mysql_query($itemSql, $koneksidb) or die("Gagal Query Item : " . mysql_error());

			// Refresh form
			echo "<script>alert('Data Service Berhasil Diperbarui')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Service-Tampil'>";
		}
	}

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Service-Tampil'>";
	}

	?>
	<SCRIPT language="JavaScript">
		function submitform() {
			document.form1.submit();
		}
	</SCRIPT>
	<div class="table-border">
		<h2>EDIT TRANSAKSI SERVIS </h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group">
					<label id="tag" class="col-lg-12 control-label" style="border-radius: 5px; margin-bottom: 12px;">
						<ins><span class="glyphicon glyphicon-briefcase">&nbsp;</span>INPUT BARANG</ins>
					</label>
				</div>
				<div class="form-group">
					<label for="txtKodeInventaris" class="col-lg-2 control-label">Kode Barang</label>
					<div class="col-lg-4">
						<div class="input-group">
							<span class="input-group-btn">
								<a href="javaScript: void(0)" onclick="window.open('pencarian_barang_service.php')" target="_self">
									<button class="btn btn-info" type="button">Pencarian Barang</button>
								</a>
							</span>
							<input type="text" class="form-control" name="txtKodeInventaris" id="txtKodeInventaris" maxlength="12" value="<?php echo $dataKodeInventaris; ?>" placeholder="Search for kode barang..." autocomplete="off">
						</div>
					</div>
					<label for="txtKerusakan" class="col-lg-2 control-label">Kerusakan</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtKerusakan" id="txtKerusakan" value="<?php echo $dataKerusakan; ?>" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
				</div>
				<div class="form-group">
					<label for="txtNamaBrg" class="col-lg-2 control-label">Nama Barang</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtNamaBrg" id="txtNamaBrg" value="<?php echo $dataNamaBrg; ?>" placeholder="Nama Barang..." readonly>
					</div>
					<label for="harga" class="col-lg-2 control-label">Harga Servis</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="harga" name="txtHargaService" value="<?php echo format_angka($dataHargaService); ?>" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
				</div>
				<div class="form-group">
					<label for="txtCustomer" class="col-lg-2 control-label">Customer</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtCustomer" id="txtCustomer" value="<?php echo $dataCustomer; ?>">
					</div>
					<label for="txtSnAwal" class="col-lg-2 control-label">Serial Number Awal</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="txtSnAwal" name="txtSnAwal" value="<?php echo $dataSnAwal ?>" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
				</div>
				<div class="form-group">
					<label for="txtKeterangan" class="col-lg-2 control-label">Keterangan</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtKeterangan" id="txtKeterangan" value="<?php echo $dataKeterangan; ?>" autocomplete="off">
					</div>
				</div>
				<div class="form-group">
					<label for="files" class="col-lg-2 control-label">Surat Jalan</label>
					<div class="col-lg-4">
						<?php if ($formSuratJalan == "file0" || $formSuratJalan == "" || $formSuratJalan == NULL) : ?>
							<input class="form-control" type="file" id="files" name="files[]" style="display: block; margin-bottom: 15px;">
						<?php else :
							$ex = explode(';', $formSuratJalan);
							$no = 1;
							for ($i = 0; $i < count($ex); $i++) {
								if ($ex[$i] != '') {
									echo "<a target='_BLANK' class='form-control' style='display: block; margin-bottom: 15px;' href='user_data/" . $ex[$i] . "'>" . $ex[$i] . "</a>";
								}
								$no++;
							}
						?>
						<?php endif; ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-12 control-label" style="border-radius: 5px; margin-bottom: 12px;">
						<span class="glyphicon glyphicon-wrench">&nbsp;</span><ins>DATA SERVIS</ins>
					</label>
				</div>
				<div class="form-group">
					<label for="txtNomor" class="col-lg-2 control-label">Nomor Servis</label>
					<div class="col-lg-4">
						<input class="form-control" name="txtNomor" id="txtNomor" value="<?php echo $dataKode; ?>" readonly>
					</div>
					<label for="date" class="col-lg-2 control-label">Tanggal Kirim</label>
					<div class="col-lg-4">
						<input class="form-control" name="txtTanggalKirim" value="<?php echo $dataKirim; ?>" placeholder="dd-mm-yyyy" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
				</div>
				<div class="form-group">
					<label for="cmbLokasi" class="col-lg-2 control-label">Lokasi</label>
					<div class="col-lg-4">
						<select name="cmbLokasi" id="cmbLokasi" data-live-search="true" class="selectpicker show-tick form-control">
							<option value=""> Pilih Lokasi </option>
							<?php
							$mySql = "SELECT * FROM departemen ORDER BY kd_departemen";
							$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
							while ($myData = mysql_fetch_array($myQry)) {
								if ($dataLokasi == $myData['kd_departemen']) {
									$cek = " selected";
								} else {
									$cek = "";
								}
								echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen]</option>";
							}
							?>
						</select>
					</div>
					<label for="cmbVendor" class="col-lg-2 control-label">Vendor Servis</label>
					<div class="col-lg-4">
						<select name="cmbVendor" id="cmbVendor" data-live-search="true" class="selectpicker show-tick form-control">
							<option value=""> Pilih Vendor Service </option>
							<?php
							$mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
							$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
							while ($myData = mysql_fetch_array($myQry)) {
								if ($dataVendor == $myData['kd_supplier']) {
									$cek = " selected";
								} else {
									$cek = "";
								}
								echo "<option value='$myData[kd_supplier]' $cek>$myData[nm_supplier]</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10" style="display: block; margin-top: 20px;">
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