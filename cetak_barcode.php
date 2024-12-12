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

	$kategoriSQL = "";
	$cariSQL 	= "";

	# Temporary Variabel form
	$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : '';
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

	$keyWord		= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
	$dataKataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

	# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
	if (isset($_POST['btnTampil'])) {
		# PILIH KATEGORI
		if (trim($_POST['cmbKategori']) == "BLANK") {
			$kategoriSQL = "";
		} else {
			$kategoriSQL = "AND barang.kd_kategori='$dataKategori'";
		}
	} else {
		//Query #1 (all)
		$supplierSQL = "";
		$kategoriSQL = "";
	}

	# UNTUK PAGING (PEMBAGIAN HALAMAN)
	$row = 10;
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
	$pageSql = "SELECT barang.*, kategori.nm_kategori FROM barang_inventaris
				LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
				LEFT JOIN kategori ON  barang.kd_barang=kategori.kd_kategori 
				WHERE barang.jumlah >='1' $kategoriSQL
				GROUP BY barang.kd_barang";
	$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:" . mysql_error());
	$jml	 = mysql_num_rows($pageQry);
	$max	 = ceil($jml / $row);
	?>

	<SCRIPT language="JavaScript">
		function submitform() {
			document.form1.submit();
		}
	</SCRIPT>
	<div class="table-border">
		<h2> LABEL BARANG </h2>

		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
			<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-list">
				<tr>
					<td colspan="3" bgcolor="#F5F5F5"><b>FILTER DATA </b></td>
				</tr>
				<tr>
					<td width="186"><b>Nama Kategori </b></td>
					<td width="5"><b>:</b></td>
					<td width="1007">
						<select name="cmbKategori" onChange="javascript:submitform();" data-live-search="true" class="selectpicker">
							<option value="BLANK"> Pilih Kategori </option>
							<?php
							$dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
							$dataQry = mysql_query($dataSql, $koneksidb) or die("Gagal Query" . mysql_error());
							while ($dataRow = mysql_fetch_array($dataQry)) {
								if ($dataRow['kd_kategori'] == $dataKategori) {
									$cek = " selected";
								} else {
									$cek = "";
								}
								echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
							}
							$sqlData = "";
							?>
						</select>
						<input name="btnTampil" type="submit" value=" Tampilkan " />
					</td>
				</tr>
			</table>
		</form>

		<form action="cetak_barcode_print.php" method="post" name="form2" target="_blank">
			<table id="example1" class="table-list" width="935" border="0" cellspacing="1" cellpadding="2">
				<thead>
					<tr>
						<th width="21"><b>No</b></th>
						<th width="50"><strong>Kode</strong></th>
						<th width="402"><b>Type Barang </b></th>
						<th width="247"><b>Kategori</b></th>
						<th width="50" align="right"><strong>Jumlah</strong></th>
						<th width="52">Satuan</th>
						<th width="35" align="center">Pilih</th>
						<th width="37" align="center"><strong>Aksi</strong></th>
					</tr>
				</thead>
				<tbody>
					<?php
					# MENJALANKAN QUERY , 
					$mySql = "SELECT barang.*, kategori.nm_kategori FROM barang_inventaris
					LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
					LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
					WHERE barang.kd_barang !='' $kategoriSQL
					GROUP BY barang.kd_barang ORDER BY barang.kd_barang ASC";
					$myQry 	= mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
					$nomor  = $hal;
					while ($myData = mysql_fetch_array($myQry)) {
						$nomor++;
						$Kode = $myData['kd_barang'];

						// gradasi warna
						if ($nomor % 2 == 1) {
							$warna = "";
						} else {
							$warna = "#F5F5F5";
						}
					?>
						<tr bgcolor="<?php echo $warna; ?>">
							<td><?php echo $nomor; ?></td>
							<td><?php echo $myData['kd_barang']; ?></td>
							<td><?php echo $myData['nm_barang']; ?></td>
							<td><?php echo $myData['nm_kategori']; ?></td>
							<td align="right"><?php echo $myData['jumlah']; ?></td>
							<td><?php echo $myData['satuan']; ?></td>
							<td align="center"><input name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" /></td>
							<td align="center">
								<a href="?open=Cetak-Barcode-View&Kode=<?php echo $myData['kd_barang']; ?>" target="_blank" class="btn btn-info" title="Detail Data"><i class="fa fa-info"></i></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
				<tr>
					<td colspan="8" align="right"><input name="btnCetak" type="submit" value=" Cetak QR Code " /></td>
				</tr>
			</table>
			<p><strong>* Note:</strong> Centang dulu pada nama barang yang akan dibuat QR Code ( klik <strong>Pilih</strong> ), baru klik tombol <strong>Cetak QR Code</strong></p>
		</form>
	</div>