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
			$mySql = "DELETE FROM tmp_peminjaman WHERE id='$ID' AND kd_petugas='$userLogin'";
			mysql_query($mySql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());
		}
		if (trim($Act) == "Sucsses") {
			echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
		}
	}
	// =========================================================================
	$dataDepartemen		= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
	$dataPegawai		= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : '';

	# TOMBOL TAMBAH (KODE BARANG) DIKLIK & SAAT ADA KODE INVENTARIS DIINPUT PADA KOTAK OLEH BARCODE ATAU COPY-PASTE-TAB
	if (isset($_POST['btnTambah'])) {
		// Baca variabel
		$txtKodeInventaris	= $_POST['txtKodeInventaris'];
		$txtKodeInventaris	= str_replace("'", "&acute;", $txtKodeInventaris);

		// Validasi form
		$pesanError = array();
		if (trim($txtKodeInventaris) == "") {
			$pesanError[] = "Data <b>Kode/ Label Barang</b> belum diisi, ketik secara manual atau dari <b>Barcode Reader atau Pencarian Barang</b> !";
		} else {
		# Periksa 1, apakah Kode Inventaris yang dimasukkan ada di dalam Database
		$cekSql	= "SELECT * FROM barang_inventaris WHERE kd_inventaris='$txtKodeInventaris' OR RIGHT(kd_inventaris,6) ='$txtKodeInventaris'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query" . mysql_error());
		if (mysql_num_rows($cekQry) < 1) {
			$pesanError[] = "Barang Kode/ Label <b>$txtKodeInventaris</b> tidak ditemukan dalam database!";
		} else {
			// Jika kode barang ditemukan di tabel barang_inventaris, maka periksa status-nya 
			$cekData = mysql_fetch_array($cekQry);
			if ($cekData['status_barang'] == "Ditempatkan") {
				$pesanError[] = "Barang dengan Kode <b>$txtKodeInventaris</b> tidak dapat dipinjam, karna <b> sudah ditempatkan/ dipakai</b>!";
			}
			if ($cekData['status_barang'] == "Dipinjam") {
				$pesanError[] = "Barang dengan Kode <b>$txtKodeInventaris</b> tidak dapat dipinjam, karna <b> sedang dipinjam</b>!";
			}
		}
		}

		# Periksa 2, apakah Kode Inventaris sudah diinput atau belum
		$cek2Sql = "SELECT * FROM tmp_peminjaman WHERE kd_inventaris='$txtKodeInventaris' OR RIGHT(kd_inventaris,6) ='$txtKodeInventaris'";
		$cek2Qry = mysql_query($cek2Sql, $koneksidb) or die("Gagal Query" . mysql_error());
		if (mysql_num_rows($cek2Qry) >= 1) {
			$pesanError[] = "Barang dengan Kode <b>$txtKodeInventaris</b> sudah di-Input, silahkan masukan data yang lain !";
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
			# Jika jumlah error pesanError tidak ada			
			// Masukkan data ke dalam tabel TMP (grid)
			$tmpSql 	= "INSERT INTO tmp_peminjaman (kd_inventaris, kd_petugas) VALUES ('$txtKodeInventaris', '$userLogin')";
			mysql_query($tmpSql, $koneksidb) or die("Gagal Query tmp : " . mysql_error());
		}
	}

	// ============================================================================

	# ========================================================================================================
	# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
	if (isset($_POST['btnSimpan'])) {
		// Baca variabel from
		$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
		$txtTglKembali 	= InggrisTgl($_POST['txtTglKembali']);
		$cmbPegawai		= $_POST['cmbPegawai'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$errors = array();
		foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
			$file_name = 'file' . $key . $_FILES['files']['name'][$key];
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

		if (implode('', $images) != '') {
			$fileName = implode(';', $images);
		} else {
			$fileName = '';
		}

		// Validasi form	
		$pesanError = array();
		if (trim($txtTanggal) == "--") {
			$pesanError[] = "Data <b>Tgl. Transaksi</b> belum diisi, pilih pada Kalender !";
		}
		if (trim($txtTglKembali) == "--") {
			$pesanError[] = "Data <b>Tanggal Kembali</b> belum diisi, pilih pada Kalender !";
		}
		if (trim($cmbPegawai) == "Kosong") {
			$pesanError[] = "Data <b>Pegawai</b> belum diisi, pilih pada combo !";
		}
		// if (trim($fileName) == "file" or trim($fileName) == "file0") {
		// 	$pesanError[] = "Data <b> Kwitansi / Nota</b> belum diupload/lampirkan!";
		// }

		# Periksa apakah sudah ada barang yang dimasukkan
		$cekSql = "SELECT * FROM tmp_peminjaman WHERE kd_petugas='$userLogin'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query cek Tmp 1" . mysql_error());
		if (mysql_num_rows($cekQry) < 1) {
			$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, Daftar item barang yang dipinjam belum dimasukan ";
		} else {
			// Tampilkan datanya, lalu cek Status-nya
			while ($cekData = mysql_fetch_array($cekQry)) {
				$kodeInv	= $cekData['kd_inventaris'];

				# VALIDASI JIKA MASIH ADA BARANG YANG SUDAH DITEMPATKAN/ DIPINJAM
				$cek2Sql	= "SELECT * FROM barang_inventaris WHERE kd_inventaris='$kodeInv'";
				$cek2Qry 	= mysql_query($cek2Sql, $koneksidb) or die("Gagal Query cek tmp 2 baca : " . mysql_error());
				if (mysql_num_rows($cek2Qry) >= 1) {
					$cek2Data	= mysql_fetch_array($cek2Qry);
					$kodeInv	= $cek2Data['kd_inventaris'];

					// membuat pesan
					if ($cek2Data['status_barang'] == "Ditempatkan") {
						$pesanError[] = "Kode <b>$kodeInv</b> statusnya masih <b>Ditempatkan</b>, silahkan ganti dengan yang lain ! ";
					}
					if ($cek2Data['status_barang'] == "Dipinjam") {
						$pesanError[] = "Kode <b>$kodeInv</b> statusnya masih <b>Dipinjam</b>, silahkan ganti dengan yang lain ! ";
					}
				}
			}
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
			# SIMPAN DATA KE DATABASE
			# Jika jumlah error pesanError tidak ada
			$kodeBaru = buatKode7($koneksidb, "peminjaman", "PJ");
			$mySql	= "INSERT INTO peminjaman (no_peminjaman, tgl_peminjaman, tgl_akan_kembali, kd_pegawai, keterangan, kd_petugas, form_bast) VALUES ('$kodeBaru', '$txtTanggal', '$txtTglKembali', '$cmbPegawai', '$txtKeterangan', '$userLogin', '$fileName')";
			$myQry = mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());

			if ($myQry) {
				# �LANJUTAN, SIMPAN DATA
				# Ambil semua data barang yang dipilih, berdasarkan Petugas yg login
				$tmpSql = "SELECT * FROM tmp_peminjaman WHERE kd_petugas='$userLogin'";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
				while ($tmpData = mysql_fetch_array($tmpQry)) {
					// Baca data dari tabel Inventaris Barang
					$kodeInventaris 	= $tmpData['kd_inventaris'];

					// Masukkan semua data di atas dari tabel TMP ke tabel ITEM
					$itemSql = "INSERT INTO peminjaman_item (no_peminjaman, kd_inventaris) VALUES ('$kodeBaru', '$kodeInventaris')";
					mysql_query($itemSql, $koneksidb) or die("Gagal Query " . mysql_error());

					// Skrip Update status barang : Dipinjam
					$mySql = "UPDATE barang_inventaris SET status_barang='Dipinjam' WHERE kd_inventaris='$kodeInventaris'";
					mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status" . mysql_error());
				}

				# Kosongkan Tmp jika datanya sudah dipindah
				$hapusSql = "DELETE FROM tmp_peminjaman WHERE kd_petugas='$userLogin'";
				mysql_query($hapusSql, $koneksidb) or die("Gagal kosongkan tmp" . mysql_error());

				// Refresh form
				echo "<meta http-equiv='refresh' content='0; url=?open=Peminjaman-Tampil'>";
			}
		}
	}

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Peminjaman-Tampil'>";
		
	}
	// ============================================================================

	# ========================================================================================================
	# TAMPILKAN DATA KE FORM
	$dataKode 			= buatKode7($koneksidb, "peminjaman", "PJ");
	$dataTglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
	$dataTglKembali 	= isset($_POST['txtTglKembali']) ? $_POST['txtTglKembali'] : date('d-m-Y');
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataPegawai 		= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : '';
	$files				= isset($_POST['files']) ? $_POST['files'] : '';
	?>

	<SCRIPT language="JavaScript">
		function submitform() {
			document.form1.submit();
		}
	</SCRIPT>
	<div class="table-border">
		<h2>TRANSAKSI PEMINJAMAN</h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
			<table width="900" cellpadding="3" cellspacing="1" class="table-list">
				<tr>
					<td bgcolor="#F5F5F5"><strong>INPUT BARANG </strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Kode/ Label Barang </strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<input name="txtKodeInventaris" id="txtKodeInventaris" size="20" maxlength="12" />
							<input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
						</b></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><strong>:</strong></td>
					<td><input name="txtNamaBrg" id="txtNamaBrg" size="20" maxlength="100" disabled="disabled" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>
						<a href="javaScript: void(0)" onclick="window.open('pencarian_barang.php')" target="_self"><strong>Pencarian Barang</strong></a>,<strong></strong> untuk membaca label barang
					</td>
				</tr>
				<tr>
					<td bgcolor="#F5F5F5"><strong>PEMINJAMAN</strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="15%"><strong>No. Peminjaman </strong></td>
					<td width="1%"><strong>:</strong></td>
					<td width="78%"><input name="txtNomor" value="<?php echo $dataKode; ?>" readonly="readonly" /></td>
				</tr>
				<tr>
					<td><strong>Tgl. Peminjaman </strong></td>
					<td><strong>:</strong></td>
					<td><input type="text" name="txtTanggal" id="date" class="tcal" value="<?php echo $dataTglTransaksi; ?>" /></td>
				</tr>
				<tr>
					<td><strong>Tgl. Akan Kembali </strong></td>
					<td><strong>:</strong></td>
					<td><input type="text" name="txtTglKembali" id="date2" class="tcal" value="<?php echo $dataTglKembali; ?>" /></td>
				</tr>
				<tr>
					<td><strong>Departemen</strong></td>
					<td><b>:</b></td>
					<td>
						<select name="cmbDepartemen" onchange="javascript:submitform();" data-live-search="true" class="selectpicker">
							<option value="Semua">Semua</option>
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
					<td><strong>Data Pegawai </strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<select name="cmbPegawai" data-live-search="true" class="selectpicker">
								<option value="Kosong"> Pilih Pegawai </option>
								<?php
								// Menampilkan data Lokasi dengan filter Nama Departemen yang dipilih
								$comboSql = "SELECT * FROM pegawai WHERE kd_departemen='$dataDepartemen' ORDER BY nm_pegawai ASC";
								$comboQry = mysql_query($comboSql, $koneksidb) or die("Gagal Query" . mysql_error());
								while ($comboData = mysql_fetch_array($comboQry)) {
									if ($dataLokasi == $comboData['kd_pegawai']) {
										$cek = " selected";
									} else {
										$cek = "";
									}
									echo "<option value='$comboData[kd_pegawai]' $cek> $comboData[nm_pegawai]</option>";
								}
								?>
							</select>
						</b>
					</td>
				</tr>
				<tr>
					<td><b>Form BAST</b></td>
					<td><b>:</b></td>
					<td><input type="file" name="files[]" multiple /></td>
				</tr>
				<tr>
					<td><strong>Keterangan</strong></td>
					<td><strong>:</strong></td>
					<td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="20" maxlength="100" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" Simpan Data " />
						<input name="btnKembali" type="submit" value=" Kembali " />
					</td>
				</tr>
			</table>

			<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
				<tr>
					<th colspan="6">DAFTAR BARANG </th>
				</tr>
				<tr>
					<td width="25" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
					<td width="92" bgcolor="#CCCCCC"><strong>Kode</strong></td>
					<td width="300" bgcolor="#CCCCCC"><strong>Type Barang </strong></td>
					<td width="150" bgcolor="#CCCCCC"><strong>Petugas Input</strong></td>
					<td width="150" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
					<td width="49" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
				</tr>
				<?php
				// Qury menampilkan data dalam Grid TMP_peminjaman 
				$tmpSql = "SELECT tmp.*, barang.*, petugas.nm_petugas, departemen.nm_departemen FROM tmp_peminjaman As tmp
			LEFT JOIN barang_inventaris ON tmp.kd_inventaris  = barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
			LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
			LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
			WHERE tmp.kd_petugas='$userLogin'
			ORDER BY barang.kd_barang ";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
				$nomor = 0;
				while ($tmpData = mysql_fetch_array($tmpQry)) {
					$nomor++;
					$ID			= $tmpData['id'];
				?>
					<tr>
						<td align="center"><?php echo $nomor; ?></td>
						<td><b><?php echo $tmpData['kd_inventaris']; ?></b></td>
						<td><?php echo $tmpData['nm_barang']; ?></td>
						<td><?php echo $tmpData['nm_petugas']; ?></td>
						<td><?php echo $tmpData['nm_departemen']; ?></td>
						<td align="center" bgcolor="#FFFFCC"><a href="index.php?open=Peminjaman-Baru&Act=Delete&ID=<?php echo $ID; ?>" target="_self">Delete</a></td>
					</tr>
				<?php } ?>
			</table>
		</form>
	</div>