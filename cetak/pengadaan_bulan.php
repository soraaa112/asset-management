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
if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
	$dataUnit = isset($_GET['departemen']) ? $_GET['departemen'] : $_SESSION["SES_UNIT"];
}

if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
	if ($dataBulan and $dataTahun and $dataUnit) {
		if ($dataBulan == "00") {
			// Filter tahun
			$filterSQL	= "WHERE LEFT(tgl_pengadaan,4)='$dataTahun' AND departemen.nm_departemen='$dataUnit'";

			$infoBulan	= "";
		} else {
			// Filter bulan dan tahun
			$filterSQL = "WHERE MID(tgl_pengadaan,6,2)='$dataBulan' AND LEFT(tgl_pengadaan,4)='$dataTahun' AND departemen.nm_departemen='$dataUnit'";

			$infoBulan	= $listBulan[$dataBulan] . ", ";
		}
	}
} else {
	if ($dataBulan and $dataTahun) {
		if ($dataBulan == "00") {
			// Filter tahun
			$filterSQL	= "WHERE LEFT(tgl_pengadaan,4)='$dataTahun'";

			$infoBulan	= "";
		} else {
			// Filter bulan dan tahun
			$filterSQL = "WHERE MID(tgl_pengadaan,6,2)='$dataBulan' AND LEFT(tgl_pengadaan,4)='$dataTahun'";

			$infoBulan	= $listBulan[$dataBulan] . ", ";
		}
	} else {
		$filterSQL = "";
	}
}

?>
<html>

<head>
	<title>:: Laporan Pengadaan per Bulan - Inventory Kantor (Aset Barang)</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print()">
	<h2>LAPORAN PENGADAAN PER BULAN </h2>
	<table width="500" border="0" class="table-list">
		<tr>
			<td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
		</tr>
		<tr>
			<td width="132"><strong> Bulan Pengadaan </strong></td>
			<td width="5"><strong>:</strong></td>
			<td width="349"><?php echo $infoBulan . $dataTahun; ?></td>
		</tr>
	</table>
	<br />
	<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td width="21" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
			<td width="80" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
			<td width="120" bgcolor="#CCCCCC"><strong>No. Pengadaan</strong></td>
			<td width="170" bgcolor="#CCCCCC"><strong>Nama Petugas</strong></td>
			<td width="290" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
			<td width="201" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
			<td width="40" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
			<td width="90" align="right" bgcolor="#CCCCCC"><strong>Harga</strong></td>
			<td width="90" align="right" bgcolor="#CCCCCC"><strong>Total (Rp) </strong></td>
		</tr>
		<?php
		// Definisikan variabel angka
		$totalBarang = 0;
		$totalBelanja = 0;

		# Skrip untuk menampilkan Data Trans Pengadaan, dilengkapi informasi Supplier dari tabel relasi
		$mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen, barang.nm_barang, petugas.nm_petugas FROM pengadaan 
		LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
		LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
		LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
		LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
		LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
		$filterSQL
		ORDER BY pengadaan.no_pengadaan ASC";
		$myQry = mysql_query($mySql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
		$nomor  = 0;
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;

			# Membaca Kode pengadaan/ Nomor transaksi
			$Kode = $myData['no_pengadaan'];

			# Menghitung Total pengadaan (belanja) setiap nomor transaksi
			$my2Sql = "SELECT SUM(jumlah) AS total_barang,  
						  SUM(harga_beli * jumlah) AS total_belanja, harga_beli 
				   FROM pengadaan_item WHERE no_pengadaan='$Kode'";
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
			$my2Data = mysql_fetch_array($my2Qry);

			// Hitung Total (Semua data)
			$totalBarang	= $totalBarang + $my2Data['total_barang'];
			$totalBelanja	= $totalBelanja + $my2Data['total_belanja'];
		?>
			<tr>
				<td align="center"><?php echo $nomor; ?></td>
				<td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
				<td><?php echo $myData['no_pengadaan']; ?></td>
				<td><?php echo $myData['nm_petugas']; ?></td>
				<td><?php echo $myData['nm_barang']; ?></td>
				<td><?php echo $myData['keterangan']; ?></td>
				<td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
				<td align="right"><?php echo format_angka($my2Data['harga_beli']); ?></td>
				<td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
			</tr>
		<?php } ?>
		<tr>
			<td colspan="6" align="right"><strong>GRAND TOTAL : </strong></td>
			<td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
			<td align="right" bgcolor="#F5F5F5"></td>
			<td align="right" bgcolor="#F5F5F5"><strong>Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
		</tr>
	</table>
</body>

</html>