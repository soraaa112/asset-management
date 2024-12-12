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

	$userLogin	= $_SESSION['SES_LOGIN'];

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
	$bulan		= DATE('m');

	# BACA VARIABEL KATEGORI
	$kodeKategori 	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
	$kodeKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;
	$status 		= isset($_POST['cmbstatusBarang']) ? $_POST['cmbstatusBarang'] : '';
	$cmbBulan 		= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan;

	if (isset($_POST['btnSave'])) {
		$id             = $_POST['kode'];
		$statusBarang   = $status;

		$mySql = "UPDATE pengadaan SET status = '$statusBarang' WHERE no_pengadaan='$id'";
		$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status" . mysql_error());
		var_dump($myQry['status']);

		echo "<script>alert('Status Barang Berhasil Diupdate')</script>";
		echo "<meta http-equiv='refresh' content='5; url=?open=Pengadaan-Tampil'>";
	}

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
				$filterSQL   = "WHERE month(pengadaan.tgl_pengadaan) = '$cmbBulan'";
			} else {
				//Query #2 (filter)
				$filterSQL   = "WHERE month(pengadaan.tgl_pengadaan) = '$cmbBulan' AND barang.kd_kategori ='$kodeKategori'";
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
		$pageSql = "SELECT pengadaan.*, kategori.nm_kategori, barang.nm_barang FROM pengadaan
		LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
		LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
		LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
		$filterSQL
		ORDER BY pengadaan.tgl_pengadaan DESC";
	} else {
		$pageSql = "SELECT pengadaan.*, kategori.nm_kategori, barang.nm_barang
		FROM pengadaan
		LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
		LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
		LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
		WHERE month(pengadaan.tgl_pengadaan) = '$bulan'
		ORDER BY pengadaan.tgl_pengadaan DESC";
	}
	$pageQry 	= mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
	$jml	 	= mysql_num_rows($pageQry);
	$max	 	= ceil($jml / $row);
	?>
	<div class="table-border">
		<div style="overflow-x:auto;">
			<h2>DAFTAR PENGADAAN
				<?php if (isset($_SESSION["SES_PETUGAS"])) : ?>
					<a href="?open=Pengadaan-Baru" target="_self"><img style='padding-right:0px !important' src="images/btn_add_data.png" border="0" /></a>
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
			<table id="example1" class="table-list" style="width:100%">
				<thead>
					<tr>
						<td width="10" bgcolor="#CCCCCC"><strong>No</strong></td>
						<td width="50" align="center" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
						<td width="80" align="center" bgcolor="#CCCCCC"><strong>Nama</strong></td>
						<td width="190" align="center" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
						<td width="190" align="center" bgcolor="#CCCCCC"><strong>Lokasi / Customer</strong></td>
						<td width="100" align="center" bgcolor="#CCCCCC"><strong>Status Approve</strong></td>
						<td width="100" align="center" bgcolor="#CCCCCC"><strong>Status Barang</strong></td>
						<td width="100" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
					</tr>
				</thead>
				<tbody>
				<?php
					if (isset($_POST['btnCari'])) {
						$mySql = "SELECT pengadaan.*, pengadaan.tgl_pengadaan, pengadaan.foto, pengadaan.foto_form, pengadaan.status_approval, petugas.nm_petugas, departemen.nm_departemen, lokasi.nm_lokasi, pengadaan.keterangan, pengadaan.status
						FROM pengadaan
						LEFT JOIN departemen ON pengadaan.kd_departemen=departemen.kd_departemen
						LEFT JOIN lokasi ON pengadaan.kd_lokasi=lokasi.kd_lokasi
						LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
						LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
						LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
						LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
						$filterSQL
						GROUP BY pengadaan.no_pengadaan
						ORDER BY pengadaan.no_pengadaan DESC";
					} else {
						$mySql = "SELECT pengadaan.no_pengadaan, pengadaan.tgl_pengadaan, pengadaan.foto, pengadaan.foto_form, pengadaan.status_approval, petugas.nm_petugas, departemen.nm_departemen, lokasi.nm_lokasi, pengadaan.keterangan, pengadaan.status
						FROM pengadaan
						LEFT JOIN departemen ON pengadaan.kd_departemen=departemen.kd_departemen
						LEFT JOIN lokasi ON pengadaan.kd_lokasi=lokasi.kd_lokasi
						LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas 
						WHERE month(pengadaan.tgl_pengadaan) = '$bulan'
						ORDER BY pengadaan.no_pengadaan DESC";
					}
					$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
					$nomor = $hal;
					while ($myData = mysql_fetch_array($myQry)) {
						$nomor++;

						# Membaca Kode pengadaan/ Nomor transaksi
						$Kode = $myData['no_pengadaan'];

						// gradasi warna
						if ($nomor % 2 == 1) {
							$warna = "";
						} else {
							$warna = "#F5F5F5";
						}

					?>
						<tr bgcolor="<?php echo $warna; ?>">
							<td><?php echo $nomor; ?>.</td>
							<td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
							<td><?php echo $myData['nm_petugas']; ?></td>
							<td><?php echo $myData['keterangan']; ?></td>
							<td><?php echo $myData['nm_lokasi']; ?></td>
							<td><?php echo $myData['status_approval']; ?></td>
							<td><?php echo $myData['status'] ?></td>
							<?php if ($myData['status_approval'] == 'Belum Approve') { ?>
								<?php if (isset($_SESSION["SES_PETUGAS"])) { ?>
									<td>
										<a type="button" href="?open=Pengadaan-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGADAAN INI ... ?')" class="btn btn-danger btn-sm" title="Hapus Data">
											<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										</a>
										<a type="button" href="?open=Pengadaan-Edit&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-warning btn-sm" title="Edit Data"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
										</a>
									</td>
								<?php } else { ?>
									<td>
										<a type="button" href="?open=Pengadaan-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGADAAN INI ... ?')" class="btn btn-danger btn-sm" title="Hapus Data">
											<i class="fa fa-trash"></i></a>

										<a type="button" href="?open=Approval&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-info btn-sm" title="Approve Data"><i class=" fa fa-check"></i></a>
									</td>
								<?php } ?>
							<?php } else { ?>
								<?php if (isset($_SESSION["SES_PETUGAS"])) { ?>
									<td>
										<?php if ($myData['status'] == "Sudah Diterima") : ?>
											<a type="button" href="?open=Pengadaan-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGADAAN INI ... ?')" class="btn btn-danger btn-sm" title="Hapus Data">
												<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
											</a>
											<a type="button" href="cetak/pengadaan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank" class="btn btn-success btn-sm" title="Cetak Data"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>
											</a>
											<a type="button" href="?open=Pengadaan-SN-Edit&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-primary btn-sm" title="Edit SN">
												<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
											</a>
										<?php else: ?>
											<a type="button" href="?open=Pengadaan-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGADAAN INI ... ?')" class="btn btn-danger btn-sm" title="Hapus Data">
												<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
											</a>
											<a type="button" href="?open=Pengadaan-Approve-Edit&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-warning btn-sm" title="Edit Data"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
											</a>
										<?php endif; ?>
									</td>
								<?php } else { ?>
									<td>
										<a type="button" href="cetak/pengadaan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank" class="btn btn-success btn-sm" title="Cetak Data">
											<span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
									</td>
								<?php } ?>
							<?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>