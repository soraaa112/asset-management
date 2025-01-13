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
			<div class="row">
				<div class="form-group">
					<label id="tag" class="col-lg-12 control-label" style="border-radius: 5px; margin-bottom: 12px;">
						<ins><span class="glyphicon glyphicon-briefcase">&nbsp;</span> INPUT BARANG </ins></label>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="cmbKategori" class="col-lg-2 control-label">Kategori</label>
					<div class="col-lg-4" style="display: block; margin-bottom: 10px;">
						<select name="cmbKategori" onchange="javascript:submitform();" data-live-search="true" class="selectpicker form-control" id="cmbKategori" autocomplete="off">
							<option value=""> Pilih Kategori </option>
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
					</div>
					<div class="row">
						<div class="form-group">
							<label for="cmbBarang" class="col-lg-2 control-label">Type</label>
							<div class="col-lg-4" style="display: block; margin-bottom: 10px;">
								<select name="cmbBarang" data-live-search="true" class="selectpicker form-control" autocomplete="off">
									<option value=""> Pilih Barang </option>
									<?php
									$daftarSql = "SELECT * FROM barang WHERE kd_kategori='$dataKategori' ORDER BY nm_barang ASC";
									$daftarQry = mysql_query($daftarSql, $koneksidb) or die("Gagal Query" . mysql_error());
									while ($daftarData = mysql_fetch_array($daftarQry)) {
										if ($dataBarang == $daftarData['kd_barang']) {
											$cek = " selected";
										} else {
											$cek = "";
										}
										echo "<option value='$daftarData[kd_barang]' $cek> [ $daftarData[kd_barang] ] $daftarData[nm_barang]</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<label for="cmbSupplier" class="col-lg-2 control-label"> Supplier (Asal Barang) </label>
					<div class="col-lg-4" style="display: block; margin-bottom: 10px;">
						<select name="cmbSupplier" type="text" data-live-search="true" class="selectpicker form-control" autocomplete="off">
							<option value=""> Pilih Supplier </option>
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
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="txtHargaBeli" class="col-lg-2 control-label">Harga Barang/ Beli (Rp.)</label>
					<div class="col-lg-4" style="border-radius: 5px; margin-bottom: 20px;">
						<input type="text" id="harga" name="txtHargaBeli" autocomplete="off" style="margin-bottom: 5px;">
						Jumlah :
						<input class="angkaC" name="txtJumlah" size="3" maxlength="4" value="1" onblur="if (value == '') {value = '1'}" onfocus="if (value == '1') {value =''}" />
						<button type="submit" name="btnTambah" class="btn btn-primary btn-sm">
							<span class="glyphicon glyphicon-plus" aria-hidden="true">&nbsp;</span><b>TAMBAH</b>
						</button>
						<td><i><strong>Note : </strong>Klik Tambah agar data barang bertambah di <strong>DAFTAR BARANG</strong></i></td>
					</div>
				</div>
				<div class="form-group">
					<label id="tag" class="col-lg-12 control-label" style="border-radius: 5px; margin-bottom: 20px;">
						<ins><span class="glyphicon glyphicon-wrench">&nbsp;</span> DATA TRANSAKSI </ins></label>
				</div>
				<div class="form-group">
					<label for="txtNomor" class="col-lg-2 control-label">No. Pengadaan</label>
					<div class="col-lg-4">
						<input class="form-control" name="txtNomor" id="txtNomor" value="<?php echo $noTransaksi; ?>" readonly autocomplete="off" style="display: block; margin-bottom: 12px;">
					</div>
					<div class="form-group">
						<label for="date" class="col-lg-2 control-label">Tanggal Pengadaan</label>
						<div class="col-lg-4">
							<input id="date" class="form-control" name="txtTanggal" placeholder="dd-mm-yyyy" value="<?php echo $tglTransaksi; ?>" autocomplete="off" style="display: block; margin-bottom: 12px;">
						</div>
						<div class="form-group">
							<label for="cmbDepartemen" class="col-lg-2 control-label">Departemen</label>
							<div class="col-lg-4" style="display: block; margin-bottom: 12px;">
								<select name="cmbDepartemen" onchange="javascript:submitform();" data-live-search="true" class="selectpicker show-tick form-control" autocomplete="off">
									<option value="">Pilih Departemen</option>
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
							<div class="form-group">
								<label for="cmbLokasi" class="col-lg-2 control-label">Lokasi Penempatan</label>
								<div class="col-lg-4" style="display: block; margin-bottom: 12px;">
									<select name="cmbLokasi" data-live-search="true" class="selectpicker show-tick form-control" autocomplete="off">
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
								</div>
								<div class="form-group">
									<label for="cmbJenis" class="col-lg-2 control-label">Jenis Pengadaan</label>
									<div class="col-lg-4" style="display: block; margin-bottom: 12px;">
										<select name="cmbJenis" data-live-search="true" class="selectpicker show-tick form-control" autocomplete="off">
											<option value=""> Pilih Jenis Pembayaran </option>
											<?php
											include_once "library/inc.pilihan.php";
											foreach ($jenisPengadaan as $nilai) {
												echo "<option value='$nilai'>$nilai</option>";
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="txtKeterangan" class="col-lg-2 control-label">Keterangan</label>
										<div class="col-lg-4">
											<input class="form-control" name="txtKeterangan" id="txtKeterangan" value="<?php echo $dataKeterangan; ?>" autocomplete="off" style="display: block; margin-bottom: 12px;">
										</div>
										<div class="form-group">
											<label for="file" class="col-lg-2 control-label">Kwitansi / Nota</label>
											<div class="col-lg-4">
												<input type="file" class="form-control" name="files[]" autocomplete="off" style="display: block; margin-bottom: 10px;">
											</div>
											<div class="form-group">
												<label for="txtNomorResi" class="col-lg-2 control-label">Nomor Resi</label>
												<div class="col-lg-4">
													<input class="form-control" name="txtNomorResi" id="txtNomorResi" value="<?php echo $dataNomorResi; ?>" autocomplete="off" style="display: block; margin-bottom: 12px;">
												</div>
												<?php if (isset($_SESSION["SES_PETUGAS"])) { ?>
													<div class="form-group">
														<label for="file" class="col-lg-2 control-label">BAST</label>
														<div class="col-lg-4" style="border-radius: 5px; margin-bottom: 20px;">
															<input type="file" class="form-control" name="files1[]" autocomplete="off" style="display: block; margin-bottom: 10px;">
														<?php } ?>
														</div>
													</div>

		</form>
	</div>

	<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<th id="tag" colspan="8">DAFTAR BARANG</ins></th>
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
			<td colspan="6" align="center">
				<button type="submit" name="btnSimpan" class="btn btn-success">
					<span class="glyphicon glyphicon-floppy-save" aria-hidden="true">&nbsp;</span><b>SIMPAN</b>
				</button>
				<button type="submit" name="btnKembali" class="btn btn-danger">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true">&nbsp;</span><b>KEMBALI</b>
				</button>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	</form>
	</div>