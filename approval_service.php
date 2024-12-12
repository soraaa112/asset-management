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
			$pesanError[] = "Data <b>Tanggal Kembali</b> belum diisi, pilih pada combo !";
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
				echo "<script>alert('Data service Belum Diapprove')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Service-Tampil'>";
				die;
			}

			// Skrip Update status barang (used=keluar/dipakai)
			$txtKode	= $_POST['txtKode'];
			$mySql = "UPDATE services SET status_approval_service = '$cmbStatus' WHERE no_service='$txtKode'";
			mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status : " . mysql_error());

			# PROSES SIMPAN DATA PENGEMBALIAN
			// Periksa data Pengembalian, apakah sudah dikembalikan
			$cekSql = "SELECT * FROM approval_service WHERE no_service='$txtKode'";
			$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Tmp : " . mysql_error());
			if (mysql_num_rows($cekQry) >= 1) {
				// Update informasi pengembalian
				$my2Sql	= "UPDATE approval_service SET tgl_approval= '$txtTanggal'
							WHERE no_service='$txtKode'";
				$my2Qry = mysql_query($my2Sql, $koneksidb) or die("Gagal query kembali : " . mysql_error());
			} else {
				// Skrip menyimpan Pengembalian
				$kodeBaru = buatKode7($koneksidb, "approval", "AP");
				$my2Sql	= "INSERT INTO approval_service (no_approval, tgl_approval, no_service)
							VALUES ('$kodeBaru', '$txtTanggal', '$txtKode')";
				$my2Qry = mysql_query($my2Sql, $koneksidb) or die("Gagal query kembali : " . mysql_error());
			}

			// Konfirmasi
			echo "<script>alert('Data service Sudah Diapprove')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Service-Tampil'>";
		}
	}

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Service-Tampil'>";
	}

	# TAMPILKAN DATA UNTUK DIEDIT
	$Kode	 = $_GET['Kode'];
	$mySql = "SELECT services.*, lokasi.nm_lokasi, departemen.nm_departemen, service_item.customer, service_item.keterangan as deskripsi, service_item.serial_number as sn FROM services
	LEFT JOIN service_item ON services.no_service = service_item.no_service
	LEFT JOIN lokasi ON services.kd_lokasi = lokasi.kd_lokasi
	LEFT JOIN departemen ON services.lokasi = departemen.kd_departemen
	WHERE services.no_service='$Kode'";
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
					<h2><strong>APPROVAL SERVICE</strong></h2>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F5F5F5"><strong>APPROVAL SERVICE</strong></td>
				<td>&nbsp;</td>
				<td><input name="txtKode" type="hidden" value="<?php echo $Kode; ?>" /></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td width="30"><strong>No. service </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['no_service']; ?>" size="25" readonly /></td>
				<td width="21"><strong>Departemen </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['nm_departemen']; ?>" size="25" readonly /></td>
			</tr>
			<tr>
				<td width="30"><strong>Tanggal Kirim </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo IndonesiaTgl($myData['tgl_kirim']); ?>" size="25" readonly /></td>
				<td width="21"><strong>Customer </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['customer']; ?>" size="25" readonly /></td>
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
						foreach ($approval_service as $nilai) {
							if ($myData['status_approval_service'] == $nilai) {
								$cek = " selected";
							} else {
								$cek = "";
							}
							echo "<option value='$nilai' $cek>$nilai</option>";
						}
						?>
					</select>
				</td>
				<td width="21"><strong>Serial Number </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['sn']; ?>" size="25" readonly /></td>
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

		<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td colspan="4"><strong>DAFTAR BARANG </strong></td>
			</tr>
			<tr>
				<td width="21" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
				<td width="35" bgcolor="#CCCCCC"><strong>Kode</strong></td>
				<td width="200" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
				<td width="150" bgcolor="#CCCCCC"><strong>Supplier </strong></td>
				<td width="75" align="right" bgcolor="#CCCCCC"><strong>Harga</strong></td>
			</tr>
			<?php
			$grandTotal = 0;
			$totalBarang = 0;
			// Qury menampilkan data dalam Grid TMP_peminjaman 
			$tmpSql = "SELECT barang.nm_barang, kategori.nm_kategori, service_item.*, supplier.nm_supplier
			FROM  service_item
			LEFT JOIN services ON service_item.no_service = services.no_service
			LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
			LEFT JOIN supplier ON services.kd_supplier = supplier.kd_supplier
			WHERE service_item.no_service='$Kode'
			ORDER BY barang.kd_barang ";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
			$nomor = 0;
			while ($tmpData = mysql_fetch_array($tmpQry)) {
				$grandTotal  = $tmpData['harga_service'];// harga beli dari tabel pengadaan_item (harga terbaru dari supplier)
				$nomor++;
			?>
				<tr>
					<td align="center"><?php echo $nomor; ?></td>
					<td><b><?php echo $tmpData['kd_inventaris']; ?></b></td>
					<td><?php echo $tmpData['nm_barang']; ?></td>
					<td><?php echo $tmpData['nm_supplier']; ?></td>
					<td align="right"><?php echo format_angka($tmpData['harga_service']); ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan="4" align="right"><b> GRAND TOTAL : </b></td>
				<td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($grandTotal); ?></strong></td>
			</tr>
		</table>
	</form>


	