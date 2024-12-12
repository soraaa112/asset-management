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

	$filterSQL  = "";
	$SQL = "";
	$SQLPage = "";
	
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

	$kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
	$kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;

	$status = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
	$status = isset($_POST['cmbStatusKembali']) ? $_POST['cmbStatusKembali'] : $status;


	# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
	if (isset($_POST['btnCari'])) {
		if (trim($_POST['cmbDepartemen']) == "Semua") {
			if ($_POST['cmbStatusKembali'] ==  "Semua") {
				//Query #1 (all)
				$filterSQL   = "";
			} else {
				$filterSQL   = "AND peminjaman.status_kembali = '$status'";
			}
		} else {
			if ($_POST['cmbStatusKembali'] ==  "Semua") {
				//Query #1 (all)
				$filterSQL   = "AND pegawai.kd_departemen ='$kodeDepartemen'";
			} else {
				$filterSQL   = "AND pegawai.kd_departemen ='$kodeDepartemen' AND peminjaman.status_kembali = '$status'";
			}
		}
	} else {
		//Query #1 (all)
		$filterSQL   = "";
	}

	# Simpan Variabel TMP
	$dataKataKunci = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';
	$dataStatus = isset($_POST['cmbStatusKembali']) ? $_POST['cmbStatusKembali'] : '';


	# UNTUK PAGING (PEMBAGIAN HALAMAN)
	$row = 10;
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
	$openSql = "SELECT peminjaman.no_peminjaman, peminjaman.tgl_peminjaman, peminjaman.status_kembali, pegawai.nm_pegawai, departemen.nm_departemen, peminjaman.form_bast
	FROM peminjaman, pegawai, departemen
	WHERE peminjaman.kd_pegawai = pegawai.kd_pegawai AND pegawai.kd_departemen = departemen.kd_departemen $filterSQL";
	$openQry = mysql_query($openSql, $koneksidb) or die("error paging: " . mysql_error());
	$jml	 = mysql_num_rows($openQry);
	$max	 = ceil($jml / $row);
	?>
	<div class="table-border">
		<div style="overflow-x:auto;">
			<h2>DAFTAR PEMINJAMAN <a href="?open=Peminjaman-Baru" target="_self"><img style='padding-right:0px !important' src="images/btn_add_data.png" border="0" /></a></h2>
			<form style='padding-top:0px !important' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
				<table width="900" border="0" class="table-list">
					<tr>
						<td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
					</tr>
					<tr>
						<td width="134"><strong> Departemen </strong></td>
						<td width="5"><strong>:</strong></td>
						<td width="741">
							<?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) { ?>
								<select name="cmbDepartemen" data-live-search="true" class="selectpicker">
									<?php
									$mySql = "SELECT * FROM departemen WHERE nm_departemen='$_SESSION[SES_UNIT]' ORDER BY kd_departemen";
									$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
									while ($myData = mysql_fetch_array($myQry)) {
										if ($kodeDepartemen == $myData['kd_departemen']) {
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
								<select name="cmbDepartemen" data-live-search="true" class="selectpicker">
									<option value="Semua">Semua</option>
									<?php
									$mySql = "SELECT * FROM departemen ORDER BY kd_departemen";
									$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
									while ($myData = mysql_fetch_array($myQry)) {
										if ($kodeDepartemen == $myData['kd_departemen']) {
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
					</tr>
					<tr>
						<td width="134"><strong> Status </strong></td>
						<td width="5"><strong>:</strong></td>
						<td width="741">
							<select name="cmbStatusKembali" data-live-search="true" class="selectpicker">
								<option value="Semua"> Pilih Status </option>
								<?php
								foreach ($statusKembali as $nilai) {
									if ($dataStatus == $nilai) {
										$cek = " selected";
									} else {
										$cek = "";
									}
									echo "<option value='$nilai' $cek>$nilai</option>";
								}
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
						<td width="27" bgcolor="#CCCCCC"><strong>No</strong></td>
						<td width="81" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
						<td width="193" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
						<td width="186" bgcolor="#CCCCCC"><strong>Pegawai</strong></td>
						<td width="100" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
						<td width="71" align="center" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
						<td width="61" bgcolor="#CCCCCC"><strong>Status</strong></td>
						<td width="100" bgcolor="#CCCCCC"><strong>Form BAST</strong></td>
						<td width="120" bgcolor="#CCCCCC">
							<center><strong>Aksi</strong></center>
						</td>
					</tr>
				</thead>
				<tbody>
					<?php
					// Perintah untuk menampilkan Data Transaksi Peminjaman, dilengkapi informasi Pegawai, dan filter Bulan/Tahun
					$mySql = "SELECT peminjaman.no_peminjaman, peminjaman.tgl_peminjaman, peminjaman.status_kembali, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang, peminjaman.form_bast
					FROM peminjaman, peminjaman_item, barang_inventaris, barang, pegawai, departemen
					WHERE peminjaman.no_peminjaman=peminjaman_item.no_peminjaman AND peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris AND barang_inventaris.kd_barang=barang.kd_barang AND peminjaman.kd_pegawai=pegawai.kd_pegawai AND pegawai.kd_departemen=departemen.kd_departemen $filterSQL
					GROUP BY peminjaman.no_peminjaman ORDER BY peminjaman.no_peminjaman DESC";
					$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
					$nomor = $hal;
					while ($myData = mysql_fetch_array($myQry)) {
						$nomor++;

						# Membaca Kode peminjaman/ Nomor transaksi
						$Kode 	= $myData['no_peminjaman'];
						$barang = $myData['kd_inventaris'];

						# Menghitung Total barang yang dipinjam setiap nomor transaksi
						$my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$Kode'";
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
							<td><?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?></td>
							<td><?php echo $myData['nm_barang']; ?></td>
							<td><?php echo $myData['nm_pegawai']; ?></td>
							<td><?php echo $myData['nm_departemen']; ?></td>
							<td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
							<td><?php echo $myData['status_kembali']; ?></td>
							<td><?php
								$ex = explode(';', $myData['form_bast']);
								$no = 1;
								for ($i = 0; $i < count($ex); $i++) {
									if ($ex[$i] != '') {
										echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'>" . $ex[$i] . "</a>, ";
									}
									$no++;
								}
								?>
							</td>
							<?php if ($myData['status_kembali'] == "Pinjam") : ?>
								<!--<td width="46" align="center">-->
								<!--	<a type="button" href="?open=Peminjaman-Edit&Kode=<?php echo $Kode; ?>" class="btn btn-warning" target="_self" title="Edit Data">-->
								<!--		<i class="fa fa-pencil"></i>-->
								<!--	</a>-->
								<!--</td>-->
								<td align="left">
									<a type="button" href="?open=Peminjaman-Hapus&Kode=<?php echo $Kode; ?>" class="btn btn-danger" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PEMINJAMAN INI ... ?')" title="Hapus Data">
										<i class="fa fa-trash"></i>
									</a>
									<?php if ($myData['status_kembali'] == "Pinjam") { ?>
										<a type="button" href="?open=Pengembalian&Kode=<?php echo $Kode; ?>" class="btn btn-info" target="_self" title="Pengembalian">
											<i class="fa fa-rotate-left"></i></a>
									<?php } else {
										echo "Kembali";
									} ?>
								</td>
							<?php else : ?>
								<!--<td align="center">-->
								<!--	<a type="button" href="?open=Peminjaman-Edit&Kode=<?php echo $Kode; ?>" class="btn btn-warning" target="_self" title="Edit Data">-->
								<!--		<i class="fa fa-pencil"></i>-->
								<!--	</a>-->
								<!--</td>-->
								<td align="left">
									<a type="button" href="?open=Peminjaman-Hapus&Kode=<?php echo $Kode; ?>" class="btn btn-danger" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PEMINJAMAN INI ... ?')" title="Hapus Data">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							<?php endif; ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>