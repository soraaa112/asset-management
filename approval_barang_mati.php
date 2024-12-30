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

	# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
	if (isset($_POST['btnSimpan'])) {
		// Baca variabel from
		$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
		$cmbStatus		= $_POST['cmbStatus'];

		// Validasi
		$pesanError = array();
		if (trim($txtTanggal) == "--") {
			$pesanError[] = "Data <b>Tanggal</b> belum diisi, pilih pada combo !";
		}

		// JIKA ADA PESAN ERROR DARI VALIDASI
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

			if ($cmbStatus === 'Belum Approve') {
				echo "<script>alert('Data Barang Mati Belum Diapprove')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Mati-Tampil'>";
				die;
			}

			// Skrip Update status barang (used=keluar/dipakai)
			$txtKode	= $_POST['txtKode'];
			$mySql = "UPDATE barang_mati SET status_approval_barang_mati = '$cmbStatus' WHERE no_barang_mati='$txtKode'";
			mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status : " . mysql_error());

			# PROSES SIMPAN DATA PENGEMBALIAN
			// Periksa data Pengembalian, apakah sudah dikembalikan
			$cekSql = "SELECT * FROM approval_barang_mati WHERE no_barang_mati='$txtKode'";
			$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Tmp : " . mysql_error());
			if (mysql_num_rows($cekQry) >= 1) {
				// Update informasi pengembalian
				$my2Sql	= "UPDATE approval_barang_mati SET tgl_approval= '$txtTanggal'
						WHERE no_barang_mati='$txtKode'";
				$my2Qry = mysql_query($my2Sql, $koneksidb) or die("Gagal query kembali : " . mysql_error());
			} else {
				// Skrip menyimpan Pengembalian
				$kodeBaru = buatKode7($koneksidb, "approval_barang_mati", "ABM");
				$my2Sql	= "INSERT INTO approval_barang_mati (no_approval, tgl_approval, no_barang_mati)
							VALUES ('$kodeBaru', '$txtTanggal', '$txtKode')";
				$my2Qry = mysql_query($my2Sql, $koneksidb) or die("Gagal query kembali : " . mysql_error());
			}

			$cekSql = "SELECT * FROM barang_mati WHERE no_barang_mati='$txtKode'";
			$sql = mysql_query($cekSql, $koneksidb) or die("Gagal Query Tmp : " . mysql_error());
			while ($myData = mysql_fetch_array($sql)){
				$kode = $myData['kd_inventaris'];
				$mySql = "UPDATE barang_inventaris SET status_aktif = 'No' WHERE kd_inventaris='$kode'";
				mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status : " . mysql_error());
			}

			// Konfirmasi
			echo "<script>alert('Data Barang Mati Sudah Diapprove')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Mati-Tampil'>";
		}
	}

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Mati-Tampil'>";
	}

	# TAMPILKAN DATA UNTUK DIEDIT
	$Kode	 = $_GET['Kode'];
	$mySql = "SELECT barang_mati.*, barang_mati.no_barang_mati, barang.nm_barang, lokasi.nm_lokasi, barang_mati.serial_number as sn, barang_mati.kerusakan, barang_mati.pelanggan, barang_mati.keterangan as deskripsi FROM barang_mati
			LEFT JOIN barang_inventaris on barang_mati.kd_inventaris=barang_inventaris.kd_inventaris
			LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
			LEFT JOIN lokasi on barang_mati.pelanggan = lokasi.kd_lokasi
			WHERE barang_mati.no_barang_mati='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	// Variabel data form
	$dataTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('Y-m-d');
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	?>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
		<table width="900" cellpadding="3" cellspacing="1" class="table-list">
			<tr>
				<td colspan="3">
					<h2><strong>APPROVAL BARANG MATI</strong></h2>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F5F5F5"><strong>APPROVAL BARANG MATI</strong></td>
				<td>&nbsp;</td>
				<td><input name="txtKode" type="hidden" value="<?php echo $Kode; ?>" /></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td width="30"><strong>No. Barang Mati </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['no_barang_mati']; ?>" size="25" readonly /></td>
				<td width="21"><strong>Serial Number </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['sn']; ?>" size="25" readonly /></td>
			</tr>
			<tr>
				<td width="30"><strong>Tanggal</strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo IndonesiaTgl($myData['tanggal']); ?>" size="25" readonly /></td>
				<td width="21"><strong>pelanggan</strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['pelanggan']; ?>" size="25" readonly /></td>
			</tr>
			<tr>
				<td width="30"><strong>Tanggal Approve</strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" name="txtTanggal" id="date" class="tcal" value="<?php echo IndonesiaTgl($dataTransaksi); ?>" size="25" /></td>
				<td width="21"><strong>Keterangan </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['deskripsi']; ?>" size="25" readonly /></td>
			</tr>
			<tr>
				<td width="30"><strong>Status Approve</strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50">
					<select name="cmbStatus" data-live-search="true" class="selectpicker show-tick" required>
						<option value=""> Pilih Status </option>
						<?php
						include_once "library/inc.pilihan.php";
						foreach ($approval_barang_mati as $nilai) {
							if ($myData['status_approval_barang_mati'] == $nilai) {
								$cek = " selected";
							} else {
								$cek = "";
							}
							echo "<option value='$nilai' $cek>$nilai</option>";
						}
						?>
					</select>
				</td>
				<td width="21"><strong> Kerusakan </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['kerusakan']; ?>" size="25" readonly /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>
					<button type="submit" name="btnSimpan" class="btn btn-success">
						<span class="glyphicon glyphicon-floppy-save" aria-hidden="true">&nbsp;</span><b>SIMPAN</b>
					</button>
					<button type="submit" name="btnKembali" class="btn btn-danger">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true">&nbsp;</span><b>KEMBALI</b>
					</button>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>