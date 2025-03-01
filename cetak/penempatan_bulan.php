<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Membuat daftar bulan
$listBulan = array(
	"01" => "Januari", "02" => "Februari", "03" => "Maret",
	"04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
	"08" => "Agustus", "09" => "September", "10" => "Oktober",
	"11" => "November", "12" => "Desember"
);

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$dataUnit = isset($_GET['departemen']) ? $_GET['departemen'] : $_SESSION["SES_UNIT"];

if ($dataBulan and $dataTahun and $dataUnit) {
	if ($dataBulan == "00") {
		// Filter tahun
		$filterSQL	= "WHERE LEFT(tgl_penempatan,4)='$dataTahun' AND departemen.nm_departemen='$dataUnit'";

		$infoBulan	= "";
	} else {
		// Filter bulan dan tahun
		$filterSQL = "WHERE MID(tgl_penempatan,6,2)='$dataBulan' AND LEFT(tgl_penempatan,4)='$dataTahun' AND departemen.nm_departemen='$dataUnit'";

		$infoBulan	= $listBulan[$dataBulan] . ", ";
	}
} elseif ($dataBulan and $dataTahun) {
	if ($dataBulan == "00") {
		// Filter tahun
		$filterSQL	= "WHERE LEFT(tgl_penempatan,4)='$dataTahun'";

		$infoBulan	= "";
	} else {
		// Filter bulan dan tahun
		$filterSQL = "WHERE MID(tgl_penempatan,6,2)='$dataBulan' AND LEFT(tgl_penempatan,4)='$dataTahun'";

		$infoBulan	= $listBulan[$dataBulan] . ", ";
	}
} else {
	$filterSQL = "";
}
?>
<html>

<head>
	<title>:: Laporan Penempatan per Bulan - Inventory Kantor (Aset Barang)</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print()">
	<h2>LAPORAN PENEMPATAN PER BULAN </h2>
	<table width="500" border="0" class="table-list">
		<tr>
			<td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
		</tr>
		<tr>
			<td width="132"><strong> Bulan Penempatan </strong></td>
			<td width="5"><strong>:</strong></td>
			<td width="349"><?php echo $infoBulan . $dataTahun; ?></td>
		</tr>
	</table>
	<br />
	<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td width="15" bgcolor="#F5F5F5"><strong>No</strong></td>
			<td width="50" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
			<td width="50" bgcolor="#F5F5F5"><strong>No. Penempatan</strong></td>
			<td width="175" bgcolor="#F5F5F5"><strong>Type Barang</strong></td>
			<td width="100" bgcolor="#F5F5F5"><strong>Departemen</strong></td>
			<td width="100" bgcolor="#F5F5F5"><strong>Lokasi</strong></td>
			<td width="80" align="center" bgcolor="#F5F5F5"><strong>Qty Barang</strong></td>
		</tr>
		<?php
		// Skrip untuk menampilkan data Transaksi Penempatan, dilengkapi informasi Lokasi
		$mySql = "SELECT penempatan.*, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang FROM penempatan 
		LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
		LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
		LEFT JOIN penempatan_item ON penempatan.no_penempatan=penempatan_item.no_penempatan
		LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
		LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
		$filterSQL
		ORDER BY penempatan.no_penempatan DESC";
		$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
		$nomor  = 0;
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;

			# Membaca Kode penempatan/ Nomor transaksi
			$noNota = $myData['no_penempatan'];

			# Menghitung Total penempatan (belanja) setiap nomor transaksi
			$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noNota'";
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
			$my2Data = mysql_fetch_array($my2Qry);
		?>
			<tr>
				<td><?php echo $nomor; ?></td>
				<td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
				<td><?php echo $myData['no_penempatan']; ?></td>
				<td><?php echo $myData['nm_barang']; ?></td>
				<td><?php echo $myData['nm_departemen']; ?></td>
				<td><?php echo $myData['nm_lokasi']; ?></td>
				<td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
			</tr>
		<?php } ?>
	</table>
</body>

</html>