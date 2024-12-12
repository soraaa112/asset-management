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
			$mySql = "DELETE FROM tmp_opname  WHERE id='$ID' AND kd_petugas='$userLogin'";
			mysql_query($mySql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());
		}
		if (trim($Act) == "Sucsses") {
			echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
		}
	}
	// =========================================================================


	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';

	if (isset($_POST['btnTambah'])) {
		// Baca variabel
		$txtKodeInventaris	= $_POST['txtKodeInventaris'];
		$txtKodeInventaris	= str_replace("'", "&acute;", $txtKodeInventaris);
		
		$waktu = date('Y');

		// Validasi form
		$pesanError = array();
		if (trim($txtKodeInventaris) != "") {
			// Jika Kode Inv Barang tidak kosong, maka periksa keberadaan kode dalam database (tabel barang_inventaris)
			# Periksa Database 1, apakah Kode Inventaris yang dimasukkan ada di dalam Database
			$cekSql	= "SELECT * FROM barang_inventaris WHERE kd_inventaris='$txtKodeInventaris' or RIGHT(kd_inventaris,6) ='$txtKodeInventaris'";
			$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query" . mysql_error());
			if (mysql_num_rows($cekQry) < 1) {
				$pesanError[] = "Kode Barang <b>$txtKodeInventaris</b> tidak ditemukan dalam database!";
			}

			# Periksa Database 2, apakah Kode Inventaris sudah diinput atau belum
			$cek2Sql	= "SELECT * FROM tmp_opname WHERE kd_inventaris='$txtKodeInventaris'";
			$cek2Qry = mysql_query($cek2Sql, $koneksidb) or die("Gagal Query" . mysql_error());
			if (mysql_num_rows($cek2Qry) >= 1) {
				$pesanError[] = "Kode Barang <b>$txtKodeInventaris</b> sudah di-Input, ganti dengan yang lain !";
			}
			
			# Periksa Database 2, apakah Kode Inventaris sudah diinput atau belum
			$cek2Sql	= "SELECT * FROM opname_item
			LEFT JOIN opname ON opname_item.kd_opname = opname.kd_opname
			WHERE opname_item.kd_inventaris='$txtKodeInventaris' AND LEFT(opname.tahun_opname,4) = '$waktu'";
			$cek2Qry = mysqli_query($koneksidb, $cek2Sql) or die("Gagal Query" . mysqli_error($koneksidb));
			if (mysqli_num_rows($cek2Qry) >= 1) {
				$pesanError[] = "Kode Barang <b>$txtKodeInventaris</b> sudah di opname tahun ini, ganti dengan yang lain !";
			}
		} else {
		    $pesanError[] = "Data <b>Kode/ Label Barang</b> belum diisi, ketik secara manual atau dari <b>Barcode Reader atau Pencarian Barang</b> !";
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
			# JIKA TIDAK MENEMUKAN ERROR
			$bacaSql	= "SELECT * FROM barang_inventaris WHERE ( kd_inventaris='$txtKodeInventaris' OR RIGHT(kd_inventaris,6) ='$txtKodeInventaris' ) ";
			$bacaQry 	= mysql_query($bacaSql, $koneksidb) or die("Gagal Query baca : " . mysql_error());
			if (mysql_num_rows($bacaQry) >= 1) {
				$bacaData	= mysql_fetch_array($bacaQry);

				$kodeInventaris		= $bacaData['kd_inventaris'];

				// Menyimpan data ke Keranjang (TMP)
				$tmpSql 	= "INSERT INTO tmp_opname (kd_petugas, kd_inventaris) 
			VALUES ('$userLogin','$txtKodeInventaris')";
				mysql_query($tmpSql, $koneksidb) or die("Gagal Query tmp : " . mysql_error());
			}
		}
	}

	# TOMBOL SIMPAN DIKLIK
	if (isset($_POST['btnSimpan'])) {
		# Baca Variabel Form
		$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
		$txtKeterangan	= $_POST['txtKeterangan'];
		$txtKeterangan	= str_replace("'", "&acute;", $txtKeterangan); // menghalangi penulisan tanda petik satu (')
		$cmbStatus		= $_POST['cmbStatus'];
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
		# Validasi form, jika kosong sampaikan pesan error
		$pesanError = array();
		if (trim($txtTanggal) == "") {
			$pesanError[] = "Data <b>Tahun Opname</b> tidak boleh kosong, silahkan diisi !";
		}
		if (trim($cmbStatus) == "Kosong") {
			$pesanError[] = "Data <b>Status Barang</b> belum dipilih !";
		}
		if (trim($txtKeterangan) == "") {
			$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong, silahkan diisi !";
		}
		if (trim($fileName) == "file" or trim($fileName) == "file0") {
			$pesanError[] = "Data <b> Kwitansi / Nota</b> belum diupload/lampirkan!";
		}

		# Validasi Nama barang, jika sudah ada akan ditolak
		// $sqlCek="SELECT * FROM barang WHERE nm_barang='$txtNama'";
		// $qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
		// if(mysql_num_rows($qryCek)>=1){
		// 	$pesanError[] = "Maaf, Nama Barang <b> $txtNama </b> sudah dipakai, ganti dengan yang lain";
		// }

		$tmpSql = "SELECT COUNT(*) As qty FROM tmp_opname WHERE kd_petugas='$userLogin'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
		$tmpData = mysql_fetch_array($tmpQry);
		if ($tmpData['qty'] < 1) {
			$pesanError[] = "<b>BELUM MENG-INPUT DATA BARANG</b>, minimal 1 Barang.";
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

			# SIMPAN DATA KE DATABASE. // Jika tidak menemukan error, simpan data ke database
			$kodeBaru = buatkode7($koneksidb, "opname", "OP");
			$mySql	= "INSERT INTO opname (kd_opname, kd_petugas, tahun_opname, keterangan, foto_barang, status) 
							VALUES ('$kodeBaru',
								'$userLogin',
								'$txtTanggal',
								'$txtKeterangan', 
                                '$fileName',
								'$cmbStatus')";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query stok opname" . mysql_error());
			if ($myQry) {
				# �LANJUTAN, SIMPAN DATA
				# Ambil semua data barang yang dipilih, berdasarkan Petugas yg login
				$tmpSql = "SELECT * FROM tmp_opname WHERE kd_petugas='$userLogin'";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
				while ($tmpData = mysql_fetch_array($tmpQry)) {
					// Baca data dari tabel Inventaris Barang
					$dataKode 		= $tmpData['kd_inventaris'];

					// MEMINDAH DATA, Masukkan semua dari TMP_Mutasi ke dalam tabel Penempatan_Item
					$itemSql	= "INSERT INTO opname_item (kd_opname, kd_inventaris) 
				VALUES ('$kodeBaru', '$dataKode')";
					mysql_query($itemSql, $koneksidb) or die("Gagal Query Item : " . mysql_error());

					// Skrip Update status barang (used=keluar/dipakai)
					// $mySql = "UPDATE barang_inventaris SET status_barang='Ditempatkan' WHERE kd_inventaris='$dataKode'";
					// mysql_query($mySql, $koneksidb) or die ("Gagal Query Edit Status".mysql_error());
				}

				# Kosongkan Tmp jika datanya sudah dipindah
				$hapusSql = "DELETE FROM tmp_opname WHERE kd_petugas='$userLogin'";
				mysql_query($hapusSql, $koneksidb) or die("Gagal kosongkan tmp" . mysql_error());

				// Refresh form
				echo "<script>alert('Data Stok Opname Berhasil Ditambah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Stok-Opname'>";
			}
		}
	} // Penutup POST

	if (isset($_POST['btnKembali'])) {

			echo "<meta http-equiv='refresh' content='0; url=?open=Stok-Opname'>";
		
	}
	// ============================================================================

	# =============================================================================

	# MASUKKAN DATA KE VARIABEL
	$dataKode		= buatKode7($koneksidb, "opname", "OP");
	$dataTahun 	    = isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
	$files			= isset($_POST['files']) ? $_POST['files'] : '';
	?>
	<SCRIPT language="JavaScript">
		function submitform() {
			document.frmadd.submit();
		}
	</SCRIPT>

	<div class="table-border">
		<h2>TAMBAH DATA OPNAME</h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="frmadd" name="frmadd" target="_self" enctype="multipart/form-data">
			<table width="100%" cellpadding="2" cellspacing="1" class="table-list" style="margin-top:0px;">
				<tr>
					<td bgcolor="#F5F5F5"><strong>INPUT BARANG </strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Kode/ Label Barang </strong></td>
					<td><strong>:</strong></td>
					<td><b>
							<input type="text" name="txtKodeInventaris" id="txtKodeInventaris" size="20" maxlength="12" autofokus />
							<input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
						</b>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><strong>:</strong></td>
					<td><input name="txtNamaBrg" id="txtNamaBrg" size="30" maxlength="100" disabled="disabled" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><a href="javaScript: void(0)" onclick="window.open('pencarian_barang_opname.php')" target="_self"><strong>Pencarian Barang</strong></a>,<strong></strong> untuk membaca label barang </td>
				</tr>
				<tr>
					<td bgcolor="#F5F5F5"><strong>DATA OPNAME </strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="17%"><b>Kode</b></td>
					<td width="1%"><b>:</b></td>
					<td width="82%"><input name="textfield" value="<?php echo $dataKode; ?>" size="20" maxlength="10" /> <i><small></small></i></td>
				</tr>
				<tr>
					<td><b>Tgl Opname </b></td>
					<td><b>:</b></td>
					<td><input id="date" name="txtTanggal" type="text" value="<?php echo $dataTahun; ?>" size="20" maxlength="20" /></td>
				</tr>
				<tr>
					<td><b>Kondisi</b></td>
					<td><b>:</b></td>
					<td><textarea name="txtKeterangan" cols="30" rows="3"><?php echo $dataKeterangan; ?></textarea></td>
				</tr>
				<tr>
					<td><strong>Status</strong></td>
					<td><b>:</b></td>
					<td><b>
							<select name="cmbStatus" data-live-search="true" class="selectpicker">
								<option value="Kosong"> Plih Status </option>
								<?php
								foreach ($status as $nilai) {
									if ($dataStatus == $nilai) {
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
					<td><b>Foto (Multiple Upload)</b></td>
					<td><b>:</b></td>
					<td><input type='file' id="files" name="files[]" multiple /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;">
						<input type="submit" name="btnKembali" value=" Kembali " />
					</td>
				</tr>
			</table>
			<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
				<tr>
					<th colspan="5">DAFTAR BARANG </th>
				</tr>
				<tr>
					<td width="25" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
					<td width="92" bgcolor="#CCCCCC"><strong>Kode</strong></td>
					<td width="526" bgcolor="#CCCCCC"><strong>Type Barang </strong></td>
					<td width="49" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
				</tr>
				<?php
				// Qury menampilkan data dalam Grid TMP_peminjaman 
				$tmpSql = "SELECT barang.*, tmp.* 
				FROM tmp_opname As tmp
				LEFT JOIN barang_inventaris ON tmp.kd_inventaris = barang_inventaris.kd_inventaris
				LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
				WHERE tmp.kd_inventaris=barang_inventaris.kd_inventaris
				AND tmp.kd_petugas='$userLogin'
				ORDER BY id ";
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
						<td align="center" bgcolor="#FFFFCC"><a href="index.php?open=Stok-Add&Act=Delete&ID=<?php echo $ID; ?>" target="_self">Delete</a></td>
					</tr>
				<?php } ?>
			</table>
		</form>
	</div>