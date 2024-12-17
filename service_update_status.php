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
	$mySql = "SELECT services.*, service_item.serial_number, service_item.serial_number_baru, service_item.kd_inventaris, service_item.kerusakan, service_item.harga_service, service_item.keterangan as berita_acara, supplier.nm_supplier, barang.nm_barang, barang_inventaris.kd_inventaris, service_item.kerusakan, service_item.harga_service, service_item.customer
	FROM services 
	LEFT JOIN supplier ON services.kd_supplier=supplier.kd_supplier
	LEFT JOIN service_item ON services.no_service=service_item.no_service
	LEFT JOIN barang_inventaris ON service_item.kd_inventaris=barang_inventaris.kd_inventaris
	LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
	LEFT JOIN petugas ON services.kd_petugas=petugas.kd_petugas
	WHERE services.no_service='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die("Query ambil data salah : " . mysql_error());
	$item = mysql_fetch_array($myQry);

	$dataKodeInventaris 	= $item['kd_inventaris'];
	$dataNamaBrg 			= $item['nm_barang'];
	$dataKode 				= $item['no_service'];
	$lokasi 				= $item['lokasi'];
	$status 				= $item['status'];
	$fotoKwitansi 			= $item['foto'];
	$formSuratJalan  		= $item['surat_jalan'];
	$dataKirim 				= $item['tgl_kirim'] ? IndonesiaTgl($item['tgl_kirim']) : '';
	$dataTglSampai 			= $item['tgl_sampai'] ? IndonesiaTgl($item['tgl_sampai']) : '';
	$dataTglService 		= $item['tgl_service'] ? IndonesiaTgl($item['tgl_service']) : '';
	$dataTglReturn 			= $item['tgl_return'] ? IndonesiaTgl($item['tgl_return']) : '';
	$dataHarga 				= isset($_POST['txtHargaService']) ? $_POST['txtHargaService'] : format_angka($item['harga_service']);
	$dataCustomer 			= isset($_POST['txtCustomer']) ? $_POST['txtCustomer'] : $item['customer'];
	$dataKerusakan 			= isset($_POST['txtKerusakan']) ? $_POST['txtKerusakan'] : $item['kerusakan'];
	$dataKeterangan 		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $item['keterangan'];
	$dataBeritaAcara 		= isset($_POST['txtBeritaAcara']) ? $_POST['txtBeritaAcara'] : $item['berita_acara'];
	$dataSerialNumber 		= isset($_POST['txtSerialNumber']) ? $_POST['txtSerialNumber'] : $item['serial_number'];
	$dataNewSerialNumber 	= isset($_POST['txtNewSerialNumber']) ? $_POST['txtNewSerialNumber'] : $item['serial_number_baru'];

	# ========================================================================================================
	# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
	if (isset($_POST['btnSimpan'])) {
		// Baca variabel from
		if (!$item['harga_service']) {
			$hargaService	= $_POST['txtHargaService'];
		} else {
			$hargaService	= $item['harga_service'];
		}

		$tglSampai 		= $_POST['txtTanggalSampai'] ? InggrisTgl($_POST['txtTanggalSampai']) : '';
		$tglService 	= $_POST['txtTanggalService'] ? InggrisTgl($_POST['txtTanggalService']) : '';
		$tglReturn 		= $_POST['txtTanggalReturn'] ? InggrisTgl($_POST['txtTanggalReturn']) : '';
		$cmbVendor		= $_POST['cmbVendor'];
		$serialNumber	= $_POST['txtNewSerialNumber'];
		$keterangan		= $_POST['txtKeterangan'];
		$cmbStatus		= $_POST['cmbStatus'];
		$errors = array();
		foreach ($_FILES['files2']['tmp_name'] as $key => $tmp_name) {
			$file_name = 'file' . $key . $_FILES['files2']['name'][$key];
			$file_size = $_FILES['files2']['size'][$key];
			$file_tmp = $_FILES['files2']['tmp_name'][$key];
			$file_type = $_FILES['files2']['type'][$key];
			if ($file_size > 9097152) {
				$errors[] = 'File size must be less than 2 MB';
			}
			$images[] = $file_name;
			$desired_dir = "user_data";
			if (empty($errors) == true) {
				if (is_dir($desired_dir) == false) {
					mkdir("$desired_dir", 0700);	// Create directory if it does not exist
				}
				if (is_dir("$desired_dir/" . $file_name) == false) {
					move_uploaded_file($file_tmp, "$desired_dir/" . $file_name);
				} else {
					$new_dir = "$desired_dir/" . $file_name . time();
					rename($file_tmp, $new_dir);
				}
			} else {
				print_r($errors);
			}
		}

		if (implode('', $images) != '' or implode('', $images) != '0') {
			$fileName = implode(';', $images);
		} else {
			$fileName = '';
		}

		// Validasi form
		$pesanError = array();
		// if (trim($cmbVendor) == "Kosong") {
		// 	$pesanError[] = "Data <b> Nama Supplier</b> belum dipilih, silahkan pilih pada combo !";
		// }
		// if (trim($fileName) == "file" or trim($fileName) == "file0") {
		// 	$pesanError[] = "Data <b> Kwitansi / Nota</b> belum diupload/lampirkan!";
		// }

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
			# SIMPAN DATA KE DATABASE
			if ($tglService) {
				$mySql	= "UPDATE services SET tgl_service = '$tglService' WHERE no_service = '$Kode'";
				mysql_query($mySql, $koneksidb) or die("Gagal query service " . mysql_error());
			}

			if ($tglReturn) {
				$mySql	= "UPDATE services SET tgl_return = '$tglReturn' WHERE no_service = '$Kode'";
				mysql_query($mySql, $koneksidb) or die("Gagal query service " . mysql_error());
			}

			if ($tglSampai) {
				$mySql	= "UPDATE services SET tgl_sampai = '$tglSampai' WHERE no_service = '$Kode'";
				mysql_query($mySql, $koneksidb) or die("Gagal query service " . mysql_error());
			}

			$mySql	= "UPDATE services SET kd_supplier = '$cmbVendor', status = '$cmbStatus', foto = '$fileName', keterangan = '$keterangan' WHERE no_service = '$Kode'";
			mysql_query($mySql, $koneksidb) or die("Gagal query service " . mysql_error());

			$query = "UPDATE service_item SET serial_number_baru = '$serialNumber', harga_service = '$hargaService' WHERE no_service = '$Kode'";
			mysql_query($query, $koneksidb) or die("Gagal query service " . mysql_error());

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
		<h2>UPDATE TRANSAKSI SERVIS </h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group">
					<label id="tag" class="col-lg-12 control-label" style="border-radius: 5px; margin-bottom: 12px;">
						<ins><span class="glyphicon glyphicon-briefcase">&nbsp;</span>INPUT BARANG</ins>
					</label>
				</div>
				<div class=" form-group">
					<label for="txtKodeInventaris" class="col-lg-2 control-label">Kode Barang</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtKodeInventaris" id="txtKodeInventaris" maxlength="12" value="<?php echo $dataKodeInventaris; ?>" placeholder="Search for kode barang..." autocomplete="off" readonly>
					</div>
					<label for="txtKerusakan" class="col-lg-2 control-label">Kerusakan</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtKerusakan" id="txtKerusakan" value="<?php echo $dataKerusakan; ?>" autocomplete="off" style="display: block; margin-bottom: 12px;" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="txtNamaBrg" class="col-lg-2 control-label">Nama Barang</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtNamaBrg" id="txtNamaBrg" value="<?php echo $dataNamaBrg; ?>" placeholder="Nama Barang..." readonly>
					</div>
					<label for="harga" class="col-lg-2 control-label">Harga Servis</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="harga" name="txtHargaService" value="<?php echo $dataHarga; ?>" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
				</div>
				<div class="form-group">
					<label for="txtCustomer" class="col-lg-2 control-label">Customer</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtCustomer" id="txtCustomer" value="<?php echo $dataCustomer; ?>" readonly>
					</div>
					<label for="txtSerialNumber" class="col-lg-2 control-label">Serial Number Awal</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="txtSerialNumber" name="txtSerialNumber" value="<?php echo $dataSerialNumber ?>" autocomplete="off" style="display: block; margin-bottom: 12px;" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="txtBeritaAcara" class="col-lg-2 control-label">Keterangan</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtBeritaAcara" id="txtBeritaAcara" value="<?php echo $dataBeritaAcara; ?>" autocomplete="off" readonly>
					</div>
					<label for="txtNewSerialNumber" class="col-lg-2 control-label">Serial Number Akhir</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtNewSerialNumber" id="txtNewSerialNumber" value="<?php echo $dataNewSerialNumber; ?>" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
				</div>
				<div class="form-group">
					<label for="files" class="col-lg-2 control-label">Surat Jalan</label>
					<div class="col-lg-4">
						<?php if ($formSuratJalan == "file0" || $formSuratJalan == "" || $formSuratJalan == NULL) : ?>
							<input class="form-control" type="text" id="files" name="files[]" style="display: block; margin-bottom: 15px;" placeholder="Tidak Ada Bukti Surat Jalan.." readonly>
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
						<input class="form-control" name="txtNomor" id="txtNomor" value="<?php echo $dataKode; ?>" style="display: block; margin-bottom: 12px;" readonly>
					</div>
					<label for="date2" class="col-lg-2 control-label">Tanggal Servis</label>
					<div class="col-lg-4">
						<input class="form-control" id="date2" name="txtTanggalService" value="<?php echo $dataTglService; ?>" placeholder="dd-mm-yyyy" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
				</div>
				<div class="form-group">
					<label for="date" class="col-lg-2 control-label">Tanggal Kirim</label>
					<div class="col-lg-4">
						<input class="form-control" name="txtTanggalKirim" value="<?php echo $dataKirim; ?>" placeholder="dd-mm-yyyy" autocomplete="off" readonly>
					</div>
					<label for="date3" class="col-lg-2 control-label">Tanggal Return</label>
					<div class="col-lg-4">
						<input class="form-control" id="date3" name="txtTanggalReturn" value="<?php echo $dataTglReturn; ?>" placeholder="dd-mm-yyyy" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
				</div>
				<div class="form-group">
					<label for="date" class="col-lg-2 control-label">Tanggal Sampai</label>
					<div class="col-lg-4">
						<input class="form-control" id="date" name="txtTanggalSampai" value="<?php echo $dataTglSampai; ?>" placeholder="dd-mm-yyyy" autocomplete="off">
					</div>
					<label for="waktu" class="col-lg-2 control-label">Jangka Waktu</label>
					<div class="col-lg-4">
						<input class="form-control"
							<?php
							if ($item['tgl_service'] == NULL || $item['tgl_return'] == NULL) {
								$hari = '0';
							} elseif ($item['tgl_service'] != $item['tgl_return']) {
								$date1 = date_create($item['tgl_service']);
								$date2 = date_create($item['tgl_return']);
								$interval = date_diff($date1, $date2);
								$hari = $interval->format('%a') + 1;
							} else {
								$hari = '1';
							}
							?>
							value="<?php echo $hari; ?> Hari" style="display: block; margin-bottom: 12px;" readonly />
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
								if ($lokasi == $myData['kd_departemen']) {
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
					<label for="files2" class="col-lg-2 control-label" style="display: block; margin-top: 12px;">Kwitansi</label>
					<div class="col-lg-4">
						<?php if ($fotoKwitansi == "file0" || $fotoKwitansi == "" || $fotoKwitansi == NULL) : ?>
							<input class="form-control" type="file" id="files2" name="files2[]" style="display: block; margin-top: 12px; margin-bottom: 12px;" multiple>
						<?php else :
							$ex = explode(';', $fotoKwitansi);
							$no = 1;
							for ($i = 0; $i < count($ex); $i++) {
								if ($ex[$i] != '') {
									echo "<a target='_BLANK' class='form-control' style='display: block; margin-top: 12px; margin-bottom: 12px;' href='user_data/" . $ex[$i] . "'>" . $ex[$i] . "</a>";
								}
								$no++;
							}
						?>
						<?php endif; ?>
					</div>
					<label for="txtKeterangan" class="col-lg-2 control-label" style="display: block; margin-top: 12px;">Keterangan</label>
					<div class="col-lg-4">
						<input class="form-control" id="txtKeterangan" name="txtKeterangan" value="<?php echo $dataKeterangan ?>" autocomplete="off" style="display: block; margin-top: 12px; margin-bottom: 12px;" />
					</div>
				</div>
				<div class="form-group">
					<label for="cmbStatus" class="col-lg-2 control-label">Status</label>
					<div class="col-lg-4">
						<select name="cmbStatus" id="cmbStatus" data-live-search="true" class="selectpicker show-tick form-control">
							<option value=""> Pilih Status </option>
							<option value="IDLE" <?php echo ($status == "IDLE") ? "selected" : ""; ?>> IDLE </option>
							<option value="PROCESS" <?php echo ($status == "PROCESS") ? "selected" : ""; ?>>PROCESS</option>
							<option value="SEND" <?php echo ($status == "SEND") ? "selected" : ""; ?>>SEND</option>
							<option value="DONE" <?php echo ($status == "DONE") ? "selected" : ""; ?>>DONE</option>
							<option value="CANCEL" <?php echo ($status == "CANCEL") ? "selected" : ""; ?>>CANCEL</option>
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