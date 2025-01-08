<body>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
	<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
	<?php
	include_once "library/inc.seslogin.php";

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
	$filterSQL 	= "";
	$SQL 		= "";
	$SQLPage	= "";
	$bulan		= DATE('m');
	$tahun		= DATE('Y');

	# BACA VARIABEL KATEGORI
	$kodeKategori 	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
	$kodeKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;
	$status 		= isset($_POST['cmbstatusBarang']) ? $_POST['cmbstatusBarang'] : '';
	$cmbBulan 		= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan;
	$cmbTahun 		= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun;

	# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
	if (isset($_POST['btnCari'])) {
		if (trim($_POST['cmbTahun']) == "Semua") {
			if (trim($_POST['cmbBulan']) == "Semua") {
				if (trim($_POST['cmbKategori']) == "Semua") {
					//Query #1 (all)
					$filterSQL   = "";
				} else {
					//Query #2 (filter)
					$filterSQL   = "WHERE barang.kd_kategori ='$kodeKategori'";
				}
			} else {
				if (trim($_POST['cmbKategori']) == "Semua") {
					//Query #1 (all)
					$filterSQL   = "WHERE month(barang_mati.no.barang_mati) = '$cmbBulan'";
				} else {
					//Query #2 (filter)
					$filterSQL   = "WHERE month(barang_mati.no.barang_mati) = '$cmbBulan' AND barang.kd_kategori ='$kodeKategori'";
				}
			}
		} else {
			if (trim($_POST['cmbBulan']) == "Semua") {
				if (trim($_POST['cmbKategori']) == "Semua") {
					//Query #1 (all)
					$filterSQL   = "WHERE year(barang_mati.no.barang_mati) = '$cmbTahun'";
				} else {
					//Query #2 (filter)
					$filterSQL   = "WHERE year(barang_mati.no.barang_mati) = '$cmbTahun' AND barang.kd_kategori ='$kodeKategori'";
				}
			} else {
				if (trim($_POST['cmbKategori']) == "Semua") {
					//Query #1 (all)
					$filterSQL   = "WHERE year(barang_mati.no.barang_mati) = '$cmbTahun' AND month(barang_mati.no.barang_mati) = '$cmbBulan'";
				} else {
					//Query #2 (filter)
					$filterSQL   = "WHERE year(barang_mati.no.barang_mati) = '$cmbTahun' AND month(barang_mati.no.barang_mati) = '$cmbBulan' AND barang.kd_kategori ='$kodeKategori'";
				}
			}
		}
	} else {
		//Query #1 (all)
		$filterSQL   = "";
	}

	# UNTUK PAGING (PEMBAGIAN HALAMAN)
	$row = 10;
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
	if (isset($_POST['btnCari'])) {
		$pageSql = "SELECT barang_mati.*, barang.nm_barang, barang_inventaris.*, barang_mati.serial_number, barang_mati.kerusakan, barang_mati.status_approval_barang_mati
					FROM barang_mati
		LEFT JOIN barang_inventaris on barang_mati.kd_inventaris=barang_inventaris.kd_inventaris
		LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
		LEFT JOIN lokasi on barang_mati.pelanggan=lokasi.kd_lokasi
		$filterSQL
		GROUP BY barang_mati.no_barang_mati 
		ORDER BY barang_mati.no_barang_mati DESC";
	} else {
		$pageSql = "SELECT barang_mati.*, barang.nm_barang, barang_inventaris.*
					FROM barang_mati
		LEFT JOIN barang_inventaris on barang_mati.kd_inventaris=barang_inventaris.kd_inventaris
		LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
		LEFT JOIN lokasi on barang_mati.pelanggan=lokasi.kd_lokasi
		WHERE month(barang_mati.tanggal) = '$bulan'
		GROUP BY barang_mati.no_barang_mati 
		ORDER BY barang_mati.no_barang_mati DESC";
	}
	$pageQry 	= mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
	$jml	 	= mysql_num_rows($pageQry);
	$max	 	= ceil($jml / $row);
	?>
	<div class="table-border">
		<div style="overflow-x:auto;">
			<h2>DAFTAR BARANG MATI
				<?php if (isset($_SESSION["SES_PETUGAS"])) : ?>
					<a href="?open=Barang-Mati-Baru" target="_self"><img style='padding-right:0px !important' src="images/btn_add_data.png" border="0" /></a>
				<?php endif; ?>
			</h2>
			<form style='padding-top:0px !important' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
				<table width="900" border="0" class="table-list">
					<tr>
						<td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
					</tr>
					<tr>
						<td width="134"><strong> Bulan </strong></td>
						<td width="5"><strong>:</strong></td>
						<td width="741">
							<select name="cmbBulan" data-live-search="true" class="selectpicker">
								<option value="Semua"> Pilih Bulan </option>
								<option value="01" <?php echo ($cmbBulan == "01") ? "selected" : "" ?>> Januari </option>
								<option value="02" <?php echo ($cmbBulan == "02") ? "selected" : "" ?>> Februari </option>
								<option value="03" <?php echo ($cmbBulan == "03") ? "selected" : "" ?>> Maret </option>
								<option value="04" <?php echo ($cmbBulan == "04") ? "selected" : "" ?>> April </option>
								<option value="05" <?php echo ($cmbBulan == "05") ? "selected" : "" ?>> Mei </option>
								<option value="06" <?php echo ($cmbBulan == "06") ? "selected" : "" ?>> Juni </option>
								<option value="07" <?php echo ($cmbBulan == "07") ? "selected" : "" ?>> Juli </option>
								<option value="08" <?php echo ($cmbBulan == "08") ? "selected" : "" ?>> Agustus </option>
								<option value="09" <?php echo ($cmbBulan == "09") ? "selected" : "" ?>> September </option>
								<option value="10" <?php echo ($cmbBulan == "10") ? "selected" : "" ?>> Oktober </option>
								<option value="11" <?php echo ($cmbBulan == "11") ? "selected" : "" ?>> November </option>
								<option value="12" <?php echo ($cmbBulan == "12") ? "selected" : "" ?>> Desember </option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="134"><strong> Tahun </strong></td>
						<td width="5"><strong>:</strong></td>
						<td width="741">
							<select name="cmbTahun" data-live-search="true" class="selectpicker">
								<option value="Semua"> Pilih Tahun </option>
								<?php for ($i = 2023; $i <= $tahun; $i++) : ?>
									<option value="<?php echo $i ?>" <?php echo ($cmbTahun == "$i") ? "selected" : "" ?>> <?php echo $i ?> </option>
								<?php endfor; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="134"><strong> Kategori </strong></td>
						<td width="5"><strong>:</strong></td>
						<td width="741">
							<select name="cmbKategori" data-live-search="true" class="selectpicker">
								<option value="Semua"> Pilih kategori </option>
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
			<table id="example1" class="table-list" style="width:100%">
				<thead>
					<tr>
						<td width="15" bgcolor="#CCCCCC"><strong>No</strong></td>
						<td width="65" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
						<td width="80" bgcolor="#CCCCCC"><strong>Kode Inventaris</strong></td>
						<td width="80" bgcolor="#CCCCCC"><strong>Serial Number</strong></td>
						<td width="154" bgcolor="#CCCCCC"><strong>Nama Barang</strong></td>
						<td width="100" bgcolor="#CCCCCC"><strong>Kerusakan</strong></td>
						<td width="100" bgcolor="#CCCCCC"><strong>Foto</strong></td>
						<td width="50" bgcolor="#CCCCCC"><strong>Status Approve</strong></td>
						<td width="90" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
					</tr>
				</thead>
				<tbody>
					<?php
					# Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
					if (isset($_POST['btnCari'])) {
						$mySql = "SELECT barang_mati.*, barang_mati.serial_number, barang.nm_barang, barang_inventaris.*, barang_mati.kerusakan, barang_mati.status_approval_barang_mati, barang_mati.kd_inventaris as kode
						FROM barang_mati 
						LEFT JOIN barang_inventaris on barang_mati.kd_inventaris=barang_inventaris.kd_inventaris
						LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
						LEFT JOIN lokasi on barang_mati.pelanggan=lokasi.kd_lokasi
						$filterSQL
						GROUP BY barang_mati.no_barang_mati
						ORDER BY barang_mati.no_barang_mati DESC";
					} else {
						$mySql = "SELECT barang_mati.*, barang.nm_barang, barang_inventaris.*, barang_mati.serial_number as sn, barang_mati.kd_inventaris as kode
						FROM barang_mati 
						LEFT JOIN barang_inventaris on barang_mati.kd_inventaris=barang_inventaris.kd_inventaris
						LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
						LEFT JOIN lokasi on barang_mati.pelanggan=lokasi.kd_lokasi
						WHERE month(barang_mati.tanggal) = '$bulan'
						GROUP BY barang_mati.no_barang_mati
						ORDER BY barang_mati.no_barang_mati DESC";
					}
					$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
					$nomor = $hal;
					while ($myData = mysql_fetch_array($myQry)) {
						$nomor++;

						# Membaca Kode pengadaan/ Nomor transaksi
						$Kode = $myData['no_barang_mati'];
						$note = $myData['nm_barang'];


						// gradasi warna
						if ($nomor % 2 == 1) {
							$warna = "";
						} else {
							$warna = "#F5F5F5";
						}
					?>
						<tr bgcolor="<?php echo $warna; ?>">
							<td><?php echo $nomor; ?>.</td>
							<td><?php echo IndonesiaTgl($myData['tanggal']); ?></td>
							<td><?php echo $myData['kode']; ?></td>
							<td><?php echo $myData['sn']; ?></td>
							<td><?php echo $myData['nm_barang']; ?></td>
							<td><?php echo $myData['kerusakan']; ?></td>
							<td><?php
								$ex = explode(';', $myData['foto']);
								$no = 1;
								for ($i = 0; $i < count($ex); $i++) {
									if ($ex[$i] != '') {
										echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'>" . $ex[$i] . "</a>, ";
									}
									$no++;
								} ?>
							</td>
							<td><?php echo $myData['status_approval_barang_mati']; ?></td>
							<?php if ($myData['status_approval_barang_mati'] == 'Belum Approve') { ?>
								<?php if (isset($_SESSION["SES_PETUGAS"])) { ?>
									<td>
										<a href="?open=Barang-Mati-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BARANG MATI INI ... ?')" title="Hapus Data">
											<button class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i>
											</button>
										</a>
										<a href="?open=Barang-Mati-Edit&Kode=<?php echo $Kode; ?>" target="_self" title="Edit Data">
											<button class="btn btn-warning btn-sm" title="Edit Data"><i class="fa fa-pencil"></i>
											</button>
										</a>
									</td>
								<?php } else { ?>
									<td>
										<a type="button" href="?open=Barang-Mati-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BARANG MATI INI ... ?')" class="btn btn-danger btn-sm" title="Hapus Data">
											<i class="fa fa-trash"></i></a>

										<a type="button" href="?open=Approval-Barang-Mati&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-info btn-sm" title="Approve Data"><i class="fa fa-check"></i></a>
									</td>
								<?php } ?>
							<?php } else { ?>
								<?php if (isset($_SESSION["SES_PETUGAS"])) { ?>
									<td>
										<a href="?open=Barang-Mati-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BARANG MATI INI ... ?')" title="Hapus Data">
											<button class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i>
											</button>
										</a>
										<a href="?open=Barang-Mati-Edit&Kode=<?php echo $Kode; ?>" target="_self" title="Edit Data">
											<button class="btn btn-warning btn-sm" title="Edit Data"><i class="fa fa-pencil"></i>
											</button>
										</a>
									</td>
								<?php } else { ?>
									<td>
										<a type="button" href="?open=Barang-Mati-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BARANG MATI INI ... ?')" class="btn btn-danger btn-sm" title="Hapus Data">
											<i class="fa fa-trash"></i></a>
										<a type="button" href="cetak/barang_mati_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank" class="btn btn-success btn-sm" title="Cetak Data">
											<span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
									</td>
								<?php } ?>
							<?php } ?>
						<?php } ?>
				</tbody>
			</table>
		</div>
	</div>