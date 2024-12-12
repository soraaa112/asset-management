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
	$Kode	= $_GET['Kode'];
	$mySql	= "SELECT pengadaan.*, pengadaan_item.kd_barang, pengadaan_item.harga_beli, pengadaan_item.jumlah, petugas.nm_petugas, departemen.*, lokasi.* FROM pengadaan
    LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan = pengadaan_item.no_pengadaan
	LEFT JOIN departemen ON pengadaan.kd_departemen = departemen.kd_departemen
	LEFT JOIN lokasi ON pengadaan.kd_lokasi = lokasi.kd_lokasi
	LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
	WHERE pengadaan.no_pengadaan='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die("Query ambil data salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	$noPengadaan 	= $myData['no_pengadaan'];
	$tglTransaksi 	= $myData['tgl_pengadaan'];
	$dataBarang     = $myData['kd_barang'];
	$dataDepartemen	= $myData['kd_departemen'];
	$dataLokasi		= $myData['kd_lokasi'];
	$dataJenis		= $myData['jenis_pengadaan'];
	$dataKeterangan	= $myData['keterangan'];
	$dataNomorResi	= $myData['nomor_resi'];
	$dataHarga      = $myData['harga_beli'];
	$dataJumlah     = $myData['jumlah'];
	$kwitansi		= $myData['foto'];
	$fotoBast		= $myData['foto_form'];

	# ========================================================================================================
	# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
	if (isset($_POST['btnSimpan'])) {
		foreach ($_POST['txtSn'] as $kdBarang => $harga) {
			$txtSn = $_POST['txtSn'][$kdBarang];

			// Lakukan update untuk setiap barang
			$mySql = "UPDATE barang_inventaris SET serial_number = '$txtSn' WHERE no_pengadaan = '$Kode' AND kd_inventaris = '$kdBarang'";
			mysql_query($mySql, $koneksidb) or die("Gagal query: " . mysql_error());
		}

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

		$mySql	= "UPDATE pengadaan SET foto = '$fileName', foto_form = '$fileForm' WHERE no_pengadaan = '$Kode'";
		mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());

		// Refresh halaman
		echo "<script>alert('Data Pengadaan Berhasil Diperbarui')</script>";
		echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Tampil'>";
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
					<td bgcolor="#F5F5F5"><strong>DATA TRANSAKSI </strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="15%"><strong>No. Pengadaan </strong></td>
					<td width="1%"><strong>:</strong></td>
					<td width="75%"><input name="txtNomor" value="<?php echo $noPengadaan; ?>" size="26" maxlength="20" readonly="readonly" /></td>
				</tr>
				<tr>
					<td><strong>Tanggal Pengadaan </strong></td>
					<td><strong>:</strong></td>
					<td><input name="txtTanggal" class="tcal" value="<?php echo IndonesiaTgl($tglTransaksi); ?>" size="26" maxlength="20" readonly /></td>
				</tr>
				<tr>
					<td><strong>Jenis Pengadaan </strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<select name="cmbJenis" data-live-search="true" class="selectpicker">
								<option value="Kosong"><?php echo $dataJenis ?></option>
							</select>
						</b></td>
				</tr>
				<tr>
					<td><strong>Keterangan</strong></td>
					<td><strong>:</strong></td>
					<td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="26" maxlength="100" autocomplete="off" readonly /></td>
				</tr>
				<tr>
					<td><strong>Departemen </strong></td>
					<td><strong>:</strong></td>
					<td>
						<select name="cmbDepartemen" onchange="javascript:submitform();" data-live-search="true" class="selectpicker">
							<?php
							$mySql = "SELECT * FROM departemen WHERE kd_departemen = '$dataDepartemen' ORDER BY kd_departemen";
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
								<?php
								// Menampilkan data Lokasi dengan filter Nama Departemen yang dipilih
								$comboSql = "SELECT * FROM lokasi WHERE kd_departemen='$dataDepartemen' AND kd_lokasi = '$dataLokasi' ORDER BY kd_lokasi";
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
					<td><input name="txtNomorResi" value="<?php echo $dataNomorResi; ?>" size="26" maxlength="100" autocomplete="off" readonly /></td>
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
                            			<img style='border: 1px solid #ddd; border-radius: 5px; padding: 5px;' width='100px' src='user_data/" . $ex[$i] . "'>
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
                            			<img style='border: 1px solid #ddd; border-radius: 5px; padding: 5px;' width='100px' src='user_data/" . $ex[$i] . "'>
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
					<th colspan="5">DAFTAR BARANG</th>
				</tr>
				<tr>
					<td width="27" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
					<td width="100" bgcolor="#CCCCCC"><strong>Kode </strong></td>
					<td width="270" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
					<td width="160" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
					<td width="115" bgcolor="#CCCCCC"><strong>Serial Number </strong></td>
				</tr>
				<?php
				//  tabel menu 
				$tmpSql = "WITH Inventaris_CTE AS (
							SELECT barang_inventaris.no_pengadaan,
								barang_inventaris.kd_barang,
								barang_inventaris.kd_inventaris,
								barang_inventaris.serial_number,
								ROW_NUMBER() OVER(PARTITION BY barang_inventaris.no_pengadaan, barang_inventaris.kd_barang 
								ORDER BY barang_inventaris.kd_inventaris) AS row_num
							FROM barang_inventaris
							WHERE barang_inventaris.no_pengadaan = '$Kode'
						)
						SELECT pengadaan_item.no_pengadaan,
							pengadaan_item.kd_barang,
							pengadaan_item.kd_supplier,
							pengadaan_item.harga_beli,
							pengadaan_item.jumlah,
							Inventaris_CTE.kd_inventaris,
							Inventaris_CTE.serial_number,
							barang.nm_barang,
							supplier.nm_supplier
						FROM pengadaan_item
						LEFT JOIN Inventaris_CTE ON pengadaan_item.no_pengadaan = Inventaris_CTE.no_pengadaan 
						AND pengadaan_item.kd_barang = Inventaris_CTE.kd_barang
						AND Inventaris_CTE.row_num <= pengadaan_item.jumlah
						LEFT JOIN barang ON pengadaan_item.kd_barang = barang.kd_barang
						LEFT JOIN supplier ON pengadaan_item.kd_supplier = supplier.kd_supplier
						WHERE pengadaan_item.no_pengadaan = '$Kode'
						ORDER BY pengadaan_item.kd_barang, Inventaris_CTE.kd_inventaris";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query" . mysql_error());
				$nomor = 0;
				while ($tmpData = mysql_fetch_array($tmpQry)) {
					$nomor++;
					// gradasi warna
					if ($nomor % 2 == 1) {
						$warna = "";
					} else {
						$warna = "#F5F5F5";
					}
				?>
					<tr bgcolor="<?php echo $warna; ?>">
						<td align="center"><?php echo $nomor; ?>.</td>
						<td><?php echo $tmpData['kd_inventaris']; ?></td>
						<td><?php echo $tmpData['nm_barang']; ?></td>
						<td><?php echo $tmpData['nm_supplier']; ?></td>
						<td><input type="text" name="txtSn[<?php echo $tmpData['kd_inventaris']; ?>]" value="<?php echo $tmpData['serial_number'] ?? ''; ?>" /></td>
					</tr>
				<?php
				} ?>
				<tr>
					<td colspan="5">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3" align="center">
						<button type="submit" name="btnSimpan" class="btn btn-success">
							<span class="glyphicon glyphicon-floppy-save" aria-hidden="true">&nbsp;</span><b>UBAH</b>
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