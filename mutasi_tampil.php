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
	include_once "library/inc.library.php";
	
	$userLogin  = $_SESSION['SES_LOGIN'];

	if (isset($userLogin)) {

		$mySql = "DELETE FROM tmp_mutasi WHERE kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my1Sql = "DELETE FROM tmp_opname WHERE kd_petugas='$userLogin'";
		mysql_query($my1Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my2Sql = "DELETE FROM tmp_peminjaman WHERE kd_petugas='$userLogin'";
		mysql_query($my2Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my3Sql = "DELETE FROM tmp_penempatan WHERE kd_petugas='$userLogin'";
		mysql_query($my3Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my4Sql = "DELETE FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
		mysql_query($my4Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my5Sql = "DELETE FROM tmp_service WHERE kd_petugas='$userLogin'";
		mysql_query($my5Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());
	}

	# Deklarasi variabel
	$filterSQL = "";
	$SQL = "";
	$SQLPage = "";

	if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
		# Pegawai terpilih
		$kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : $_SESSION['SES_UNIT'];
		$kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;
	} else {
		$kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
		$kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;
	}

	# BACA VARIABEL KATEGORI
	$kodeKategori = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
	$kodeKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

	# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
	if (isset($_POST['btnCari'])) {
		if (trim($_POST['cmbKategori']) == "Semua") {
			//Query #1 (all)
			$filterSQL   = "";
		} else {
			//Query #2 (filter)
			$filterSQL   =  " WHERE barang.kd_kategori ='$kodeKategori'";
		}
	} else {
		//Query #1 (all)
		$filterSQL   = "";
	}

	# Simpan Variabel TMP
	$dataKataKunci = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

	# UNTUK PAGING (PEMBAGIAN HALAMAN)
	$row = 10;
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
	if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
		if (isset($_POST['btnCari'])) {
			$pageSql = "SELECT * FROM mutasi
			LEFT JOIN mutasi_asal ON mutasi.no_mutasi = mutasi_asal.no_mutasi
			LEFT JOIN penempatan ON mutasi_asal.no_penempatan_lama = penempatan.no_penempatan
			LEFT JOIN departemen ON penempatan.kd_departemen = departemen.kd_departemen
			LEFT JOIN barang_inventaris ON mutasi_asal.kd_inventaris = barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
			$filterSQL AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'";
		} else {
			$pageSql = "SELECT * FROM mutasi
			LEFT JOIN mutasi_asal ON mutasi.no_mutasi = mutasi_asal.no_mutasi
			LEFT JOIN penempatan ON mutasi_asal.no_penempatan_lama = penempatan.no_penempatan
			LEFT JOIN departemen ON penempatan.kd_departemen = departemen.kd_departemen
			LEFT JOIN barang_inventaris ON mutasi_asal.kd_inventaris = barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
			$filterSQL WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'";
		}
	} else {
		$pageSql = "SELECT * FROM mutasi
		LEFT JOIN mutasi_asal ON mutasi.no_mutasi = mutasi_asal.no_mutasi
		LEFT JOIN barang_inventaris ON mutasi_asal.kd_inventaris = barang_inventaris.kd_inventaris
		LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
		LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
		$filterSQL";
	}
	$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
	$jml	 = mysql_num_rows($pageQry);
	$max	 = ceil($jml / $row);
	?>
	<div class="table-border">
		<div style="overflow-x:auto;">
			<h2>DAFTAR MUTASI BARANG <a href="?open=Mutasi-Baru" target="_self"><img style='padding-right:0px !important' src="images/btn_add_data.png" border="0" /></a></h2>
			<form style='padding-top:0px !important' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
				<table width="900" border="0" class="table-list">
					<tr>
						<td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
					</tr>
					<tr>
						<td width="134"><strong> Kategori </strong></td>
						<td width="5"><strong>:</strong></td>
						<td width="741">
							<select name="cmbKategori" data-live-search="true" class="selectpicker">
								<option value="Semua"> Pilih Kategori </option>
								<?php
								$mySql = "SELECT * FROM kategori ORDER BY kd_kategori";
								$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
								while ($myData = mysql_fetch_array($myQry)) {
									if ($kodeKategori == $myData['kd_kategori']) {
										$cek = " selected";
									} else {
										$cek = "";
									}
									echo "<option value='$myData[kd_kategori]' $cek>$myData[nm_kategori]</option>";
								}
								$mySql = "";
								?>
							</select>
							<input name="btnCari" type="submit" value=" Tampilkan " />
						</td>
					</tr>
				</table>
			</form>

			<table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
				<thead>
					<tr>
						<td width="22" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
						<td width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
						<td width="70" bgcolor="#CCCCCC"><strong>No. Mutasi</strong></td>
						<td width="100" bgcolor="#CCCCCC"><strong>No. Penempatan </strong></td>
						<td width="200" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
						<td width="165" bgcolor="#CCCCCC"><strong>Departemen &amp; Lokasi Baru </strong></td>
						<td width="80" align="center" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
						<td width="80" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
					</tr>
				</thead>
				<tbody>
					<?php
					// Srkip menampilkan data Mutasi
					if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
						if (isset($_POST['btnCari'])) {
							$mySql = "SELECT * FROM mutasi
							LEFT JOIN mutasi_asal ON mutasi.no_mutasi = mutasi_asal.no_mutasi
							LEFT JOIN penempatan ON mutasi_asal.no_penempatan_lama = penempatan.no_penempatan
							LEFT JOIN departemen ON penempatan.kd_departemen = departemen.kd_departemen
							LEFT JOIN barang_inventaris ON mutasi_asal.kd_inventaris = barang_inventaris.kd_inventaris
							LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
							LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
							$filterSQL AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'";
						} else {
							$mySql = "SELECT * FROM mutasi
							LEFT JOIN mutasi_asal ON mutasi.no_mutasi = mutasi_asal.no_mutasi
							LEFT JOIN penempatan ON mutasi_asal.no_penempatan_lama = penempatan.no_penempatan
							LEFT JOIN departemen ON penempatan.kd_departemen = departemen.kd_departemen
							LEFT JOIN barang_inventaris ON mutasi_asal.kd_inventaris = barang_inventaris.kd_inventaris
							LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
							LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
							$filterSQL WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'";
						}
					} else {
						$mySql = "SELECT * FROM mutasi
						LEFT JOIN mutasi_asal ON mutasi.no_mutasi = mutasi_asal.no_mutasi
						LEFT JOIN barang_inventaris ON mutasi_asal.kd_inventaris = barang_inventaris.kd_inventaris
						LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
						LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
						$filterSQL";
					}
					$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
					$nomor = $hal;
					while ($myData = mysql_fetch_array($myQry)) {
						$nomor++;

						# Membaca Kode mutasi/ Nomor transaksi
						$Kode 	= $myData['no_mutasi'];

						// Membaca informasi penempatan baru
						$my2Sql	= "SELECT mutasi_tujuan.*, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang FROM mutasi_tujuan 
						LEFT JOIN mutasi_asal ON mutasi_tujuan.no_mutasi = mutasi_asal.no_mutasi
						LEFT JOIN barang_inventaris ON mutasi_asal.kd_inventaris = barang_inventaris.kd_inventaris
						LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
						LEFT JOIN penempatan ON mutasi_tujuan.no_penempatan = penempatan.no_penempatan
						LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
						LEFT JOIN departemen ON penempatan.kd_departemen = departemen.kd_departemen
						WHERE mutasi_tujuan.no_mutasi = '$Kode'";
						$my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
						$my2Data = mysql_fetch_array($my2Qry);

						// Menghitung Total barang yang dimutasi 
						$my3Sql = "SELECT COUNT(*) AS total_barang FROM mutasi_asal WHERE no_mutasi='$Kode'";
						$my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query 3 salah : " . mysql_error());
						$my3Data = mysql_fetch_array($my3Qry);

						// gradasi warna
						if ($nomor % 2 == 1) {
							$warna = "";
						} else {
							$warna = "#F5F5F5";
						}
					?>
						<tr bgcolor="<?php echo $warna; ?>">
							<td align="center"><?php echo $nomor; ?></td>
							<td><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
							<td><?php echo $myData['no_mutasi']; ?></td>
							<td><?php echo $my2Data['no_penempatan']; ?></td>
							<td><?php echo $my2Data['nm_barang']; ?></td>
							<td><?php echo $my2Data['nm_departemen'] . ", " . $my2Data['nm_lokasi']; ?></td>
							<td align="center"><?php echo format_angka($my3Data['total_barang']); ?></td>
							<td align="center">
								<a href="?open=Mutasi-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA MUTASI INI ... ?')">
									<button class="btn btn-danger" title="Hapus Data"><i class="fa fa-trash"></i>
									</button>
								</a>
								&nbsp;
								<a href="?open=Mutasi-Edit&Kode=<?php echo $Kode; ?>" target="_self">
									<button class="btn btn-warning" title="Edit Data"><i class="fa fa-pencil"></i>
									</button>
								</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>