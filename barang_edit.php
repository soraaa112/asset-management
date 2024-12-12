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
	?>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit" enctype="multipart/form-data">
		<table class="table-list" width="100%" style="margin-top:0px;">
			<tr>
				<th colspan="3">LENGKAPI DATA ASET BARANG </th>
			</tr>
			<tr>
				<td width="17%"><strong>Kode </strong></td>
				<td width="1%"><strong>:</strong></td>
				<td width="82%"><input name="textfield" value="<?php echo $dataKode; ?>" size="26" maxlength="10" readonly="readonly" />
					<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
				</td>
			</tr>
			<tr>
				<td><b>Type</b></td>
				<td><strong>:</strong></td>
				<td><input name="txtNama" value="<?php echo $dataNama; ?>" size="26" maxlength="100" />
					<input name="txtLama" type="hidden" value="<?php echo $myData['nm_barang']; ?>" />
				</td>
			</tr>
			<tr>
				<td><strong>Satuan</strong></td>
				<td><strong>:</strong></td>
				<td><b>
						<select name="cmbSatuan" data-live-search="true" class="selectpicker">
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
					</b></td>
			</tr>
			<tr>
				<td><strong>Kategori </strong></td>
				<td><strong>:</strong></td>
				<td><select name="cmbKategori" data-live-search="true" class="selectpicker">
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
					</select></td>
			</tr>
			<tr>
				<td><b>Foto (Multiple Upload)</b></td>
				<td><b>:</b></td>
				<td>
					<?php
					$ex = explode(';', $myData['foto']);
					$no = 1;
					for ($i = 0; $i < count($ex); $i++) {
						if ($ex[$i] != '') {
							echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'><img style='margin-right:5px' width='50px' src='user_data/" . $ex[$i] . "'></a>";
						}
						$no++;
					}
					?>
					<br>
					<input type='file' name="files[]" multiple />
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input type="submit" name="btnSimpan" value=" Simpan " style="cursor:pointer;">
					<a href="?open=Barang-Data">
						<input type="button" value=" Kembali " />
					</a>
				</td>
			</tr>
		</table>
	</form>