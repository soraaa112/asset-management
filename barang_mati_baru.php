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

	# ========================================================================================================
	# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
	if (isset($_POST['btnSimpan'])) {
		// Baca variabel from
		$txtKodeInventaris	= $_POST['txtKodeInventaris'];
		$txtKodeInventaris	= str_replace("'", "&acute;", $txtKodeInventaris);
		$txtDeskripsi		= $_POST['txtDeskripsi'];
		$txtDeskripsi		= str_replace("'", "&acute;", $txtDeskripsi);
		$txtDeskripsi		= str_replace(".", "", $txtDeskripsi);
		$txtKeterangan 		= $_POST['txtKeterangan'];
		$txtCustomer		= $_POST['txtCustomer'];
		$tanggal 			= InggrisTgl($_POST['txtTanggal']);
		$txtSnAwal			= $_POST['serial_number'];
		$pesanError			= [];
		$errors 			= [];
		$uploaded_files	 	= [];
		$desired_dir 		= "user_data";

		foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
			$fileName = $_FILES['files']['name'][$key];
			$file_size = $_FILES['files']['size'][$key];
			$file_tmp = $_FILES['files']['tmp_name'][$key];
			$file_type = $_FILES['files']['type'][$key];
			if ($file_size > 9097152) {
				$errors[] = 'File size must be less than 2 MB';
			}

			if (empty($errors) == true) {
				$namaFileBaru	= uniqid();
				$namaFileBaru .= '-';
				$namaFileBaru .= $fileName;
				if (move_uploaded_file($file_tmp, "$desired_dir/$namaFileBaru")) {
					$uploaded_files[] = $namaFileBaru; // Simpan nama file yang berhasil diunggah
				}
			} else {
				print_r($errors);
			}
		}

		$fileName = !empty($uploaded_files) ? implode(';', $uploaded_files) : '';

		if (trim($txtKodeInventaris) != "") {
			# Periksa Database 1, apakah Kode Inventaris yang dimasukkan ada di dalam Database
			$cekSql	= "SELECT * FROM barang_inventaris WHERE kd_inventaris='$txtKodeInventaris' or RIGHT(kd_inventaris,6) ='$txtKodeInventaris'";
			$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query" . mysql_error());
			if (mysql_num_rows($cekQry) < 1) {
				$pesanError[] = "Kode Barang <b>$txtKodeInventaris</b> tidak ditemukan dalam database!";
			}

			if (trim($txtDeskripsi) == "") {
				$pesanError[] = "<b>Kerusakan belum diisi</b>, silahkan isi terlebih dahulu";
			}

			if (trim($tanggal) == "--") {
				$pesanError[] = "Data <b>Tanggal</b> belum diisi, pilih pada combo !";
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
			$kodeBaru = buatKode7($koneksidb, "barang_mati", "BM");
			$mySql	= "INSERT INTO barang_mati (no_barang_mati, kd_inventaris, tanggal, kd_petugas, kerusakan, pelanggan, keterangan, serial_number, foto, status_approval_barang_mati) 
			VALUES ('$kodeBaru','$txtKodeInventaris','$tanggal','$userLogin','$txtDeskripsi','$txtCustomer','$txtKeterangan','$txtSnAwal','$fileName', 'Belum Approve')";
			mysql_query($mySql, $koneksidb) or die("Gagal Query Item : " . mysql_error());

			// Refresh form
			echo "<script>alert('Data Barang Mati Berhasil Ditambah')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Mati-Tampil'>";
		}
	}

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Mati-Tampil'>";
	}

	# TAMPILKAN DATA KE FORM
	$noTransaksi 	= buatKode7($koneksidb, "barang_mati", "BM");
	?>
	<SCRIPT language="JavaScript">
		function submitform() {
			document.form1.submit();
		}
	</SCRIPT>
	<div class="table-border">
		<h2>TRANSAKSI BARANG MATI</h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" 		enctype="multipart/form-data">
					<div class="row">
					<div class="form-group">
					<label id="tag" class="col-lg-12 control-label" style="border-radius: 5px; margin-bottom: 12px;">
						<ins><span class="glyphicon glyphicon-briefcase">&nbsp;</span>INPUT BARANG</ins></label>
					</div>
					<div class="form-group">
					<label for="txtKodeInventaris" class="col-lg-2 control-label">Kode Barang</label>
					<div class="col-lg-4">
						<div class="input-group">
							<span class="input-group-btn">
								<a href="javaScript: void(0)" onclick="window.open('pencarian_barang_mati.php')" target="_self">
									<button class="btn btn-info" type="button">Pencarian Barang</button>
								</a>
							</span>
							<input type="text" class="form-control" name="txtKodeInventaris" id="txtKodeInventaris" maxlength="12" placeholder="Search for kode barang..." autocomplete="off">
						</div>
					</div>
					<div class="form-group">
					<label for="txtDeskripsi" class="col-lg-2 control-label">Kerusakan</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtDeskripsi" id="txtDeskripsi" autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
					<div class="form-group">
					<label for="txtNamaBrg" class="col-lg-2 control-label">Nama Barang</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtNamaBrg" id="txtNamaBrg" placeholder="Nama Barang..." style="display: block; margin-bottom: 10px;" readonly>
					</div>
					<div class="form-group">
					<label for="txtCustomer" class="col-lg-2 control-label">Pelanggan</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtCustomer" id="txtCustomer" style="display: block; margin-bottom: 10px;">
					</div>
						<label for="txtNomor" class="col-lg-2 control-label">Nomor Barang Mati</label>
					<div class="col-lg-4">
						<input class="form-control" name="txtNomor" id="txtNomor" value="<?php echo $noTransaksi; ?>" style="display: block; margin-bottom: 10px;" readonly>
					</div>
					<div class="form-group">
					<label for="txtKeterangan" class="col-lg-2 control-label">Keterangan</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtKeterangan" id="txtKeterangan" autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
					<div class="form-group">
					<label for="serial_number" class="col-lg-2 control-label">Serial Number</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="serial_number" id="serial_number"
						style="display: block; margin-bottom: 10px;">
					</div>
					<label for="date" class="col-lg-2 control-label">Tanggal</label>
					<div class="col-lg-4">
						<input id="date" class="form-control" name="txtTanggal" placeholder="dd-mm-yyyy" autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
				
					</div>
					<label for="date" class="col-lg-2 control-label">Foto (Multiple Upload)</label>
					<div class="col-lg-4">
						<input id="date" class="form-control"  type='file' name="files[]" multiple style="display: block; margin-bottom: 10px;">
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