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

	# BACA VARIABEL KATEGORI
	$kodeKategori = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
	$kodeKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

	# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
	if (isset($_POST['btnCari'])) {
		if (trim($_POST['cmbKategori']) == "Semua") {
			//Query #1 (all)
			$filterSQL   = "WHERE penempatan_item.status_aktif='Yes'";
		} else {
			//Query #2 (filter)
			$filterSQL   = "WHERE barang.kd_kategori ='$kodeKategori' AND penempatan_item.status_aktif='Yes'";
		}
	} else {
		//Query #1 (all)
		$filterSQL   = "WHERE penempatan_item.status_aktif='Yes'";
	}

	# UNTUK PAGING (PEMBAGIAN HALAMAN)
	$row = 10;
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
	$pageSql = "SELECT penempatan_item.* FROM penempatan
	LEFT JOIN penempatan_item ON penempatan.no_penempatan = penempatan_item.no_penempatan
	LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris = barang_inventaris.kd_inventaris
	LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
	LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
	$filterSQL GROUP BY penempatan_item.no_penempatan ORDER BY penempatan_item.no_penempatan ASC";
	$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
	$jml	 = mysql_num_rows($pageQry);
	$max	 = ceil($jml / $row);
	?>
	<div style="overflow-x:auto;">
		<div class="table-border">
			<h2>DAFTAR PENEMPATAN <a href="?open=Penempatan-Baru" target="_self"><img style='padding-right:0px !important' src="images/btn_add_data.png" border="0" /></a></h2>
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
						<td width="25" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
						<td width="60" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
						<td width="100" bgcolor="#CCCCCC"><strong>No. Penempatan</strong></td>
						<td width="200" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
						<td width="150" bgcolor="#CCCCCC"><strong>Departemen &amp; Lokasi</strong></td>
						<td width="50" align="center" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
						<td width="100" align="center" bgcolor="#CCCCCC"><strong>Foto Barang</strong></td>
						<td width="70" bgcolor="#CCCCCC">
							<center><strong>Aksi</strong></center>
						</td>
					</tr>
				</thead>
				<tbody>
					<?php
					# Perintah untuk menampilkan data Transaksi penempatan, dilengkapi informasi Lokasi dan Departemen
					$mySql = "SELECT penempatan_item.*, penempatan.*, departemen.nm_departemen, lokasi.nm_lokasi, barang.nm_barang FROM penempatan_item 
					LEFT JOIN penempatan ON penempatan_item.no_penempatan=penempatan.no_penempatan
					LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris = barang_inventaris.kd_inventaris
					LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
					LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori 
					LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
					LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen
					$filterSQL
					GROUP BY penempatan_item.no_penempatan ORDER BY penempatan_item.no_penempatan DESC";
					$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
					$nomor = $hal;
					while ($myData = mysql_fetch_array($myQry)) {
						$nomor++;

						# Membaca Kode penempatan/ Nomor transaksi
						$Kode = $myData['no_penempatan'];

						# Menghitung Total penempatan (belanja) setiap nomor transaksi
						$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$Kode'";
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
							<td align="center"><?php echo $nomor; ?></td>
							<td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
							<td><?php echo $myData['no_penempatan']; ?></td>
							<td><?php echo $myData['nm_barang']; ?></td>
							<td><?php echo $myData['nm_departemen'] . ", " . $myData['nm_lokasi']; ?></td>
							<td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
							<td align="center"><?php
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
							<td align="center">
								<a type="button" href="?open=Penempatan-Hapus&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENEMPATAN INI ... ?')" class="btn btn-danger" title="Hapus Data">
									<i class="fa fa-trash"></i>
								</a>
								&nbsp;
								<a type="button" href="?open=Penempatan-Detail&Kode=<?php echo $Kode; ?>" target="_blank" class="btn btn-info" title="Detail Data">
									<i class="fa fa-info"></i></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	