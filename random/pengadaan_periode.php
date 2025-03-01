<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Membaca Tanggal Awal (tglAwal) dan Tanggal Akhir (tglAkhir)
$tglAwal   = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-" . date('m-Y');
$tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

$filterSQL = " WHERE ( tgl_pengadaan BETWEEN '" . InggrisTgl($tglAwal) . "' AND '" . InggrisTgl($tglAkhir) . "')";
?>
<html>

<head>
  <title>:: Laporan Pengadaan Periode - Inventory Kantor (Aset Barang)</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print()">
  <h2>LAPORAN PENGADAAN PER PERIODE</h2>
  <table width="500" border="0" class="table-list">
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
      <td width="30" align="center" bgcolor="#F5F5F5"><b>No</b></td>
      <td width="86" bgcolor="#F5F5F5"><b>Tanggal</b></td>
      <td width="106" bgcolor="#F5F5F5"><b>No. Pengadaan </b></td>
      <td width="223" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
      <td width="196" bgcolor="#F5F5F5"><strong>Supplier</strong></td>
      <td width="97" align="right" bgcolor="#F5F5F5"><strong>Tot Barang </strong></td>
      <td width="126" align="right" bgcolor="#F5F5F5"><strong>Tot Belanja (Rp) </strong></td>
    </tr>
    <?php
    // Definisikan variabel angka
    $totalBarang = 0;
    $totalBelanja = 0;
    if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
      $mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen FROM pengadaan 
          LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
          LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
          LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
          LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
          LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
          $filterSQL
          AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
          ORDER BY pengadaan.no_pengadaan ASC";
      $myQry = mysql_query($mySql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
    } else {
      # Skrip untuk menampilkan Data Trans Pengadaan, dilengkapi informasi Supplier dari tabel relasi
      $mySql = "SELECT pengadaan.*, supplier.nm_supplier FROM pengadaan
          LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier 
          $filterSQL 
          ORDER BY pengadaan.no_pengadaan ASC";
      $myQry = mysql_query($mySql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
    }
    $nomor  = 0;
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;

      # Membaca Kode pengadaan/ Nomor transaksi
      $noNota = $myData['no_pengadaan'];

      # Menghitung Total pengadaan (belanja) setiap nomor transaksi
      $my2Sql = "SELECT SUM(jumlah) AS total_barang,  
						  SUM(harga_beli * jumlah) AS total_belanja 
				   FROM pengadaan_item WHERE no_pengadaan='$noNota'";
      $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
      $my2Data = mysql_fetch_array($my2Qry);

      $totalBarang  = $totalBarang + $my2Data['total_barang'];
      $totalBelanja = $totalBelanja + $my2Data['total_belanja'];
    ?>
      <tr>
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
        <td><?php echo $myData['no_pengadaan']; ?></td>
        <td><?php echo $myData['keterangan']; ?></td>
        <td><?php echo $myData['nm_supplier']; ?></td>
        <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
        <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="5" align="right"><strong>GRAND TOTAL : </strong></td>
      <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
      <td align="right" bgcolor="#F5F5F5"><strong>Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
    </tr>
  </table>
</body>

</html>