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
	$mySql	 = "SELECT barang_mati.*, barang.nm_barang, barang_inventaris.*
						FROM barang_mati 
						LEFT JOIN barang_inventaris on barang_mati.kd_inventaris=barang_inventaris.kd_inventaris
						LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
						LEFT JOIN lokasi on barang_mati.pelanggan=lokasi.kd_lokasi
						WHERE barang_mati.no_barang_mati='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	$dataKode           = $myData['no_barang_mati'];
	$dataKodeInventaris	= isset($_POST['txtKodeInventaris']) ? $_POST['txtKodeInventaris'] : $myData['kd_inventaris'];
	$dataKirim 	    	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : IndonesiaTgl($myData['tanggal']);
	$dataKerusakan	    = isset($_POST['txtKerusakan']) ? $_POST['txtKerusakan'] : $myData['kerusakan'];
	$dataCustomer	    = isset($_POST['txtCustomer']) ? $_POST['txtCustomer'] : $myData['pelanggan'];
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
	$dataNamaBrg	    = isset($_POST['txtNamaBrg']) ? $_POST['txtNamaBrg'] : $myData['nm_barang'];
	$dataSnAwal			= isset($_POST['serial_number']) ? $_POST['serial_number'] : $myData['serial_number'];
	$fileName			= $myData['foto'];
	# ========================================================================================================
	# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
	if (isset($_POST['btnSimpan'])) {
		// Baca variabel from

		$txtKodeInventaris	= $_POST['txtKodeInventaris'];
		$txtKodeInventaris	= str_replace("'", "&acute;", $txtKodeInventaris);
		$txtKeterangan 		= $_POST['txtKeterangan'];
		$txtCustomer		= $_POST['txtCustomer'];
		$txtKerusakan		= $_POST['txtKerusakan'];
		$tanggal 			= InggrisTgl($_POST['txtTanggal']);
		$snAwal				= $_POST['serial_number'];
		$pesanError			= [];
		$errors 			= [];
		$uploaded_files	 	= [];
		$desired_dir 		= "user_data";

		if ($fileName == "" || $fileName == null) {
			foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
				$file_name = $_FILES['files']['name'][$key];
				$file_size = $_FILES['files']['size'][$key];
				$file_tmp = $_FILES['files']['tmp_name'][$key];
				$file_type = $_FILES['files']['type'][$key];
				if ($file_size > 9097152) {
					$errors[] = 'File size must be less than 2 MB';
				}

				if (empty($errors) == true) {
					$namaFileBaru	= uniqid();
					$namaFileBaru .= '-';
					$namaFileBaru .= $file_name;
					if (move_uploaded_file($file_tmp, "$desired_dir/$namaFileBaru")) {
						$uploaded_files[] = $namaFileBaru; // Simpan nama file yang berhasil diunggah
					}
				} else {
					print_r($errors);
				}
			}
			// Menyimpan nama-nama file yang berhasil diunggah
			$foto = !empty($uploaded_files) ? implode(';', $uploaded_files) : '';
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
			if ($fileName == "" || $fileName == null) {
				$mySql	= "UPDATE barang_mati SET foto='$foto' WHERE no_barang_mati='$dataKode'";
				mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			}

			$mySql	= "UPDATE barang_mati SET kd_inventaris='$txtKodeInventaris', tanggal='$tanggal', pelanggan='$txtCustomer', keterangan='$txtKeterangan', serial_number='$snAwal', kerusakan='$txtKerusakan' WHERE no_barang_mati='$dataKode'";
			mysql_query($mySql, $koneksidb) or die("Gagal query barang mati " . mysql_error());

			// Refresh form
			echo "<script>alert('Data Barang Mati Berhasil Diperbarui')</script>";
			echo "<meta http-equiv='refresh' content='3; url=?open=Barang-Mati-Tampil'>";
		}
	}

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Mati-Tampil'>";
	}

	?>
	<SCRIPT language="JavaScript">
		function submitform() {
			document.form1.submit();
		}
	</SCRIPT>
	<div class="table-border">
		<h2>EDIT TRANSAKSI BARANG MATI </h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group">
					<label id="tag" class="col-lg-12 control-label" style="border-radius: 5px; margin-bottom: 10px;">
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
						<input type="text" class="form-control" name="txtNamaBrg" id="txtNamaBrg" value="<?php echo $dataNamaBrg; ?>" placeholder="Nama Barang..." style="border-radius: 5px; margin-bottom: 10px;" readonly>
					</div>
					</div>
					<div class="form-group">
					<label for="txtCustomer" class="col-lg-2 control-label">Pelanggan</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtCustomer" id="txtCustomer" value="<?php echo $dataCustomer; ?>" style="border-radius: 5px; margin-bottom: 10px;">
					</div>
					<div class="form-group">
					<label for="txtNomor" class="col-lg-2 control-label">Nomor Barang Mati</label>
					<div class="col-lg-4">
						<input class="form-control" name="txtNomor" id="txtNomor" value="<?php echo $dataKode; ?>" style="border-radius: 5px; margin-bottom: 10px;" readonly>
					</div>
					<div class="form-group">
					<label for="txtKeterangan" class="col-lg-2 control-label">Keterangan</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtKeterangan" id="txtKeterangan" value="<?php echo $dataKeterangan; ?>" autocomplete="off" style="border-radius: 5px; margin-bottom: 10px;">
					</div>
					<label for="serial_number" class="col-lg-2 control-label">Serial Number</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo $dataSnAwal ?>" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
					<label for="date" class="col-lg-2 control-label">Tanggal</label>
					<div class="col-lg-4">
						<input class="form-control" name="txtTanggal" value="<?php echo $dataKirim; ?>" placeholder="dd-mm-yyyy" autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
					<label for="foto" class="col-lg-2 control-label">Foto</label>
					<div class="col-lg-4">
						<?php if ($fileName == "file0" || $fileName == "" || $fileName == NULL) : ?>
							<input class="form-control" type="file" id="files" name="files[]">
						<?php else :
							$ex = explode(';', $fileName);
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