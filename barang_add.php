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

	# TOMBOL SIMPAN DIKLIK
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
		$sqlCek = "SELECT * FROM barang WHERE nm_barang='$txtNama'";
		$qryCek = mysql_query($sqlCek, $koneksidb) or die("Eror Query" . mysql_error());
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
			$errors = array();
			foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
				$file_name = $key . $_FILES['files']['name'][$key];
				$file_size = $_FILES['files']['size'][$key];
				$file_tmp = $_FILES['files']['tmp_name'][$key];
				$file_type = $_FILES['files']['type'][$key];
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
			# SIMPAN DATA KE DATABASE. // Jika tidak menemukan error, simpan data ke database
			$kodeBarang	= $_POST['textfield'];
			$mySql	= "INSERT INTO barang (kd_barang, nm_barang, satuan, jumlah, kd_kategori, foto) 
							VALUES ('$kodeBarang',
									'$txtNama',
									'$cmbSatuan',
									'0',
									'$cmbKategori',
									'$fileName')";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Barang Berhasil Ditambah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
			}
			exit;
		}
	} // Penutup POST

	# MASUKKAN DATA KE VARIABEL
	$dataKode		= buatKode5($koneksidb, "barang", "B");
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataSatuan		= isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : '';
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
	?>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" target="_self" enctype="multipart/form-data">
		<table width="100%" cellpadding="2" cellspacing="1" class="table-list" style="margin-top:0px;">
			<tr>
				<th colspan="3">TAMBAH DATA ASET BARANG </th>
			</tr>
			<tr>
				<td width="17%"><b>Kode</b></td>
				<td width="1%"><b>:</b></td>
				<td width="82%"><input name="textfield" value="<?php echo $dataKode; ?>" size="26" maxlength="10" readonly /></td>
			</tr>
			<tr>
				<td><b>Type</b></td>
				<td><b>:</b></td>
				<td><input name="txtNama" value="<?php echo $dataNama; ?>" size="26" maxlength="100" /></td>
			</tr>
			<td><strong>Satuan</strong></td>
			<td><b>:</b></td>
			<td><b>
					<select name="cmbSatuan" data-live-search="true" class="selectpicker">
						<option value="Kosong"> Pilih Satuan </option>
						<?php
						// Menampilkan data Satuan  ke comboBox, satuan ada pada file library/inc.pilihan.php
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
						// Menampilkan data kategori ke comboBox
						$mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
						$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
						while ($myData = mysql_fetch_array($myQry)) {
							if ($myData['kd_kategori'] == $dataKategori) {
								$cek = " selected";
							} else {
								$cek = "";
							}
							echo "<option value='$myData[kd_kategori]' $cek>$myData[nm_kategori] </option>";
						}
						?>
					</select></td>
			</tr>
			<tr>
				<td><b>Foto (Multiple Upload)</b></td>
				<td><b>:</b></td>
				<td><input type='file' name="files[]" multiple /></td>
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
		<strong># Note:</strong> Jumlah barang akan bertambah dari Transaksi Pengadaan Barang
	</form>