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

	// Set variabel SQL
	$SQL = "";
	$SQLPage = "";

	# BACA VARIABEL KATEGORI
	$kodeKategori = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
	$kodeKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

	$kodeStatusBarang = isset($_GET['statusBarang']) ? $_GET['statusBarang'] : 'Kosong';
	$kodeStatusBarang = isset($_POST['cmbStatusBarang']) ? $_POST['cmbStatusBarang'] : $kodeStatusBarang;

	$kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
	$kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;

	# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
	if (isset($_POST['btnCari'])) {
		$txtKataKunci  = trim($_POST['txtKataKunci']);

		// Pencarian Multi String (beberapa kata)
		$keyWord     = explode(" ", $txtKataKunci);
		$cariSQL    = " AND BI.kd_inventaris='$txtKataKunci' OR b.nm_barang LIKE '%$txtKataKunci%' ";

		if ($_POST['cmbDepartemen'] == "Semua") {
			if ($_POST['cmbStatusBarang'] == "Kosong") {
				if (trim($_POST['cmbKategori']) == "Semua") {
					//Query #1 (all)
					$filterSQL 	= $cariSQL;
				} else {
					//Query #2 (filter)
					$filterSQL 	= "AND b.kd_kategori ='$kodeKategori'";
				}
			} else {
				if (trim($_POST['cmbKategori']) == "Semua") {
					//Query #1 (all)
					$filterSQL 	= "AND BI.status_barang = '$kodeStatusBarang'";
				} else {
					//Query #2 (filter)
					$filterSQL 	= "AND BI.status_barang = '$kodeStatusBarang' AND b.kd_kategori ='$kodeKategori'";
				}
			}
		} else {
			if ($_POST['cmbStatusBarang'] == "Kosong") {
				if (trim($_POST['cmbKategori']) == "Semua") {
					//Query #1 (all)
					$filterSQL 	= "AND D.kd_departemen = '$kodeDepartemen'";
				} else {
					//Query #2 (filter)
					$filterSQL 	= "AND b.kd_kategori ='$kodeKategori' AND D.kd_departemen = '$kodeDepartemen'";
				}
			} else {
				if (trim($_POST['cmbKategori']) == "Semua") {
					//Query #1 (all)
					$filterSQL 	= "AND BI.status_barang = '$kodeStatusBarang' AND D.kd_departemen = '$kodeDepartemen'";
				} else {
					//Query #2 (filter)
					$filterSQL 	= "AND BI.status_barang = '$kodeStatusBarang' AND b.kd_kategori ='$kodeKategori' AND D.kd_departemen = '$kodeDepartemen'";
				}
			}
		}
	} else {
		//Query #1 (all)
		$filterSQL 	= "";
	}

	# UNTUK PAGING (PEMBAGIAN HALAMAN)
	$row = 10;
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
	$pageSql = "SELECT z.kd_inventaris, z.kd_barang, z.nm_barang, z.status_barang, z.nm_petugas, z.nm_departemen FROM
    (SELECT BI.kd_inventaris, b.kd_barang, b.nm_barang, BI.status_barang, PT.nm_petugas, D.nm_departemen FROM 	barang_inventaris BI
				LEFT JOIN barang b ON BI.kd_barang = b.kd_barang
				LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
				LEFT JOIN pengadaan PE ON BI.no_pengadaan = PE.no_pengadaan
				LEFT JOIN petugas PT ON PE.kd_petugas = PT.kd_petugas
				LEFT JOIN departemen D ON PT.kd_departemen = D.kd_departemen
				WHERE BI.status_barang = 'Tersedia' $filterSQL GROUP BY BI.kd_inventaris
				UNION
				SELECT BI.kd_inventaris, b.kd_barang, b.nm_barang, BI.status_barang, L.nm_lokasi, D.nm_departemen FROM barang_inventaris BI
				LEFT JOIN barang b ON BI.kd_barang = b.kd_barang
				LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
				LEFT JOIN penempatan_item PI ON BI.kd_inventaris = PI.kd_inventaris
				LEFT JOIN penempatan P ON PI.no_penempatan = P.no_penempatan
				LEFT JOIN lokasi L ON P.kd_lokasi = L.kd_lokasi
				LEFT JOIN departemen D ON L.kd_departemen = D.kd_departemen
				WHERE PI.status_aktif = 'Yes' $filterSQL GROUP BY BI.kd_inventaris
				UNION
				SELECT BI.kd_inventaris, b.kd_barang, b.nm_barang, BI.status_barang, PG.nm_pegawai, D.nm_departemen FROM barang_inventaris BI
				LEFT JOIN barang b ON BI.kd_barang = b.kd_barang
				LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
				LEFT JOIN peminjaman_item PIJ ON BI.kd_inventaris = PIJ.kd_inventaris
				LEFT JOIN peminjaman PJ ON PIJ.no_peminjaman = PJ.no_peminjaman
				LEFT JOIN pegawai PG ON PJ.kd_pegawai = PG.kd_pegawai
				LEFT JOIN departemen D ON PG.kd_departemen = D.kd_departemen
				WHERE PJ.status_kembali = 'Pinjam' $filterSQL GROUP BY BI.kd_inventaris) z GROUP BY z.kd_inventaris";
	$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:" . mysql_error());
	$jml	 = mysql_num_rows($pageQry);
	$max	 = ceil($jml / $row);
	?>
	<div class="table-border">
		<form style='padding-top:0px !important' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
			<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
				<h2><b>PENCARIAN TYPE BARANG </b></h2>
				<tr>
					<td colspan="2">
						<table width="100%" border="0" class="table-list">
							<tr>
								<td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
							</tr>
							<tr>
								<td width="134"><strong> Departemen </strong></td>
								<td width="5"><strong>:</strong></td>
								<td width="741">
									<select name="cmbDepartemen" data-live-search="true" class="selectpicker">
										<option value="Semua"> Pilih Departemen </option>
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
								</td>
							</tr>
							<tr>
								<td width="134"><strong> Status Barang </strong></td>
								<td width="5"><strong>:</strong></td>
								<td width="741">
									<select name="cmbStatusBarang" data-live-search="true" class="selectpicker">
										<option value="Kosong"> Pilih Status </option>
										<?php
										foreach ($statusBarang as $nilai) {
											if ($kodeStatusBarang == $nilai) {
												$cek = " selected";
											} else {
												$cek = "";
											}
											echo "<option value='$nilai' $cek>$nilai</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td><strong>Cari Barang </strong></td>
								<td><strong>:</strong></td>
								<td><input name="txtKataKunci" type="text" size="26" maxlength="100" autofocus />
									<input name="btnCari" type="submit" value=" Tampilkan " />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>

		<table id="example1" class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
			<thead>
				<tr>
					<th width="20"><b>No</b></th>
					<th width="100"><strong>Kode Label</strong></th>
					<th width="200"><b>Type Barang </b></th>
					<th width="200">Nama Pegawai / Lokasi</th>
					<th width="200"><strong>Departemen</strong></th>
					<th width="35"> <b>Aksi</b> </th>
				</tr>
			</thead>
			<tbody>
				<?php
				# Skrip menampilkan data Barang dari tabel Barang Inventaris
				$mySql 	= "SELECT z.kd_inventaris, z.kd_barang, z.nm_barang, z.status_barang, z.nm_petugas, z.nm_departemen FROM
                (SELECT BI.kd_inventaris, b.kd_barang, b.nm_barang, BI.status_barang, PT.nm_petugas, D.nm_departemen FROM barang_inventaris BI
				LEFT JOIN barang b ON BI.kd_barang = b.kd_barang
				LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
				LEFT JOIN pengadaan PE ON BI.no_pengadaan = PE.no_pengadaan
				LEFT JOIN petugas PT ON PE.kd_petugas = PT.kd_petugas
				LEFT JOIN departemen D ON PT.kd_departemen = D.kd_departemen
				WHERE BI.status_barang = 'Tersedia' $filterSQL GROUP BY BI.kd_inventaris
				UNION
				SELECT BI.kd_inventaris, b.kd_barang, b.nm_barang, BI.status_barang, L.nm_lokasi, D.nm_departemen FROM barang_inventaris BI
				LEFT JOIN barang b ON BI.kd_barang = b.kd_barang
				LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
				LEFT JOIN penempatan_item PI ON BI.kd_inventaris = PI.kd_inventaris
				LEFT JOIN penempatan P ON PI.no_penempatan = P.no_penempatan
				LEFT JOIN lokasi L ON P.kd_lokasi = L.kd_lokasi
				LEFT JOIN departemen D ON L.kd_departemen = D.kd_departemen
				WHERE PI.status_aktif = 'Yes' $filterSQL GROUP BY BI.kd_inventaris
				UNION
				SELECT BI.kd_inventaris, b.kd_barang, b.nm_barang, BI.status_barang, PG.nm_pegawai, D.nm_departemen FROM barang_inventaris BI
				LEFT JOIN barang b ON BI.kd_barang = b.kd_barang
				LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
				LEFT JOIN peminjaman_item PIJ ON BI.kd_inventaris = PIJ.kd_inventaris
				LEFT JOIN peminjaman PJ ON PIJ.no_peminjaman = PJ.no_peminjaman
				LEFT JOIN pegawai PG ON PJ.kd_pegawai = PG.kd_pegawai
				LEFT JOIN departemen D ON PG.kd_departemen = D.kd_departemen
				WHERE PJ.status_kembali = 'Pinjam' $filterSQL GROUP BY BI.kd_inventaris) z GROUP BY z.kd_inventaris";
				$myQry 	= mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
				$nomor  = $hal;
				while ($key = mysql_fetch_assoc($myQry)) {
					$nomor++;
					$Kode = $key['kd_inventaris'];

					if ($key['status_barang'] == "Tersedia") {
						$infoLokasi = "-";
						$infoDepartemen = $key['nm_departemen'];
					}

					// Mencari lokasi Penempatan Barang
					if ($key['status_barang'] == "Ditempatkan") {
						$infoLokasi = $key['nm_petugas'];
						$infoDepartemen = $key['nm_departemen'];
					}

					// Mencari Siapa Penempatan Barang
					if ($key['status_barang'] == "Dipinjam") {
						$infoLokasi = $key['nm_petugas'];
						$infoDepartemen = $key['nm_departemen'];
					}

					// gradasi warna
					if ($nomor % 2 == 1) {
						$warna = "";
					} else {
						$warna = "#F5F5F5";
					}
				?>
					<tr bgcolor="<?php echo $warna; ?>">
						<td><?php echo $nomor; ?>.</td>
						<td><?php echo $key['kd_inventaris']; ?></td>
						<td><?php echo $key['nm_barang']; ?></td>
						<td><?php echo $infoLokasi; ?></td>
						<td><?php echo $infoDepartemen; ?></td>
						<td><a href="?open=Barang-View&Kode=<?php echo $Kode; ?>&statusBarang=<?php echo $kodeStatusBarang; ?>" target="_blank"><button class="btn btn-primary" title="Lihat Data"><i class="fa fa-search"></i>
								</button></a></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>