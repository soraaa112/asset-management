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
			$mySql = "DELETE FROM tmp_pengadaan WHERE id='$ID' AND kd_petugas='$userLogin'";
			mysql_query($mySql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());
		}
		if (trim($Act) == "Success") {
			echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
		}
	}
	// =========================================================================

	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
	$dataBarang		= isset($_POST['cmbBarang']) ? $_POST['cmbBarang'] : '';
	$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
	$dataLokasi		= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : '';

	# TOMBOL TAMBAH DIKLIK
	if (isset($_POST['btnTambah'])) {
		# Baca variabel Input Barang
		$cmbBarang		= $_POST['cmbBarang'];
		$txtHargaBeli	= $_POST['txtHargaBeli'];
		$txtHargaBeli	= str_replace("'", "&acute;", $txtHargaBeli);
		$txtHargaBeli	= str_replace(".", "", $txtHargaBeli);

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
			$tmpSql 	= "INSERT INTO tmp_pengadaan (kd_barang, kd_supplier, harga_beli, jumlah, kd_petugas) VALUES ('$cmbBarang', '$cmbSupplier', '$txtHargaBeli', '$txtJumlah','$userLogin')";
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
	// ============================================================================

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

		// Menyimpan nama-nama file yang berhasil diunggah
		$fileName = !empty($uploaded_files) ? implode(';', $uploaded_files) : '';

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

		// Menyimpan nama-nama file yang berhasil diunggah
		$fileForm = !empty($uploaded_files1) ? implode(';', $uploaded_files1) : '';

		// Validasi Form
		$pesanError = array();
		if (trim($txtTanggal) == "--") {
			$pesanError[] = "Data <b>Tgl. Pengadaan</b> belum diisi, pilih pada combo !";
		}
		if (trim($cmbJenis) == "Kosong") {
			$pesanError[] = "Data <b> Nama Jenis</b> belum dipilih, silahkan pilih pada combo !";
		}

		# Validasi jika belum ada satupun data item yang dimasukkan
		$tmpSql = "SELECT COUNT(*) As qty FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
		$tmpData = mysql_fetch_array($tmpQry);
		if ($tmpData['qty'] < 1) {
			$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, Daftar item barang yang dibeli belum dimasukan ";
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
			# Jika jumlah error pesanError tidak ada
			$kodeBaru = buatKode7($koneksidb, "pengadaan", "BB");
			$mySql	= "INSERT INTO pengadaan (no_pengadaan, tgl_pengadaan, keterangan, jenis_pengadaan, kd_petugas, foto, foto_form, nomor_resi, kd_departemen, kd_lokasi, status) 
			VALUES ('$kodeBaru', '$txtTanggal', '$txtKeterangan', '$cmbJenis', '$userLogin', '$fileName', '$fileForm', '$txtNomorResi', '$cmbDepartemen', '$cmbLokasi', 'Purchase Request')";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				# Ambil semua data barang/barang yang dipilih, berdasarkan petugas yg login
				$tmpSql = "SELECT * FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp : " . mysql_error());
				while ($tmpData = mysql_fetch_array($tmpQry)) {
					$dataKode 		= $tmpData['kd_barang'];
					$dataHarga 		= $tmpData['harga_beli'];
					$dataJumlah		= $tmpData['jumlah'];
					$supplier		= $tmpData['kd_supplier'];

					// Masukkan semua barang/barang dari TMP ke tabel pengadaan detail
					$itemSql	= "INSERT INTO pengadaan_item (no_pengadaan, kd_barang, harga_beli, jumlah, kd_supplier) 
					VALUES ('$kodeBaru', '$dataKode', '$dataHarga', '$dataJumlah', '$supplier')";
					mysql_query($itemSql, $koneksidb) or die("Gagal Query Item : " . mysql_error());

					$mySql = "UPDATE pengadaan SET status_approval='Belum Approve' WHERE no_pengadaan='$kodeBaru'";
					mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status" . mysql_error());
				}

				# Kosongkan Tmp jika datanya sudah dipindah
				$hapusSql = "DELETE FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
				mysql_query($hapusSql, $koneksidb) or die("Gagal kosongkan tmp " . mysql_error());

				// Refresh halaman
				echo "<script>alert('Data Pengadaan Berhasil Ditambah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Tampil'>";
			}
		}
	}

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Tampil'>";
	}

	# TAMPILKAN DATA KE FORM
	$noTransaksi 	= buatKode7($koneksidb, "pengadaan", "BB");
	$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
	$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
	$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataNomorResi	= isset($_POST['txtNomorResi']) ? $_POST['txtNomorResi'] : '';
	$files	= isset($_POST['files']) ? $_POST['files'] : '';
	$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
	$dataLokasi		= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : '';
	if (isset($_SESSION["SES_OPERATOR"])) {
		$files1	= isset($_POST['files1']) ? $_POST['files1'] : '';
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
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Kategori</strong></td>
					<td><b>:</b></td>
					<td colspan="6"><select name="cmbKategori" onchange="javascript:submitform();" data-live-search="true" class="selectpicker">
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
					<td colspan="6"><b>
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
						</b><a href="?page=Pencarian-Barang" target="_blank"></a></td>
				</tr>
				<tr>
					<td><strong>Supplier (Asal Barang) </strong></td>
					<td><strong>:</strong></td>
					<td colspan="6"><b>
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
					<td><strong>Harga Barang/ Beli (Rp.) </strong></td>
					<td><strong>:</strong></td>
					<td colspan="6"><b>
							<input type="text" id="harga" name="txtHargaBeli" size="24" maxlength="12" autocomplete="off" />
							Jumlah :
							<input class="angkaC" name="txtJumlah" size="3" maxlength="4" value="1" onblur="if (value == '') {value = '1'}" onfocus="if (value == '1') {value =''}" />
							<input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
						</b></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="6"><i><strong>Note : </strong>Klik Tambah agar data barang bertambah di <strong>DAFTAR BARANG</strong></i></td>
				</tr>
				<tr>
					<td colspan="8">&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor="#F5F5F5"><strong>DATA TRANSAKSI </strong></td>
					<td colspan="7">&nbsp;</td>
				</tr>
				<tr>
					<td width="15%"><strong>No. Pengadaan </strong></td>
					<td width="1%"><strong>:</strong></td>
					<td width="75%" colspan="6"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="26" maxlength="20" readonly="readonly" /></td>
				</tr>
				<tr>
					<td><strong>Tanggal Pengadaan </strong></td>
					<td><strong>:</strong></td>
					<td colspan="6"><input type="text" name="txtTanggal" id="date" class="tcal" value="<?php echo $tglTransaksi; ?>" size="26" maxlength="20" /></td>
				</tr>
				<tr>
					<td><strong>Departemen </strong></td>
					<td><strong>:</strong></td>
					<td colspan="6">
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
					<td colspan="6"><b>
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
					<td><strong>Jenis Pengadaan </strong></td>
					<td><strong>:</strong></td>
					<td colspan="6"><b>
							<select name="cmbJenis" data-live-search="true" class="selectpicker">
								<option value="Kosong"> Pilih Jenis Pembayaran </option>
								<?php
								include_once "library/inc.pilihan.php";
								foreach ($jenisPengadaan as $nilai) {
									echo "<option value='$nilai'>$nilai</option>";
								}
								?>
							</select>
						</b></td>
				</tr>
				<tr>
					<td><strong>Keterangan</strong></td>
					<td><strong>:</strong></td>
					<td colspan="6"><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="26" maxlength="100" autocomplete="off" /></td>
				</tr>
				<tr>
					<td><strong>Nomor Resi</strong></td>
					<td><strong>:</strong></td>
					<td colspan="6"><input name="txtNomorResi" value="<?php echo $dataNomorResi; ?>" size="26" maxlength="100" autocomplete="off" /></td>
				</tr>
				<tr>
					<td><b>Kwitansi / Nota</b></td>
					<td><b>:</b></td>
					<td colspan="6"><input type='file' name="files[]" multiple /></td>
				</tr>
				<?php if (isset($_SESSION["SES_PETUGAS"])) { ?>
					<tr>
						<td><b>BAST Pengadaan Barang</b></td>
						<td><b>:</b></td>
						<td colspan="6"><input type='file' name="files1[]" multiple /></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="8">&nbsp;</td>
				</tr>
			</table>

			<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
				<tr>
					<th colspan="8">DAFTAR BARANG</th>
				</tr>
				<tr>
					<td width="27" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
					<td width="59" bgcolor="#CCCCCC"><strong>Kode </strong></td>
					<td width="257" bgcolor="#CCCCCC"><strong>Type Barang </strong></td>
					<td width="189" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
					<td width="115" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
					<td width="48" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
					<td width="125" align="right" bgcolor="#CCCCCC"><strong>Total Biaya (Rp)</strong></td>
					<td width="39" align="center" bgcolor="#CCCCCC">&nbsp;</td>
				</tr>
				<?php
				//  tabel menu 
				$tmpSql = "SELECT tmp_pengadaan.*, barang.nm_barang, supplier.nm_supplier FROM tmp_pengadaan
				LEFT JOIN barang ON tmp_pengadaan.kd_barang = barang.kd_barang
				LEFT JOIN supplier ON tmp_pengadaan.kd_supplier = supplier.kd_supplier
				WHERE tmp_pengadaan.kd_petugas='$userLogin' ORDER BY id";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
				$nomor = 0;
				$subTotal = 0;
				$totalBelanja = 0;
				$qtyItem = 0;
				while ($tmpData = mysql_fetch_array($tmpQry)) {
					$ID			= $tmpData['id'];
					$qtyItem	= $qtyItem + $tmpData['jumlah'];
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
						<td><?php echo $tmpData['nm_supplier']; ?></td>
						<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo format_angka($tmpData['harga_beli']); ?></td>
						<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $tmpData['jumlah']; ?></td>
						<td align="right" bgcolor="<?php echo $warna; ?>"><?php echo format_angka($subTotal); ?></td>
						<td align="center" bgcolor="#FFFFCC"><a href="index.php?open=Pengadaan-Baru&Act=Delete&ID=<?php echo $ID; ?>" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA INI ... ?')" type="button" class="btn btn-danger btn-sm" target="_self"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
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
							<span class="glyphicon glyphicon-floppy-save" aria-hidden="true">&nbsp;</span><b>SIMPAN</b>
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