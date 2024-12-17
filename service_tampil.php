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

	# BACA VARIABEL KATEGORI
	$kodeKategori 	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
	$kodeKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;
	$status 		= isset($_POST['cmbstatusBarang']) ? $_POST['cmbstatusBarang'] : '';
	$cmbBulan 		= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan;

	# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
	if (isset($_POST['btnCari'])) {
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
				$filterSQL   = "WHERE month(services.tgl_kirim) = '$cmbBulan'";
			} else {
				//Query #2 (filter)
				$filterSQL   = "WHERE month(services.tgl_kirim) = '$cmbBulan' AND barang.kd_kategori ='$kodeKategori'";
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
		$pageSql = "SELECT * FROM services
		LEFT JOIN service_item ON services.no_service = service_item.no_service
		LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
		LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
		LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
		LEFT JOIN petugas ON services.kd_petugas = petugas.kd_petugas
		LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
		$filterSQL
		GROUP BY services.no_service ORDER BY services.no_service DESC";
	} else {
		$pageSql = "SELECT * FROM services
		LEFT JOIN service_item ON services.no_service = service_item.no_service
		LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
		LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
		LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
		LEFT JOIN petugas ON services.kd_petugas = petugas.kd_petugas
		LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
		WHERE month(services.tgl_kirim) = '$bulan'
		GROUP BY services.no_service ORDER BY services.no_service DESC";
	}
	$pageQry 	= mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
	$jml	 	= mysql_num_rows($pageQry);
	$max	 	= ceil($jml / $row);
	?>
	<div class="table-border">
		<div style="overflow-x:auto;">
			<h2>DAFTAR SERVIS
				<?php if (isset($_SESSION["SES_PETUGAS"])) : ?>
					<a href="?open=Service-Baru" target="_self"><img style='padding-right:0px !important' src="images/btn_add_data.png" border="0" /></a>
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
						<td width="80" bgcolor="#CCCCCC"><strong>SN Awal</strong></td>
						<td width="80" bgcolor="#CCCCCC"><strong>SN Akhir</strong></td>
						<td width="154" bgcolor="#CCCCCC"><strong>Nama Barang</strong></td>
						<td width="100" bgcolor="#CCCCCC"><strong>Kerusakan</strong></td>
						<td width="50" bgcolor="#CCCCCC"><strong>Status Approve</strong></td>
						<td width="50" bgcolor="#CCCCCC"><strong>Status</strong></td>
						<td width="90" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
					</tr>
				</thead>
				<tbody>
					<?php
					# Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
					if (isset($_POST['btnCari'])) {
						$mySql = "SELECT services.*, service_item.serial_number as sn, service_item.serial_number_baru, supplier.nm_supplier, barang.nm_barang, barang_inventaris.*, service_item.kerusakan, services.status_approval_service
						FROM services 
						LEFT JOIN supplier ON services.kd_supplier=supplier.kd_supplier
						LEFT JOIN service_item ON services.no_service=service_item.no_service
						LEFT JOIN barang_inventaris ON service_item.kd_inventaris=barang_inventaris.kd_inventaris
						LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
						LEFT JOIN petugas ON services.kd_petugas=petugas.kd_petugas
						$filterSQL
						GROUP BY services.no_service
						ORDER BY services.no_service DESC";
					} else {
						$mySql = "SELECT services.*, service_item.serial_number as sn, service_item.serial_number_baru, supplier.nm_supplier, barang.nm_barang, 
						barang_inventaris.*, service_item.kerusakan, services.status_approval_service
						FROM services 
						LEFT JOIN supplier ON services.kd_supplier=supplier.kd_supplier
						LEFT JOIN service_item ON services.no_service=service_item.no_service
						LEFT JOIN barang_inventaris ON service_item.kd_inventaris=barang_inventaris.kd_inventaris
						LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
						LEFT JOIN petugas ON services.kd_petugas=petugas.kd_petugas
						WHERE month(services.tgl_kirim) = '$bulan'
						GROUP BY services.no_service
						ORDER BY services.no_service DESC";
					}
					$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
					$nomor = $hal;
					while ($myData = mysql_fetch_array($myQry)) {
						$nomor++;

						# Membaca Kode pengadaan/ Nomor transaksi
						$Kode = $myData['no_service'];
						$note = $myData['kd_inventaris'];

						if ($myData['status_barang'] == "Ditempatkan") {
							$my1Sql = "SELECT lokasi.nm_lokasi, departemen.nm_departemen FROM penempatan_item as PI
							LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
							LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
							LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
							WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$note'";
							$my1Qry = mysql_query($my1Sql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
							$my1Data = mysql_fetch_array($my1Qry);
							$infoLokasi  = $my1Data['nm_lokasi'];
							$infoDepartemen = $my1Data['nm_departemen'];
						}

						// Mencari Siapa Penempatan Barang
						if ($myData['status_barang'] == "Dipinjam") {
							$my3Sql = "SELECT pegawai.nm_pegawai, departemen.nm_departemen FROM peminjaman_item as PI
							LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
							LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
							LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
							WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$note'";
							$my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query 3 salah : " . mysql_error());
							$my3Data = mysql_fetch_array($my3Qry);
							$infoLokasi  = $my3Data['nm_pegawai'];
							$infoDepartemen = $my3Data['nm_departemen'];
						}

						if ($myData['status_barang'] == "Tersedia") {
							$my4Sql = "SELECT pengadaan.*, barang_inventaris.status_barang, barang_inventaris.kd_inventaris, petugas.nm_petugas, departemen.nm_departemen FROM pengadaan 
							LEFT JOIN barang_inventaris ON pengadaan.no_pengadaan=barang_inventaris.no_pengadaan
							LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
							LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
							WHERE barang_inventaris.kd_inventaris='$note'";
							$my4Qry = mysql_query($my4Sql, $koneksidb)  or die("Query 4 salah : " . mysql_error());
							$my4Data = mysql_fetch_array($my4Qry);
							$infoLokasi  = $my4Data['status_barang'];
							$infoDepartemen = $my4Data['nm_departemen'];
						}

						# Menghitung Total pengadaan (belanja) setiap nomor transaksi
						$my2Sql = "SELECT harga_service
				   		FROM service_item WHERE no_service='$Kode'";
						$my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
						$my2Data = mysql_fetch_array($my2Qry);

						// gradasi warna
						if ($nomor % 2 == 1) {
							$warna = "";
						} else {
							$warna = "#F5F5F5";
						}
					?>
						<tr bgcolor="<?php echo $warna; ?>">
							<td><?php echo $nomor; ?>.</td>
							<td><?php echo IndonesiaTgl($myData['tgl_kirim']); ?></td>
							<td><?php echo $myData['sn']; ?></td>
							<td><?php echo $myData['serial_number_baru']; ?></td>
							<td><?php echo $myData['nm_barang']; ?></td>
							<td><?php echo $myData['kerusakan']; ?></td>
							<td><?php echo $myData['status_approval_service']; ?></td>
							<td><?php echo $myData['status'] ?></td>
							<?php if ($myData['status_approval_service'] == 'Belum Approve') { ?>
								<?php if (isset($_SESSION["SES_PETUGAS"])) { ?>
									<td>
										<a href="?open=Service-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGADAAN INI ... ?')" title="Hapus Data">
											<button class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i>
											</button>
										</a>
										<a href="?open=Service-Edit&Kode=<?php echo $Kode; ?>" target="_self" title="Edit Data">
											<button class="btn btn-warning btn-sm" title="Edit Data"><i class="fa fa-pencil"></i>
											</button>
										</a>
									</td>
								<?php } else { ?>
									<td>
										<a type="button" href="?open=Service-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGADAAN INI ... ?')" class="btn btn-danger btn-sm" title="Hapus Data">
											<i class="fa fa-trash"></i></a>

										<a type="button" href="?open=Approval-Service&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-info btn-sm" title="Approve Data"><i class="fa fa-check"></i></a>
									</td>
								<?php } ?>
							<?php } else { ?>
								<td>
									<?php if ($myData['status'] == 'DONE' || $myData['status'] == 'CANCEL') : ?>
										<a href="?open=Service-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA SERVICE INI ... ?')">
											<button class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i>
											</button>
										</a>
										<a href="?open=service_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">
											<button class="btn btn-success btn-sm" title="Edit Data"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>
											</button>
										</a>
									<?php else : ?>
										<a href="?open=Service-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA SERVICE INI ... ?')">
											<button class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i>
											</button>
										</a>
										<a href="?open=Service-Edit&Kode=<?php echo $Kode; ?>" target="_self">
											<button class="btn btn-warning btn-sm" title="Edit Data"><i class="fa fa-pencil"></i>
											</button>
										</a>
										<a href="?open=Service-Update-Status&Kode=<?php echo $Kode; ?>" target="_self">
											<button class="btn btn-primary btn-sm" title="Update Status"><i class="fa fa-check"></i>
											</button>
										</a>
									<?php endif; ?>
								</td>
						</tr>
				<?php }
						} ?>
				</tbody>
			</table>
		</div>
	</div>