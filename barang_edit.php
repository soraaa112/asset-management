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

	# TAMPILKAN DATA UNTUK DIEDIT
	$Kode	 = $_GET['Kode'];
	$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	# MASUKKAN DATA KE VARIABEL
	$dataKode	= $myData['kd_barang'];
	$dataFoto	= $myData['foto'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_barang'];
	$dataSatuan		= isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : $myData['satuan'];
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $myData['kd_kategori'];

	if (isset($_POST['btnSimpan'])) {
		# Baca Variabel Form
		$txtNama		= $_POST['txtNama'];
		$txtNama		= str_replace("'", "&acute;", $txtNama); // menghalangi penulisan tanda petik satu (')
		$cmbSatuan		= $_POST['cmbSatuan'];
		$cmbKategori	= $_POST['cmbKategori'];

		# Validasi form, jika kosong sampaikan pesan error
		$pesanError = array();
		if (trim($txtNama) == "") {
			$pesanError[] = "Data <b>Nama Barang</b> tidak boleh kosong !";
		}
		if (trim($cmbSatuan) == "Kosong") {
			$pesanError[] = "Data <b>Satuan Barang</b> belum dipilih !";
		}
		if (trim($cmbKategori) == "Kosong") {
			$pesanError[] = "Data <b>Kategori Barang</b> belum dipilih !";
		}

		# Validasi Nama barang, jika sudah ada akan ditolak
		$Kode	= $_POST['txtKode'];
		$sqlCek	= "SELECT * FROM barang WHERE nm_barang='$txtNama' AND NOT(kd_barang='$Kode')";
		$qryCek	= mysql_query($sqlCek, $koneksidb) or die("Eror Query" . mysql_error());
		if (mysql_num_rows($qryCek) >= 1) {
			$pesanError[] = "Maaf, Nama Barang <b> $txtNama </b> sudah dipakai, ganti dengan yang lain";
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
			$desired_dir = [];
			$uploaded_files = [];
			$desired_dir = "user_data";
			$errors = array();
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

			// Gabungkan data file lama dengan file baru
			$all_files = array_filter(array_merge(explode(';', $dataFoto), $uploaded_files));

			// Simpan data file gabungan kembali ke database
			$fileName = implode(';', $all_files);
			# TIDAK ADA ERROR, Jika jumlah error message tidak ada, simpan datanya
			$Kode	= $_POST['txtKode'];
			$mySql	= "UPDATE barang SET nm_barang='$txtNama',
									satuan='$cmbSatuan',
									kd_kategori='$cmbKategori',
									foto='$fileName' WHERE kd_barang ='$Kode'";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Barang Berhasil Diubah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
			}
			exit;
		}
	} // Penutup POST

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
	}


	?>

	</SCRIPT>
	<div class="table-border">
		<h2>LENGKAPI DATA ASET BARANG</h2>
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
					<label for="txtNama" class="col-lg-2 control-label">Type</label>
					<div class="col-lg-4">
						<input name="txtNama" value="<?php echo $dataNama; ?>" class="form-control" autocomplete="off" style="display: block; margin-bottom: 10px;" />
						<input name="txtLama" type="hidden" value="<?php echo $myData['nm_barang']; ?>" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="cmbKategori" class="col-lg-2 control-label">Kategori</label>
					<div class="col-lg-4" style="display: block; margin-bottom: 10px;">
						<select name="cmbKategori" id="cmbKategori" data-live-search="true" class="selectpicker show-tick form-control" autocomplete="off">
							<option value="Kosong"> Pilih Kategori </option>
							<?php
							$mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
							$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
							while ($myDataa = mysql_fetch_array($myQry)) {
								if ($myDataa['kd_kategori'] == $dataKategori) {
									$cek = " selected";
								} else {
									$cek = "";
								}
								echo "<option value='$myDataa[kd_kategori]' $cek>$myDataa[nm_kategori] </option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="cmbSatuan" class="col-lg-2 control-label">Satuan</label>
					<div class="col-lg-4" style="display: block; margin-bottom: 10px;">
						<select name="cmbSatuan" id="cmbSatuan" data-live-search="true" class="selectpicker show-tick form-control" autocomplete="off">
							<option value="Kosong"> Pilih Satuan </option>
							<?php
							include_once "library/inc.pilihan.php";
							foreach ($satuan as $nilai) {
								if ($dataSatuan == $nilai) {
									$cek = " selected";
								} else {
									$cek = "";
								}
								echo "<option value='$nilai' $cek>$nilai</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="file" class="col-lg-2 control-label">Foto (Multiple Upload)</label>
					<div class="col-lg-4">
						<input type="file" class="form-control" name="files[]" autocomplete="off" style="display: block; margin-bottom: 10px;">

					</div>
				</div>
				<div class="col-lg-offset-2 col-lg-10" style="display: block; margin-top: 40px;">
					<button type="submit" name="btnSimpan" class="btn btn-success">
						<span class="glyphicon glyphicon-floppy-saved" aria-hidden="true">&nbsp;</span><b>SIMPAN</b>
					</button>
					<button type="submit" name="btnKembali" class="btn btn-danger">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true">&nbsp;</span><b>KEMBALI</b>
					</button>
				</div>
		</form>
	</div>