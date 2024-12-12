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

	// =========================================================================
	# TAMPILKAN DATA KE FORM
	$Kode	 = $_GET['Kode'];
	$mySql = "SELECT mutasi_asal.*, mutasi_tujuan.no_penempatan, mutasi_tujuan.keterangan, mutasi.tgl_mutasi, mutasi.deskripsi, barang.nm_barang,
    lokasi.kd_lokasi, departemen.kd_departemen, penempatan.form_bast, penempatan_item.status_aktif
    from mutasi_tujuan
    LEFT JOIN mutasi_asal on mutasi_tujuan.no_mutasi=mutasi_asal.no_mutasi
    LEFT JOIN mutasi on mutasi_asal.no_mutasi=mutasi.no_mutasi
    LEFT JOIN barang_inventaris on mutasi_asal.kd_inventaris=barang_inventaris.kd_inventaris
    LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
    LEFT JOIN penempatan on mutasi_tujuan.no_penempatan=penempatan.no_penempatan
    LEFT JOIN penempatan_item on penempatan.no_penempatan=penempatan_item.no_penempatan
    LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
	LEFT JOIN departemen ON penempatan.kd_departemen = departemen.kd_departemen
    WHERE mutasi_tujuan.no_mutasi='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	$dataKode           = $myData['no_mutasi'];
	$KodeInventaris	    = $myData['kd_inventaris'];
	$kodePenempatanLama = isset($_POST['txtNoPenempatan']) ? $_POST['txtNoPenempatan']        : $myData['no_penempatan_lama'];
	$kodePenempatan 	= isset($_POST['txtNoPenempatan']) ? $_POST['txtNoPenempatan']        : $myData['no_penempatan'];
	$dataStatus 		= isset($_POST['dataStatus']) ? $_POST['dataStatus']            : $myData['status_aktif'];
	$dataTglMutasi 		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal']            : IndonesiaTgl($myData['tgl_mutasi']);
	$dataDepartemen		= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen']      : $myData['kd_departemen'];
	$dataLokasi			= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi']              : $myData['kd_lokasi'];
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan']      : $myData['deskripsi'];
	$dataKeterangan2	= isset($_POST['txtKeterangan2']) ? $_POST['txtKeterangan2']    : $myData['keterangan'];
	$txtNamaBrg	        = isset($_POST['txtNamaBrg']) ? $_POST['txtNamaBrg']            : $myData['nm_barang'];
	$fileName 			= isset($_POST['files']) ? $_POST['files']                      : $myData['form_bast'];

	$tmp2Sql = "SELECT * FROM mutasi_asal WHERE kd_inventaris='$KodeInventaris'";
	$tmp2Qry = mysql_query($tmp2Sql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
	while ($tmpData = mysql_fetch_array($tmp2Qry)) {
		$nomorPenempatan 	= $tmpData['no_penempatan_lama']; // Nomor penempatan lama
		$kodeInventarisBarang 	= $tmpData['kd_inventaris']; // Kode label barang yang dimutasi

		// Skrip Update status barang dari Penempatan Lama, Status menjadi NO (Tidak aktif)
		$mySql = "UPDATE penempatan_item SET status_aktif='Yes' WHERE kd_inventaris='$kodeInventarisBarang' AND no_penempatan ='$nomorPenempatan'";
		mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status" . mysql_error());
	}
	// =======================================================================================================

	# ========================================================================================================
	# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
	if (isset($_POST['btnSimpan'])) {
		# Baca variabel from
		$txtKodeInventaris	= $_POST['txtKodeInventaris'];
		$txtKodeInventaris	= str_replace("'", "&acute;", $txtKodeInventaris);
		$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
		$cmbDepartemen		= $_POST['cmbDepartemen'];
		$cmbLokasi			= $_POST['cmbLokasi'];
		$txtKeterangan		= $_POST['txtKeterangan'];
		$txtKeterangan2		= $_POST['txtKeterangan2'];

		# Validasi form
		$pesanError = array();
		if (trim($txtKodeInventaris) == "") {
			$pesanError[] = "Data <b>Inventaris</b> belum diisi, pilih pada pencarian atau ketik manual !";
		}
		if (trim($txtTanggal) == "--") {
			$pesanError[] = "Data <b>Tgl. Transaksi</b> belum diisi, pilih pada combo !";
		}
		if (trim($txtKeterangan) == "") {
			$pesanError[] = "Data <b>Keterangan Mutasi</b> belum diisi, silahkan diisi !";
		}
		if (trim($cmbDepartemen) == "Kosong") {
			$pesanError[] = "Data <b>Departemen Penempatan Baru</b> belum diisi, pilih pada combo !";
		}
		if (trim($cmbLokasi) == "Kosong") {
			$pesanError[] = "Data <b>Lokasi Penempatan Baru</b> belum diisi, pilih pada combo !";
		}
		if (trim($txtKeterangan2) == "") {
			$pesanError[] = "Data <b>Keterangan Penempatan</b> belum diisi, silahkan diisi !";
		}
		// if (trim($fileName) == "file" or trim($fileName) == "file0") {
		// 	$pesanError[] = "Data <b> Form Mutasi</b> belum diupload/lampirkan!";
		// }

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
			if (implode('', $images) == '' or implode('', $images) == '0') {
				$cek = mysql_fetch_array(mysql_query("SELECT * FROM penempatan where no_penempatan='$_POST[txtKode]'"));
				$fileName = $cek['form_bast'];
			} else {
				$fileName = implode(';', $images);
			}
			# SIMPAN DATA KE DATABASE
			# Jika jumlah error pesanError tidak ada

			// Menyimpan data utama Mutasi 
			$Kode	= $_POST['txtKode'];
			$mySql	= "UPDATE mutasi SET tgl_mutasi='$txtTanggal', deskripsi='$txtKeterangan' WHERE no_mutasi='$Kode'";
			mysql_query($mySql, $koneksidb) or die("Gagal query mutasi baru : " . mysql_error());

			// Penempatan Baru (Tempat Baru)
			$my2Sql	= "UPDATE penempatan SET tgl_penempatan='$txtTanggal', kd_lokasi='$cmbLokasi', kd_departemen='$cmbDepartemen', keterangan='$txtKeterangan2', form_bast='$fileName' WHERE no_penempatan = '$kodePenempatan'";
			$my2Qry	= mysql_query($my2Sql, $koneksidb) or die("Gagal query penempatan baru : " . mysql_error());

			$my3Sql	= "UPDATE mutasi_tujuan SET keterangan='$txtKeterangan2' WHERE no_mutasi = '$Kode'";
			mysql_query($my3Sql, $koneksidb) or die("Gagal query 3 : " . mysql_error());

			$tmpSql = "SELECT * FROM penempatan_item WHERE kd_inventaris='$txtKodeInventaris'";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
			while ($tmpData = mysql_fetch_array($tmpQry)) {
				$nomorPenempatan 	= $tmpData['no_penempatan']; // Nomor penempatan lama
				$kodeInventarisBarang 	= $tmpData['kd_inventaris']; // Kode label barang yang dimutasi

				// Skrip Update status barang dari Penempatan Lama, Status menjadi NO (Tidak aktif)
				$mySql = "UPDATE penempatan_item SET status_aktif='No' WHERE kd_inventaris='$kodeInventarisBarang' AND no_penempatan ='$nomorPenempatan'";
				mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status" . mysql_error());

				// MEMINDAH DATA 2, Masukkan semua dari TMP_Mutasi ke dalam tabel Mutasi_Asal
				$pindah2Sql = "UPDATE mutasi_asal SET kd_inventaris= '$txtKodeInventaris', no_penempatan_lama = '$nomorPenempatan' WHERE no_mutasi='$Kode'";
				mysql_query($pindah2Sql, $koneksidb) or die("Gagal Query penempatan_item : " . mysql_error());
			}

			// MEMINDAH DATA, Masukkan semua dari TMP_Mutasi ke dalam tabel Penempatan_Item
			$pindahSql = "UPDATE penempatan_item SET kd_inventaris='$txtKodeInventaris' WHERE no_penempatan='$kodePenempatan' ";
			mysql_query($pindahSql, $koneksidb) or die("Gagal Query penempatan_item1 : " . mysql_error());

			// Refresh form
			echo "<meta http-equiv='refresh' content='0; url=?open=Mutasi-Tampil'>";
			echo "<script>";
		}
	}

	if (isset($_POST['btnKembali'])) {
		echo "<meta http-equiv='refresh' content='0; url=?open=Mutasi-Tampil'>";
	}
	// ============================================================================

	# ========================================================================================================

	?>
	<SCRIPT language="JavaScript">
		function submitform() {
			document.form1.submit();
		}
	</SCRIPT>
	<div class="table-border">
		<h2>MUTASI (PEMINDAHAN) BARANG</h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" target="_self" method="post" name="form1" enctype="multipart/form-data">
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
							<input name="txtKodeInventaris" id="txtKodeInventaris" value="<?php echo $KodeInventaris; ?>" size="23" maxlength="12" />
						</b></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><strong>:</strong></td>
					<td><input name="txtNamaBrg" id="txtNamaBrg" value="<?php echo $txtNamaBrg; ?>" size="26" maxlength="100" disabled="disabled" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><a href="javaScript: void(0)" target="_self" onclick="window.open('pencarian_barang_terpakai.php')"><strong>Pencarian Barang</strong></a>,<strong></strong> untuk membaca label barang </td>
				</tr>
				<tr>
					<td bgcolor="#F5F5F5"><strong>PENEMPATAN BARU </strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr class="table-list">
					<td><strong>Departemen </strong></td>
					<td><strong>:</strong></td>
					<td>
						<?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) { ?>
							<select name="cmbDepartemen" onchange="javascript:submitform();" data-live-search="true" class="selectpicker">
								<?php
								$mySql = "SELECT * FROM departemen WHERE nm_departemen='$_SESSION[SES_UNIT]' ORDER BY kd_departemen";
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
						<?php } else { ?>
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
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td><strong>Lokasi </strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) { ?>
								<select name="cmbLokasi" data-live-search="true" class="selectpicker">
									<option value="Kosong"> Pilih Lokasi </option>
									<?php
									// Menampilkan data Lokasi dengan filter Nama Departemen yang dipilih
									$comboSql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen WHERE departemen.nm_departemen='$_SESSION[SES_UNIT]' ORDER BY kd_lokasi";
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
							<?php } else { ?>
								<select name="cmbLokasi" data-live-search="true" class="selectpicker">
									<option value="Kosong"> Pilih Lokasi </option>
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
							<?php }  ?>
						</b></td>
				</tr>
				<tr class="table-list">
					<td><strong>Keterangan</strong></td>
					<td><strong>:</strong></td>
					<td><input name="txtKeterangan2" value="<?php echo $dataKeterangan2; ?>" size="26" maxlength="100" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor="#F5F5F5"><strong>MUTASI</strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="15%"><strong>No. Mutasi </strong></td>
					<td width="1%"><strong>:</strong></td>
					<td width="78%"><input name="textfield" size="26" value="<?php echo $dataKode; ?>" readonly="readonly" /></td>
					<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
				</tr>
				<tr>
					<td><strong>Tgl. Mutasi </strong></td>
					<td><strong>:</strong></td>
					<td><input name="txtTanggal" id="date" class="tcal" size="26" value="<?php echo $dataTglMutasi; ?>" readonly="readonly" /></td>
				</tr>
				<tr>
					<td><strong>Keterangan</strong></td>
					<td><strong>:</strong></td>
					<td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="26" maxlength="100" /></td>
				</tr>
				<tr>
					<td><b>Form / Bast</b></td>
					<td><b>:</b></td>
					<td><input type='file' name="files[]" multiple />
						<?php
						$ex = explode(';', $myData['form_bast']);
						$no = 1;
						for ($i = 0; $i < count($ex); $i++) {
							if ($ex[$i] != '') {
								echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'><img style='margin-left:5px' width='100px' src='user_data/" . $ex[$i] . "'></a>";
							}
							$no++;
						}
						?>
					</td>
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
		</form>
	</div>