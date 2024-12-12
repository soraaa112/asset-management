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
				echo "<script>alert('Data pengadaan Belum Diapprove')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Tampil'>";
				die;
			}

			// Skrip Update status barang (used=keluar/dipakai)
			$txtKode	= $_POST['txtKode'];
			$mySql = "UPDATE pengadaan SET status_approval = '$cmbStatus' WHERE no_pengadaan='$txtKode'";
			mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status : " . mysql_error());

			# PROSES SIMPAN DATA PENGEMBALIAN
			// Periksa data Pengembalian, apakah sudah dikembalikan
			$cekSql = "SELECT * FROM approval WHERE no_pengadaan='$txtKode'";
			$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Tmp : " . mysql_error());
			if (mysql_num_rows($cekQry) >= 1) {
				// Update informasi pengembalian
				$my2Sql	= "UPDATE approval SET tgl_approval= '$txtTanggal'
							WHERE no_pengadaan='$txtKode'";
				$my2Qry = mysql_query($my2Sql, $koneksidb) or die("Gagal query kembali : " . mysql_error());
			} else {
				// Skrip menyimpan Pengembalian
				$kodeBaru = buatKode7($koneksidb, "approval", "AP");
				$my2Sql	= "INSERT INTO approval (no_approval, tgl_approval, no_pengadaan)
							VALUES ('$kodeBaru', '$txtTanggal', '$txtKode')";
				$my2Qry = mysql_query($my2Sql, $koneksidb) or die("Gagal query kembali : " . mysql_error());
			}

			// Konfirmasi
			echo "<script>alert('Data Pengadaan Sudah Diapprove')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Tampil'>";
		}
	}

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Tampil'>";
	}

	# TAMPILKAN DATA UNTUK DIEDIT
	$Kode	= $_GET['Kode'];
	$mySql 	= "SELECT pengadaan.*, lokasi.nm_lokasi, departemen.nm_departemen FROM pengadaan
	LEFT JOIN lokasi ON pengadaan.kd_lokasi = lokasi.kd_lokasi
	LEFT JOIN departemen ON pengadaan.kd_departemen = departemen.kd_departemen
	WHERE no_pengadaan='$Kode'";
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
					<h2><strong>APPROVAL</strong></h2>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F5F5F5"><strong>APPROVAL</strong></td>
				<td>&nbsp;</td>
				<td><input name="txtKode" type="hidden" value="<?php echo $Kode; ?>" /></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td width="30"><strong>No. Pengadaan </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['no_pengadaan']; ?>" size="25" readonly /></td>
				<td width="21"><strong>Departemen </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['nm_departemen']; ?>" size="25" readonly /></td>
			</tr>
			<tr>
				<td width="30"><strong>Tanggal Pengadaan </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?>" size="25" readonly /></td>
				<td width="21"><strong>Customer </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['nm_lokasi']; ?>" size="25" readonly /></td>
			</tr>
			<tr>
				<td width="30"><strong>Tanggal Approve</strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" name="txtTanggal" id="date" class="tcal" value="<?php echo IndonesiaTgl($dataTransaksi); ?>" size="25" /></td>
				<td width="21"><strong>Keterangan </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['keterangan']; ?>" size="25" readonly /></td>
			</tr>
			<tr>
				<td width="30"><strong>Status Approve</strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50">
					<select name="cmbStatus" data-live-search="true" class="selectpicker show-tick" required>
						<option value=""> Pilih Status </option>
						<?php
						include_once "library/inc.pilihan.php";
						foreach ($approval as $nilai) {
							if ($myData['status_approval'] == $nilai) {
								$cek = " selected";
							} else {
								$cek = "";
							}
							echo "<option value='$nilai' $cek>$nilai</option>";
						}
						?>
					</select>
				</td>
				<td width="21"><strong>Nomor Resi </strong></td>
				<td width="1"><strong>:</strong></td>
				<td width="50"><input type="text" value="<?php echo $myData['nomor_resi']; ?>" size="25" readonly /></td>
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
				<td width="75" bgcolor="#CCCCCC"><strong>Harga</strong></td>
				<td width="75" align="center" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
				<td width="75" align="right" bgcolor="#CCCCCC"><strong>Total Harga</strong></td>
			</tr>
			<?php
			$subTotalBeli = 0;
			$grandTotalBeli = 0;
			$totalBarang = 0;
			// Qury menampilkan data dalam Grid TMP_peminjaman 
			$tmpSql = "SELECT barang.nm_barang, kategori.nm_kategori, pengadaan_item.*, supplier.nm_supplier
			FROM  pengadaan_item
			LEFT JOIN supplier ON pengadaan_item.kd_supplier = supplier.kd_supplier
			LEFT JOIN barang ON pengadaan_item.kd_barang = barang.kd_barang
			LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
			WHERE pengadaan_item.no_pengadaan='$Kode'
			ORDER BY barang.kd_barang ";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
			$nomor = 0;
			while ($tmpData = mysql_fetch_array($tmpQry)) {
				$totalBarang  = $totalBarang + $tmpData['jumlah'];
				$subTotalBeli  = $tmpData['harga_beli'] * $tmpData['jumlah']; // harga beli dari tabel pengadaan_item (harga terbaru dari supplier)
				$grandTotalBeli  = $grandTotalBeli + $subTotalBeli;
				$nomor++;
			?>
				<tr>
					<td align="center"><?php echo $nomor; ?></td>
					<td><b><?php echo $tmpData['kd_barang']; ?></b></td>
					<td><?php echo $tmpData['nm_barang']; ?></td>
					<td><?php echo $tmpData['nm_supplier']; ?></td>
					<td><?php echo format_angka($tmpData['harga_beli']); ?></td>
					<td align="center"><?php echo $tmpData['jumlah']; ?></td>
					<td align="right"><?php echo format_angka($subTotalBeli); ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan="6" align="right"><b> GRAND TOTAL : </b></td>
				<td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($grandTotalBeli); ?></strong></td>
			</tr>
		</table>
	</form>


	