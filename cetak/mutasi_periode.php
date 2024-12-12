<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Membaca Tanggal Awal (tglAwal) dan Tanggal Akhir (tglAkhir)
$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

$filterSQL = " WHERE ( tgl_penempatan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
?>
<html>
<head>
<title>:: Laporan Mutasi Periode - Inventory Kantor (Aset Barang)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="window.print()">
<h2>LAPORAN MUTASI PER PERIODE</h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="108"><strong>Periode </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="363"><?php echo $tglAwal; ?> <strong>s/d</strong> <?php echo $tglAkhir; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="35" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="72" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>No. Mutasi</strong></td>
    <td width="151" bgcolor="#F5F5F5"><strong>Lokasi Lama </strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>No. Penempatan </strong></td>
    <td width="145" bgcolor="#F5F5F5"><strong>Lokasi Baru </strong></td>
    <td width="168" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
    <td width="76" align="right" bgcolor="#F5F5F5"><strong>Qty Barang</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi mutasi
	$mySql = "SELECT mutasi.*, lokasi.nm_lokasi FROM mutasi 
				LEFT JOIN lokasi ON mutasi.kd_lokasi=lokasi.kd_lokasi 
				ORDER BY mutasi.no_mutasi DESC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode mutasi/ Nomor transaksi
		$noMutasi = $myData['no_mutasi'];

		# Perintah untuk mendapatkan data dari hasil Penempatan Baru
		$noPenempatan	= $myData['no_penempatan'];
		$my2Sql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
					LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
					WHERE penempatan.no_penempatan='$noPenempatan'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		# Menghitung Total barang yang dimutasi setiap nomor transaksi
		$my3Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noPenempatan'";
		$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
		$my3Data = mysql_fetch_array($my3Qry);
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $my2Data['nm_lokasi']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my3Data['total_barang']); ?></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>