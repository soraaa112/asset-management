<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		table {
			border-collapse: collapse;
			border-spacing: 0;
			width: 100%;
			/* border: 1px solid #ddd; */
		}

		th,
		td {
			text-align: left;
			padding: 8px;
		}

		.right {
			text-align: right;
			padding: 8px;
		}


		/* tr:nth-child(even){background-color: #f2f2f2} */
	</style>
</head>

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

	if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
		# Pegawai terpilih
		$kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : $_SESSION['SES_UNIT'];
		$kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;
	} else {
		$kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
		$kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;
	}

	$dataBarang	= isset($_GET['kodeBarang']) ? $_GET['kodeBarang'] : 'Semua';
	$dataBarang	= isset($_POST['cmbBarang']) ? $_POST['cmbBarang'] : $dataBarang;
	$status = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
	$status = isset($_POST['cmbStatusKembali']) ? $_POST['cmbStatusKembali'] : $status;


	# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
	if (isset($_POST['btnCari'])) {
		$txtKataKunci  = trim($_POST['txtKataKunci']);

		// Pencarian Multi String (beberapa kata)
		$keyWord     = explode(" ", $txtKataKunci);
		$cariSQL    = " WHERE peminjaman.kd_pegawai ='$txtKataKunci' OR pegawai.nm_pegawai LIKE '%$txtKataKunci%' ";
		// if (count($keyWord) > 1) {
		// 	foreach ($keyWord as $kata) {
		// 		$cariSQL  .= " OR pegawai.nm_pegawai LIKE'%$kata%'";
		// 	}
		// }

		if (trim($_POST['cmbDepartemen']) == "Semua") {
			if (($_POST['cmbBarang']) == "Semua") {
				if ($_POST['cmbStatusKembali'] ==  "Semua") {
					//Query #1 (all)
					$filterSQL   = $cariSQL;
				} else {
					$filterSQL   = $cariSQL . "AND peminjaman.status_kembali = '$status'";
				}
			} else {
				if ($_POST['cmbStatusKembali'] ==  "Semua") {
					//Query #1 (all)
					$filterSQL   = $cariSQL . "AND barang_inventaris.kd_barang='$dataBarang'";
				} else {
					$filterSQL   = $cariSQL . "AND barang_inventaris.kd_barang='$dataBarang' AND peminjaman.status_kembali = '$status'";
				}
			}
		} else {
			if (($_POST['cmbBarang']) == "Semua") {
				if ($_POST['cmbStatusKembali'] ==  "Semua") {
					//Query #1 (all)
					$filterSQL   = $cariSQL . "AND pegawai.kd_departemen ='$kodeDepartemen'";
				} else {
					$filterSQL   = $cariSQL . "AND peminjaman.status_kembali = '$status'
				AND pegawai.kd_departemen ='$kodeDepartemen'";
				}
			} else {
				if ($_POST['cmbStatusKembali'] ==  "Semua") {
					//Query #1 (all)
					$filterSQL   = $cariSQL . "AND pegawai.kd_departemen ='$kodeDepartemen' 
				AND barang_inventaris.kd_barang='$dataBarang'";
				} else {
					$filterSQL   = $cariSQL . "AND pegawai.kd_departemen ='$kodeDepartemen' 
				AND peminjaman.status_kembali = '$status'
				AND barang_inventaris.kd_barang='$dataBarang'";
				}
			}
		}
	} else {
		//Query #1 (all)
		$filterSQL   = "";
	}

	# Simpan Variabel TMP
	$dataKataKunci = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';
	$dataStatus = isset($_POST['cmbStatusKembali']) ? $_POST['cmbStatusKembali'] : '';
	$dataTypeBarang		= isset($_POST['cmbBarang']) ? $_POST['cmbBarang'] : '';

	# UNTUK PAGING (PEMBAGIAN HALAMAN)
	$row = 10;
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
	if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
		if (isset($_POST['btnCari'])) {
			$pageSql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman
			LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
			LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
			LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
			LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
			$filterSQL AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' GROUP BY peminjaman.no_peminjaman";
		} else {
			$pageSql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman
			LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
			LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
			LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
			LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
			$filterSQL WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]' GROUP BY peminjaman.no_peminjaman";
		}
	} else {
		$pageSql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman
			LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
			LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
			LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
			LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
			$filterSQL GROUP BY peminjaman.no_peminjaman";
	}
	$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
	$jml	 = mysql_num_rows($pageQry);
	$max	 = ceil($jml / $row);
	?>
	<div class="table-border">
		<div style="overflow-x:auto;">
			<h2>LAPORAN DATA PEMINJAMAN PER PEGAWAI </h2>
			<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
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
						</td>
					</tr>
					<tr>
						<td><strong>Type</strong></td>
						<td><strong>:</strong></td>
						<td><b>
								<select name="cmbBarang" data-live-search="true" class="selectpicker">
									<option value="Semua">Semua</option>
									<?php
									$mySql = "SELECT * FROM barang ORDER BY kd_barang";
									$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
									while ($myData = mysql_fetch_array($myQry)) {
										if ($dataTypeBarang == $myData['kd_barang']) {
											$cek = " selected";
										} else {
											$cek = "";
										}
										echo "<option value='$myData[kd_barang]' $cek> $myData[nm_barang]</option>";
									}
									?>
								</select>
						</td>
					</tr>
					<tr>
						<td width="134"><strong> Status </strong></td>
						<td width="5"><strong>:</strong></td>
						<td width="741">
							<select name="cmbStatusKembali" data-live-search="true" class="selectpicker">
								<option value="Semua">Semua</option>
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
						</td>
					</tr>
					<tr>
						<td><strong>Cari Pegawai </strong></td>
						<td><strong>:</strong></td>
						<td><input id="txtKataKunci" name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="45" maxlength="100" autocomplete="off" autofocus />
							<input name="btnCari" type="submit" value="Cari " />
						</td>
					</tr>
				</table>
			</form>
			<form action="cetak/cetak_peminjaman.php?kodeDepartemen=<?php echo $kodeDepartemen; ?>&kodeBarang=<?php echo $dataBarang ?>&statusKembali=<?php echo $status ?>&txtKataKunci=<?php echo $dataKataKunci ?>" method="post" name="form2" target="_blank">
				<table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
					<thead>
						<tr>
							<td width="15" align="center" bgcolor="#CCCCCC"><input type="checkbox" name="cbKode[]" id="cbkode-all"></td>
							<td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
							<td width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
							<td width="110" bgcolor="#CCCCCC"><strong>No. Peminjaman</strong></td>
							<td width="229" bgcolor="#CCCCCC"><strong>Type barang</strong></td>
							<td width="120" bgcolor="#CCCCCC"><strong>Pegawai/ Peminjam </strong></td>
							<td width="100" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
							<td width="50" bgcolor="#CCCCCC"><strong>Status</strong></td>
							<td width="50" align="center" bgcolor="#CCCCCC">
								<strong>Qty Barang</strong>
							</td>
						</tr>
					</thead>
					<tbody>
						<?php
						// Skrip untuk menampilkan data Transaksi Peminjaman, dilengkapi informasi Nama Pegawai
						// Filter data berdasarkan Nama Pegawai dan Tahun Transaksi
						if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
							if (isset($_POST['btnCari'])) {
								$mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
						LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
						LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
						LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
						LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
						LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
						$filterSQL
						AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
						GROUP BY peminjaman.no_peminjaman ORDER BY peminjaman.no_peminjaman ASC ";
							} else {
								$mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
						LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
						LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
						LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
						LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
						LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
						$filterSQL
						WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'
						GROUP BY peminjaman.no_peminjaman ORDER BY peminjaman.no_peminjaman ASC ";
							}
						} else {
							$mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
					LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
					LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
					LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
					LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
					LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
					$filterSQL
					GROUP BY peminjaman.no_peminjaman ORDER BY peminjaman.no_peminjaman ASC ";
						}
						$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
						$nomor = $hal;
						while ($myData = mysql_fetch_array($myQry)) {
							$nomor++;

							// Membaca Kode peminjaman/ Nomor transaksi
							$noNota = $myData['no_peminjaman'];

							// Menghitung Total barang yang dipinjam
							$my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
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
								<td align="center">
									<input name="cbKode[]" class="check-item" type="checkbox" id="cbKode" value="<?php echo $noNota; ?>" />
								</td>
								<td align="center"><?php echo $nomor; ?>.</td>
								<td><?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?></td>
								<td><?php echo $myData['no_peminjaman']; ?></td>
								<td><?php echo $myData['nm_barang']; ?></td>
								<td><?php echo $myData['nm_pegawai']; ?></td>
								<td><?php echo $myData['nm_departemen']; ?></td>
								<td><?php echo $myData['status_kembali']; ?></td>
								<td align="center">
									<center><?php echo $my2Data['total_barang']; ?></center>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<center>
					<button type="submit" name="btnPdf" class="btn btn-danger" title="Cetak PDF"><i class="fa fa-print"> PDF</i>
					</button>
					<button type="submit" name="btnExcel" class="btn btn-success" title="Cetak Excel"><i class="fa fa-print"> Excel</i>
					</button>
				</center>
			</form>
		</div>
	</div>
	<script>
		$(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
			$("#cbkode-all").click(function() { // Ketika user men-cek checkbox all
				if ($(this).is(":checked")) // Jika checkbox all diceklis        
					$(".check-item").prop("checked", true); // ceklis semua checkbox siswa dengan class "check-item"      
				else // Jika checkbox all tidak diceklis        
					$(".check-item").prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"    
			});
		});
	</script>