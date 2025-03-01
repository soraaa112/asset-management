<?php
include_once "library/inc.seslogin.php";

// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if (isset($_POST['btnSimpan'])) {
	// Baca variabel from
	$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
	$txtKeterangan	= $_POST['txtKeterangan'];
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

	if (implode('', $images) != '') {
		$fileName = implode(';', $images);
	} else {
		$fileName = '';
	}
	// Validasi
	$pesanError = array();
	if (trim($txtTanggal) == "--") {
		$pesanError[] = "Data <b>Tanggal Kembali</b> belum diisi, pilih pada combo !";
	}
	if (trim($txtKeterangan) == "") {
		$pesanError[] = "Data <b>Keterangan</b> belum diisi, silahkan diperbaiki !";
	}
	if (trim($fileName) == "file" or trim($fileName) == "file0") {
		$pesanError[] = "Data <b> Kwitansi / Nota</b> belum diupload/lampirkan!";
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

		// Skrip Update status barang (used=keluar/dipakai)
		$txtKode	= $_POST['txtKode'];
		$mySql = "UPDATE peminjaman SET status_kembali='Kembali', tgl_kembali='$txtTanggal' WHERE no_peminjaman='$txtKode'";
		mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status : " . mysql_error());

		# PROSES SIMPAN DATA PENGEMBALIAN
		// Periksa data Pengembalian, apakah sudah dikembalikan
		$cekSql = "SELECT * FROM pengembalian WHERE no_peminjaman='$txtKode'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Tmp : " . mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			// Update informasi pengembalian
			$my2Sql	= "UPDATE pengembalian SET tgl_pengembalian = '$txtTanggal', keterangan = '$txtKeterangan', kd_petugas ='$userLogin', form_bast = '$fileName'
			WHERE no_peminjaman='$txtKode'";
			$my2Qry = mysql_query($my2Sql, $koneksidb) or die("Gagal query kembali : " . mysql_error());
		} else {
			// Skrip menyimpan Pengembalian
			$kodeBaru = buatKode("pengembalian", "KB");
			$my2Sql	= "INSERT INTO pengembalian (no_pengembalian, tgl_pengembalian, no_peminjaman, keterangan, kd_petugas, form_bast)
						VALUES ('$kodeBaru', '$txtTanggal', '$txtKode', '$txtKeterangan', '$userLogin', '$fileName')";
			$my2Qry = mysql_query($my2Sql, $koneksidb) or die("Gagal query kembali : " . mysql_error());
		}

		# PROSES MENGEMBALIKAN STATUS BARANG 
		// Membaca daftar Kode Inventaris
		$tmpSql = "SELECT * FROM peminjaman_item WHERE no_peminjaman='$txtKode'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp : " . mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			$kodeInventaris	= $tmpData['kd_inventaris'];

			// Skrip Update status barang (used=keluar/dipakai)
			$mySql = "UPDATE barang_inventaris SET status_barang='Tersedia' WHERE kd_inventaris='$kodeInventaris'";
			mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status : " . mysql_error());
		}

		// Konfirmasi
		echo "<br> <b> DATA SUDAH DISIMPAN, STATUS PINJAM BERHASIL DIKEMBALIKAN</b><br>";

		// Refresh
		echo "<meta http-equiv='refresh' content='2; url=?open=Peminjaman-Tampil'>";
	}
}

# TAMPILKAN DATA UNTUK DIEDIT
$Kode	 = $_GET['Kode'];
$mySql = "SELECT * FROM peminjaman WHERE no_peminjaman='$Kode'";
$myQry = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
$myData = mysql_fetch_array($myQry);

// Variabel data form
$dataTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$files			= isset($_POST['files']) ? $_POST['files'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
	<table width="900" cellpadding="3" cellspacing="1" class="table-list">
		<tr>
			<td colspan="3">
				<h1>PENGEMBALIAN</h1>
			</td>
		</tr>
		<tr>
			<td bgcolor="#F5F5F5"><strong>PENGEMBALIAN</strong></td>
			<td>&nbsp;</td>
			<td><input name="txtKode" type="hidden" value="<?php echo $Kode; ?>" /></td>
		</tr>
		<tr>
			<td width="21%"><strong>No. Peminjaman </strong></td>
			<td width="1%"><strong>:</strong></td>
			<td width="78%"><input type="text" value="<?php echo $myData['no_peminjaman']; ?>" readonly /></td>
		</tr>
		<tr>
			<td><strong>Tgl. Peminjaman </strong></td>
			<td><strong>:</strong></td>
			<td><input type="text" value="<?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?>" readonly /></td>
		</tr>
		<tr>
			<td><strong>Tgl. Kembali </strong></td>
			<td><strong>:</strong></td>
			<td><input type="text" name="txtTanggal" id="date" class="tcal" value="<?php echo $dataTransaksi; ?>" /></td>
		</tr>
		<tr>
			<td><strong>Keterangan</strong></td>
			<td><strong>:</strong></td>
			<td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
		</tr>
		<tr>
			<td><b>Form Pengembalian</b></td>
			<td><b>:</b></td>
			<td><input type="file" name="files[]" multiple /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" Simpan Data " />
				<a type="button" href="?open=Peminjaman-Tampil">
					<input type="button" value=" Kembali " />
				</a>
			</td>
		</tr>
	</table>

	<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td colspan="4"><strong>DAFTAR BARANG </strong></td>
		</tr>
		<tr>
			<td width="21" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
			<td width="96" bgcolor="#CCCCCC"><strong>Kode</strong></td>
			<td width="559" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
			<td width="203" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
		</tr>
		<?php
		// Qury menampilkan data dalam Grid TMP_peminjaman 
		$tmpSql = "SELECT barang.nm_barang, kategori.nm_kategori, peminjaman_item.* 
		FROM  peminjaman_item
			LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
		WHERE peminjaman_item.no_peminjaman='$Kode'
		ORDER BY barang.kd_barang ";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
		$nomor = 0;
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			$nomor++;
		?>
			<tr>
				<td align="center"><?php echo $nomor; ?></td>
				<td><b><?php echo $tmpData['kd_inventaris']; ?></b></td>
				<td><?php echo $tmpData['nm_barang']; ?></td>
				<td><?php echo $tmpData['nm_kategori']; ?></td>
			</tr>
		<?php } ?>
	</table>
</form>