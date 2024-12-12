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

	# HAPUS DAFTAR BARANG DI TMP
	if (isset($_GET['Act'])) {
		$Act	= $_GET['Act'];
		$ID		= $_GET['ID'];

		if (trim($Act) == "Delete") {
			# Hapus Tmp jika datanya sudah dipindah
			$sql	= "SELECT * FROM tmp_pengadaan WHERE id = '$ID' AND kd_petugas = '$userLogin'";
			$query 	= mysql_query($sql, $koneksidb) or die("Gagal query tmp : " . mysql_error());
			if (mysql_num_rows($query) > 0) {
				$data 	= mysql_fetch_array($query);
				$no 	= $data['no_pengadaan'];
				$barang = $data['kd_barang'];

				$deleteSql = "DELETE FROM pengadaan_item WHERE no_pengadaan = '$no' AND kd_barang = '$barang'";
				mysql_query($deleteSql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());
			}

			$mySql 	= "DELETE FROM tmp_pengadaan WHERE id='$ID' AND kd_petugas='$userLogin'";
			mysql_query($mySql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());
		}
	}

	# TAMPILKAN DATA KE FORM
	$Kode	= $_GET['Kode'];
	$mySql	= "SELECT pengadaan.*, pengadaan_item.harga_beli, pengadaan_item.kd_barang, petugas.nm_petugas, departemen.*, lokasi.* FROM pengadaan
	LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan = pengadaan_item.no_pengadaan
	LEFT JOIN departemen ON pengadaan.kd_departemen = departemen.kd_departemen
	LEFT JOIN lokasi ON pengadaan.kd_lokasi = lokasi.kd_lokasi
	LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
	WHERE pengadaan.no_pengadaan='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die("Query ambil data salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	$noPengadaan 	= $myData['no_pengadaan'];
	$tglTransaksi 	= $myData['tgl_pengadaan'];
	$dataDepartemen	= $myData['kd_departemen'];
	$dataLokasi		= $myData['kd_lokasi'];
	$dataJenis		= $myData['jenis_pengadaan'];
	$dataKeterangan	= $myData['keterangan'];
	$dataNomorResi	= $myData['nomor_resi'];
	$tmpHargaBeli	= $myData['harga_beli'];
	$kodeBarang		= $myData['kd_barang'];
	$kwitansi		= $myData['foto'];
	$fotoBast		= $myData['foto_form'];

	$query	= "SELECT pengadaan_item.*, barang.nm_barang FROM pengadaan_item LEFT JOIN barang ON pengadaan_item.kd_barang = barang.kd_barang WHERE pengadaan_item.no_pengadaan='$Kode'";
	$myQry = mysql_query($query, $koneksidb) or die("Query ambil data salah : " . mysql_error());
	while ($data = mysql_fetch_array($myQry)) {
		$barang 		= mysql_real_escape_string($data['kd_barang']);
		$harga  		= intval($data['harga_beli']);  // Pastikan nilai numerik
		$jumlah			= intval($data['jumlah']);
		$supplier 		= $data['kd_supplier'];
		$noPengadaan 	= $data['no_pengadaan'];

		# Cek apakah data sudah ada di tmp_pengadaan
		$cekSql = "SELECT COUNT(*) as count FROM tmp_pengadaan WHERE kd_petugas='$userLogin' AND kd_barang='$barang' AND harga_beli='$harga' AND jumlah='$jumlah' AND kd_supplier='$supplier'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal cek data : " . mysql_error());
		$cekData = mysql_fetch_array($cekQry);

		if ($cekData['count'] == 0) {  // Jika data tidak ada, maka tambahkan
			$sql = "INSERT INTO tmp_pengadaan (kd_petugas, no_pengadaan, kd_barang, harga_beli, jumlah, kd_supplier) VALUES ('$userLogin', '$noPengadaan', '$barang', '$harga', '$jumlah', '$supplier')";
			mysql_query($sql, $koneksidb) or die("Gagal query: " . mysql_error());
		}
	}
	// =========================================================================

	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
	$dataBarang		= isset($_POST['cmbBarang']) ? $_POST['cmbBarang'] : '';

	# TOMBOL TAMBAH DIKLIK
	if (isset($_POST['btnTambah'])) {
		# Baca variabel Input Barang
		$cmbBarang		= $_POST['cmbBarang'];
		$txtHargaBeli	= isset($_POST['txtHargaBeli']) ? $_POST['txtHargaBeli'] : '';
		$txtJumlah		= $_POST['txtJumlah'];
		$cmbSupplier	= $_POST['cmbSupplier'];

		// Validasi form
		$pesanError = array();
		if (trim($cmbBarang) == "Kosong") {
			$pesanError[] = "Data <b>Type Barang belum diisi</b>, pilih pada combo !";
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
			# Jika jumlah error pesanError tidak ada, skrip di bawah dijalankan
			// Data yang ditemukan dimasukkan ke keranjang transaksi
			$tmpSql 	= "INSERT INTO tmp_pengadaan (no_pengadaan, kd_barang, harga_beli, jumlah, kd_petugas, kd_supplier) VALUES ('$Kode', '$cmbBarang', '$txtHargaBeli', '$txtJumlah','$userLogin', '$cmbSupplier')";
			mysql_query($tmpSql, $koneksidb) or die("Gagal Query tmp : " . mysql_error());

			// kosongkan variabel Input Barang
			$dataBarang		= "";
			$dataHargaBeli	= "";
			$dataJumlah		= "";
		}
	} else {
		// kosongkan variabel Input Barang
		$dataBarang		= "";
		$dataHargaBeli	= "";
		$dataJumlah		= "";
	}

	# ========================================================================================================
	# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
	if (isset($_POST['btnSimpan'])) {
		# Baca variabel

		$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
		$cmbJenis		= $_POST['cmbJenis'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$txtNomorResi	= $_POST['txtNomorResi'];
		$cmbDepartemen	= $_POST['cmbDepartemen'];
		$cmbLokasi		= $_POST['cmbLokasi'];
		$errors 		= [];
		$uploaded_files = [];
		$uploaded_files1 = [];
		$desired_dir = "user_data";

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
		// Gabungkan data file lama dengan file baru
		$all_files = array_filter(array_merge(explode(';', $kwitansi), $uploaded_files));

		// Simpan data file gabungan kembali ke database
		$fileName = implode(';', $all_files);

		foreach ($_FILES['files1']['tmp_name'] as $key1 => $tmp_name1) {
			$file_name1  = $_FILES['files1']['name'][$key1];
			$file_size1 = $_FILES['files1']['size'][$key1];
			$file_tmp1 = $_FILES['files1']['tmp_name'][$key1];
			$file_type1 = $_FILES['files1']['type'][$key1];
			if ($file_size1 > 9097152) {
				$errors[] = 'File size must be less than 2 MB';
			}

			if (empty($errors) == true) {
				$namaFileBaru1	= uniqid();
				$namaFileBaru1 .= '-';
				$namaFileBaru1 .= $file_name;
				if (move_uploaded_file($file_tmp1, "$desired_dir/$namaFileBaru1")) {
					$uploaded_files1[] = $namaFileBaru1; // Simpan nama file yang berhasil diunggah
				}
			} else {
				print_r($errors);
			}
		}
		// Gabungkan data file lama dengan file baru
		$all_files = array_filter(array_merge(explode(';', $fotoBast), $uploaded_files1));

		// Simpan data file gabungan kembali ke database
		$fileForm = implode(';', $all_files);

		// Validasi Form
		$pesanError = array();
		if (trim($txtTanggal) == "--") {
			$pesanError[] = "Data <b>Tgl. Pengadaan</b> belum diisi, pilih pada combo !";
		}

		# Validasi jika belum ada satupun data item yang dimasukkan
		$tmpSql = "SELECT COUNT(*) As qty FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
		$tmpData = mysql_fetch_array($tmpQry);
		if ($tmpData['qty'] < 1) {
			$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, Daftar item barang yang dibeli belum dimasukan ";
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
			foreach ($_POST['hargaBeli'] as $kdBarang => $harga) {
				$txtHarga = isset($_POST['hargaBeli'][$kdBarang]) ? $_POST['hargaBeli'][$kdBarang] : $tmpHargaBeli;

				// Lakukan update untuk setiap barangkdBarang
				$mySql = "UPDATE tmp_pengadaan SET harga_beli = '$txtHarga' WHERE no_pengadaan = '$Kode' AND kd_barang = '$kdBarang'";
				mysql_query($mySql, $koneksidb) or die("Gagal query: " . mysql_error());
			}
			# Jika jumlah error pesanError tidak ada
			$mySql	= "UPDATE pengadaan SET tgl_pengadaan = '$txtTanggal', keterangan = '$txtKeterangan', foto = '$fileName', foto_form = '$fileForm', jenis_pengadaan = '$cmbJenis', nomor_resi = '$txtNomorResi', kd_departemen = '$cmbDepartemen', kd_lokasi = '$cmbLokasi' WHERE no_pengadaan = '$Kode'";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				# Ambil semua data barang/barang yang dipilih, berdasarkan petugas yg login
				$tmpSql = "SELECT * FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp : " . mysql_error());
				while ($tmpData = mysql_fetch_array($tmpQry)) {
					$dataPengadaan  = $tmpData['no_pengadaan'];
					$dataKode 		= $tmpData['kd_barang'];
					$dataHarga 		= $tmpData['harga_beli'];
					$dataJumlah		= $tmpData['jumlah'];
					$supplier		= $tmpData['kd_supplier'];

					$query 	= "SELECT * FROM pengadaan_item WHERE no_pengadaan = '$dataPengadaan' AND kd_barang = '$dataKode'";
					$checkQry = mysql_query($query, $koneksidb) or die("Gagal Query Item : " . mysql_error());

					// Jika data tidak ada, maka lakukan INSERT
					if (mysql_num_rows($checkQry) == 0) {
						$dataSql = "INSERT INTO pengadaan_item (no_pengadaan, kd_barang, harga_beli, jumlah, kd_supplier) 
									VALUES ('$dataPengadaan', '$dataKode', '$dataHarga', '$dataJumlah', '$supplier')";
						mysql_query($dataSql, $koneksidb) or die("Gagal Query Item : " . mysql_error());
					} else {
						foreach ($_POST['hargaBeli'] as $kdBarang => $harga) {
							$txtHarga = $_POST['hargaBeli'][$kdBarang];
							$txtJumlah = $_POST['jumlahBarang'][$kdBarang];
							$txtVendor = $_POST['cmbVendor'][$kdBarang];

							$mySql = "UPDATE pengadaan_item SET harga_beli = '$txtHarga', jumlah = '$txtJumlah', kd_supplier = '$txtVendor' WHERE no_pengadaan = '$Kode' AND kd_barang = '$kdBarang'";
							mysql_query($mySql, $koneksidb) or die("Gagal query: " . mysql_error());
						}
					}
				}

				# Kosongkan Tmp jika datanya sudah dipindah
				$hapusSql = "DELETE FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
				mysql_query($hapusSql, $koneksidb) or die("Gagal kosongkan tmp " . mysql_error());

				// Refresh halaman
				echo "<script>alert('Data Pengadaan Berhasil Diperbarui')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Tampil'>";
			}
		}
	}

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Tampil'>";
	}
	?>

	<SCRIPT language="JavaScript">
		function submitform() {
			document.form1.submit();
		}
	</SCRIPT>
	<div class="table-border">
		<h2>TRANSAKSI PENGADAAN </h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
			<table width="900" cellspacing="1" class="table-list" style="margin-top:0px;">
				<tr>
					<td bgcolor="#F5F5F5"><strong>INPUT BARANG </strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Kategori</strong></td>
					<td><b>:</b></td>
					<td><select name="cmbKategori" onchange="javascript:submitform();" data-live-search="true" class="selectpicker">
							<option value="Kosong"> Pilih Kategori </option>
							<?php
							$daftarSql = "SELECT * FROM kategori  ORDER BY kd_kategori";
							$daftarQry = mysql_query($daftarSql, $koneksidb) or die("Gagal Query" . mysql_error());
							while ($daftarData = mysql_fetch_array($daftarQry)) {
								if ($daftarData['kd_kategori'] == $dataKategori) {
									$cek = " selected";
								} else {
									$cek = "";
								}
								echo "<option value='$daftarData[kd_kategori]' $cek> $daftarData[nm_kategori]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td><strong>Type</strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<select name="cmbBarang" data-live-search="true" class="selectpicker">
								<option value="Kosong"> Pilih Barang </option>
								<?php
								$mySql = "SELECT * FROM barang WHERE kd_kategori='$dataKategori' ORDER BY nm_barang ASC";
								$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
								while ($myData = mysql_fetch_array($myQry)) {
									if ($dataBarang == $myData['kd_barang']) {
										$cek = " selected";
									} else {
										$cek = "";
									}
									echo "<option value='$myData[kd_barang]' $cek> [ $myData[kd_barang] ] $myData[nm_barang]</option>";
								}
								?>
							</select>
						</b><a href="?page=Pencarian-Barang" target="_blank"></a>
					</td>
				</tr>
				<tr>
					<td><strong>Supplier (Asal Barang) </strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<select name="cmbSupplier" data-live-search="true" class="selectpicker">
								<option value="Kosong"> Pilih Supplier </option>
								<?php
								$mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
								$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
								while ($myData = mysql_fetch_array($myQry)) {
									if ($dataSupplier == $myData['kd_supplier']) {
										$cek = " selected";
									} else {
										$cek = "";
									}
									echo "<option value='$myData[kd_supplier]' $cek>$myData[nm_supplier]</option>";
								}
								?>
							</select>
						</b>
					</td>
				</tr>
				<tr>
					<td><strong>Harga Barang/Beli (Rp.) </strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<input type="text" id="harga" name="txtHargaBeli" size="25" maxlength="12" autocomplete="off" />
							Jumlah :
							<input class="angkaC" name="txtJumlah" size="3" maxlength="4" value="1" onblur="if (value == '') {value = '1'}" onfocus="if (value == '1') {value =''}" />
							<input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
						</b></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><i><strong>Note : </strong>Klik Tambah agar data barang bertambah di <strong>DAFTAR BARANG</strong></i></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor="#F5F5F5"><strong>DATA TRANSAKSI </strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="15%"><strong>No. Pengadaan </strong></td>
					<td width="1%"><strong>:</strong></td>
					<td width="75%"><input name="txtNomor" value="<?php echo $noPengadaan; ?>" size="25" maxlength="20" readonly="readonly" /></td>
				</tr>
				<tr>
					<td><strong>Tanggal Pengadaan </strong></td>
					<td><strong>:</strong></td>
					<td><input type="text" name="txtTanggal" id="date" class="tcal" value="<?php echo IndonesiaTgl($tglTransaksi); ?>" size="25" maxlength="20" /></td>
				</tr>
				<tr>
					<td><strong>Jenis Pengadaan </strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<select name="cmbJenis" data-live-search="true" class="selectpicker">
								<option value="Kosong"> Pilih Jenis Pembayaran </option>
								<?php
								include_once "library/inc.pilihan.php";
								foreach ($jenisPengadaan as $nilai) {
									if ($dataJenis == $nilai) {
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
					<td><strong>Keterangan</strong></td>
					<td><strong>:</strong></td>
					<td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="25" maxlength="100" autocomplete="off" /></td>
				</tr>
				<tr>
					<td><strong>Departemen </strong></td>
					<td><strong>:</strong></td>
					<td>
						<select name="cmbDepartemen" onchange="javascript:submitform();" data-live-search="true" class="selectpicker">
							<option value="">Semua</option>
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
					</td>
				</tr>
				<tr>
					<td><strong>Lokasi Penempatan </strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<select name="cmbLokasi" data-live-search="true" class="selectpicker">
								<option value=""> Pilih Lokasi </option>
								<?php
								// Menampilkan data Lokasi dengan filter Nama Departemen yang dipilih
								$comboSql = "SELECT * FROM lokasi WHERE kd_departemen='$dataDepartemen' ORDER BY kd_lokasi";
								$comboQry = mysql_query($comboSql, $koneksidb) or die("Gagal Query" . mysql_error());
								while ($comboData = mysql_fetch_array($comboQry)) {
									if ($dataLokasi == $comboData['kd_lokasi']) {
										$cek = " selected";
									} else {
										$cek = "";
									}
									echo "<option value='$comboData[kd_lokasi]' $cek> $comboData[nm_lokasi]</option>";
								}
								?>
							</select>
						</b></td>
				</tr>
				<tr>
					<td><strong>Nomor Resi</strong></td>
					<td><strong>:</strong></td>
					<td><input name="txtNomorResi" value="<?php echo $dataNomorResi; ?>" size="25" maxlength="100" autocomplete="off" /></td>
				</tr>
				<tr>
					<td><b>Kwitansi / Nota</b></td>
					<td><b>:</b></td>
					<td>
						<div style="display: flex; flex-wrap: wrap; gap: 10px;">
							<?php
							$ex = explode(';', $kwitansi); // Memisahkan nama file
							for ($i = 0; $i < count($ex); $i++) {
								if ($ex[$i] != '') {
									echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'>
                            			<img style='border: 1px solid #ddd; border-radius: 5px; padding: 5px;' width='150px' src='user_data/" . $ex[$i] . "'>
                          				</a>";
								}
							}
							?>
						</div>
						<input type="file" id="files" name="files[]" multiple>
					</td>
				</tr>
				<tr>
					<td><b>BAST Pengadaan Barang</b></td>
					<td><b>:</b></td>
					<td>
						<div style="display: flex; flex-wrap: wrap; gap: 10px;">
							<?php
							$ex = explode(';', $fotoBast); // Memisahkan nama file
							for ($i = 0; $i < count($ex); $i++) {
								if ($ex[$i] != '') {
									echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'>
                            			<img style='border: 1px solid #ddd; border-radius: 5px; padding: 5px;' width='150px' src='user_data/" . $ex[$i] . "'>
                          				</a>";
								}
							}
							?>
						</div>
						<input type="file" id="files1" name="files1[]" multiple>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>

			<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
				<tr>
					<th colspan="8">DAFTAR BARANG</th>
				</tr>
				<tr>
					<td width="20" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
					<td width="59" bgcolor="#CCCCCC"><strong>Kode </strong></td>
					<td width="257" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
					<td width="189" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
					<td width="115" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
					<td width="48" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
					<td width="125" align="right" bgcolor="#CCCCCC"><strong>Total Biaya (Rp)</strong></td>
					<td width="39" align="center" bgcolor="#CCCCCC">&nbsp;</td>
				</tr>
				<?php
				//  tabel menu 
				$tmpSql = "SELECT tmp_pengadaan.*, barang.nm_barang, supplier.kd_supplier FROM tmp_pengadaan
				LEFT JOIN barang ON tmp_pengadaan.kd_barang = barang.kd_barang
				LEFT JOIN supplier ON tmp_pengadaan.kd_supplier = supplier.kd_supplier
			    WHERE tmp_pengadaan.kd_petugas='$userLogin' AND tmp_pengadaan.no_pengadaan = '$Kode' ORDER BY id";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
				$nomor = 0;
				$subTotal = 0;
				$totalBelanja = 0;
				$qtyItem = 0;
				while ($tmpData = mysql_fetch_array($tmpQry)) {
					$ID				= $tmpData['id'];
					$qtyItem		= $qtyItem + $tmpData['jumlah'];
					$subTotal		= $tmpData['harga_beli'] * $tmpData['jumlah']; // Harga beli dari tabel tmp_pengadaan (harga terbaru yang diinput)
					$totalBelanja	= $totalBelanja + $subTotal;
					$nomor++;
					// gradasi warna
					if ($nomor % 2 == 1) {
						$warna = "";
					} else {
						$warna = "#F5F5F5";
					}
				?>
					<tr bgcolor="<?php echo $warna; ?>">
						<td align="center"><?php echo $nomor; ?></td>
						<td><?php echo $tmpData['kd_barang']; ?></td>
						<td><?php echo $tmpData['nm_barang']; ?></td>
						<td>
							<select name="cmbVendor[<?php echo $tmpData['kd_barang']; ?>]" data-live-search="true" class="selectpicker show-tick form-control">
								<option value=""> Pilih Vendor Service </option>
								<?php
								$mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
								$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
								while ($myData = mysql_fetch_array($myQry)) {
									if ($tmpData['kd_supplier'] == $myData['kd_supplier']) {
										$cek = " selected";
									} else {
										$cek = "";
									}
									echo "<option value='$myData[kd_supplier]' $cek>$myData[nm_supplier]</option>";
								}
								?>
							</select>
						</td>
						<td align="right" bgcolor="<?php echo $warna; ?>"><input type="text" name="hargaBeli[<?php echo $tmpData['kd_barang']; ?>]" size="10"
								<?php if ($tmpData['harga_beli'] == 0 || $tmpData['harga_beli'] == '') : ?>
								placeholder="0"
								<?php else : ?>
								value="<?php echo $tmpData['harga_beli']; ?>"
								<?php endif; ?>>
						</td>
						<td align="center" bgcolor="<?php echo $warna; ?>"><input type="text" name="jumlahBarang[<?php echo $tmpData['kd_barang']; ?>]" value="<?php echo $tmpData['jumlah']; ?>" size="3" autocomplete="off" /></td>
						<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo format_angka($subTotal); ?></td>
						<td align="center" bgcolor="#FFFFCC"><a href="index.php?open=Pengadaan-Edit&Kode=<?php echo $Kode ?>&Act=Delete&ID=<?php echo $ID; ?>" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA INI ... ?')" type="button" class="btn btn-danger btn-sm" target="_self"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
					</tr>
				<?php
				} ?>
				<tr>
					<td colspan="5" align="right" bgcolor="#CCCCCC"><b> GRAND TOTAL : </b></td>
					<td align="right" bgcolor="#CCCCCC"><strong><?php echo $qtyItem; ?></strong></td>
					<td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
					<td align="center" bgcolor="#CCCCCC">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="8">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="4" align="center">
						<button type="submit" name="btnSimpan" class="btn btn-success">
							<span class="glyphicon glyphicon-floppy-save" aria-hidden="true">&nbsp;</span><b>UBAH</b>
						</button>
						<button type="submit" name="btnKembali" class="btn btn-danger">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true">&nbsp;</span><b>KEMBALI</b>
						</button>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>
	</div>