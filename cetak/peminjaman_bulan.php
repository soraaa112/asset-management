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
			$filterSQL	= "WHERE LEFT(tgl_peminjaman,4)='$dataTahun' AND departemen.nm_departemen='$dataUnit'";

			$infoBulan	= "";
		} else {
			// Filter bulan dan tahun
			$filterSQL = "WHERE MID(tgl_peminjaman,6,2)='$dataBulan' AND LEFT(tgl_peminjaman,4)='$dataTahun' AND departemen.nm_departemen='$dataUnit'";

			$infoBulan	= $listBulan[$dataBulan] . ", ";
		}
	}
} else {
	if ($dataBulan and $dataTahun) {
		if ($dataBulan == "00") {
			// Filter tahun
			$filterSQL	= "WHERE LEFT(tgl_peminjaman,4)='$dataTahun'";

			$infoBulan	= "";
		} else {
			// Filter bulan dan tahun
			$filterSQL = "WHERE MID(tgl_peminjaman,6,2)='$dataBulan' AND LEFT(tgl_peminjaman,4)='$dataTahun'";

			$infoBulan	= $listBulan[$dataBulan] . ", ";
		}
	} else {
		$filterSQL = "";
	}
}

?>
<html>

<head>
	<title>:: Laporan Peminjaman Bulan - Inventory Kantor (Aset Barang)</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print()">
	<h2>LAPORAN PEMINJAMAN PER BULAN</h2>
	<table width="500" border="0" class="table-list">
		<tr>
			<td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
		</tr>
		<tr>
			<td width="132"><strong> Bulan Peminjaman </strong></td>
			<td width="5"><strong>:</strong></td>
			<td width="349"><?php echo $infoBulan . $dataTahun; ?></td>
		</tr>
	</table>
	<br />
	<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td width="23" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
			<td width="76" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
			<td width="106" bgcolor="#F5F5F5"><strong>No. Peminjaman</strong></td>
			<td width="160" bgcolor="#F5F5F5"><strong>Type Barang</strong></td>
			<td width="220" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
			<td width="200" bgcolor="#F5F5F5"><strong>Pegawai</strong></td>
			<td width="95" bgcolor="#F5F5F5"><strong>Departemen</strong></td>
			<td width="65" bgcolor="#F5F5F5"><strong>Status</strong></td>
			<td width="70" align="right" bgcolor="#F5F5F5"><strong>Qty Barang</strong></td>
		</tr>
		<?php
		// Skrip menampilkan data Transaksi Peminjaman dilengkapi informasi Pegawai
		$mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
			LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
			LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
			LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
			LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
			$filterSQL
			ORDER BY peminjaman.no_peminjaman DESC";
		$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
		$nomor  = 0;
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;

			// Membaca Kode peminjaman/ Nomor transaksi
			$noNota = $myData['no_peminjaman'];

			// Menghitung Total barang yang dipinjam setiap nomor transaksi
			$my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE  no_peminjaman='$noNota'";
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
			$my2Data = mysql_fetch_array($my2Qry);
		?>
			<tr>
				<td align="center"><?php echo $nomor; ?></td>
				<td><?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?></td>
				<td><?php echo $myData['no_peminjaman']; ?></td>
				<td><?php echo $myData['nm_barang']; ?></td>
				<td><?php echo $myData['keterangan']; ?></td>
				<td><?php echo $myData['nm_pegawai']; ?></td>
				<td><?php echo $myData['nm_departemen']; ?></td>
				<td><?php echo $myData['status_kembali']; ?></td>
				<td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
			</tr>
		<?php } ?>
	</table>
</body>

</html>