<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

/// Variabel SQL
$filterSQL  = "";

// Temporary Variabel form
$kodeKategori  = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
$dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

// PILIH KATEGORI
if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
  if ($kodeKategori == "Semua") {
    if ($dataKataKunci == "") {
      $filterSQL = "WHERE departemen.nm_departemen='$_SESSION[SES_UNIT]' ";
      $namaKategori = "Semua";
    } else {
      $filterSQL = "WHERE departemen.nm_departemen='$_SESSION[SES_UNIT]' AND barang.nm_barang LIKE'%$dataKataKunci%'";
      $namaKategori = "Semua";
    }
  } else {
    // SQL filter data
    if ($dataKataKunci == "") {
      $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND departemen.nm_departemen='$_SESSION[SES_UNIT]'";

      // Mendapatkan informasi nama kategori
      $infoSql = "SELECT nm_kategori FROM kategori $filterSQL";
      $infoQry = mysql_query($infoSql, $koneksidb);
      $infoData = mysql_fetch_array($infoQry);
      $namaKategori = $infoData['nm_kategori'];
    } else {
      $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND departemen.nm_departemen='$_SESSION[SES_UNIT]' AND barang.nm_barang LIKE'%$dataKataKunci%'";

      // Mendapatkan informasi nama kategori
      $infoSql = "SELECT nm_kategori FROM kategori $filterSQL";
      $infoQry = mysql_query($infoSql, $koneksidb);
      $infoData = mysql_fetch_array($infoQry);
      $namaKategori = $infoData['nm_kategori'];
    }
  }
} else {
  if ($kodeKategori == "Semua") {
    if ($dataKataKunci == "") {
      $filterSQL = "";
      $namaKategori = "Semua";
    } else {
      $filterSQL = "WHERE barang.nm_barang LIKE'%$dataKataKunci%'";
      $namaKategori = "Semua";
    }
  } else {
    if ($dataKataKunci == "") {
      $filterSQL = "WHERE barang.kd_kategori='$kodeKategori'";

      // Mendapatkan informasi nama kategori
      $infoSql = "SELECT * FROM pengadaan
      LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan = pengadaan_item.no_pengadaan
      LEFT JOIN barang ON pengadaan_item.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori 
      $filterSQL";
      $infoQry = mysql_query($infoSql, $koneksidb);
      $infoData = mysql_fetch_array($infoQry);
      $namaKategori = $infoData['nm_kategori'];
    } else {
      $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND barang.nm_barang LIKE'%$dataKataKunci%'";

      // Mendapatkan informasi nama kategori
      $infoSql = "SELECT * FROM pengadaan
      LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan = pengadaan_item.no_pengadaan
      LEFT JOIN barang ON pengadaan_item.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori 
      $filterSQL";
      $infoQry = mysql_query($infoSql, $koneksidb);
      $infoData = mysql_fetch_array($infoQry);
      $namaKategori = $infoData['nm_kategori'];
    }
  }
}
?>
<html>

<head>
  <title>:: Laporan Data Pengadaan - Inventory Kantor (Aset Barang)</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print()">
  <h2>LAPORAN DATA PENGADAAN</h2>
  <table width="500" border="0" class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
    </tr>
    <tr>
      <td width="108"><strong>Kategori </strong></td>
      <td width="15"><strong>:</strong></td>
      <td width="363"><?php echo $namaKategori; ?></td>
    </tr>
  </table>
  <br />
  <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="21" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="80" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
      <td width="100" bgcolor="#CCCCCC"><strong>No. Pengadaan</strong></td>
      <td width="150" bgcolor="#CCCCCC"><strong>Nama Petugas</strong></td>
      <td width="250" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
      <td width="150" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
      <td width="40" align="right" bgcolor="#CCCCCC"><strong>Harga</strong></td>
      <td width="90" align="center" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
      <td width="90" align="right" bgcolor="#CCCCCC"><strong>Total (Rp) </strong></td>
      <?php
      // Definisikan variabel angka
      $totalBarang = 0;
      $totalBelanja = 0;
      if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
        $mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen, petugas.nm_petugas, barang.nm_barang FROM pengadaan 
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
        $mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen, petugas.nm_petugas, barang.nm_barang FROM pengadaan 
          LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
          LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
          LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
          LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
          LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
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
						  SUM(harga_beli * jumlah) AS total_belanja, harga_beli 
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
      <td><?php echo $myData['nm_petugas']; ?></td>
      <td><?php echo $myData['nm_barang']; ?></td>
      <td><?php echo $myData['keterangan']; ?></td>
      <td align="right"><?php echo format_angka($my2Data['harga_beli']); ?></td>
      <td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
      <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
    </tr>
  <?php } ?>
  <tr>
    <td colspan="6  " align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#F5F5F5"></td>
    <td align="center" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong>Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
  </tr>
  </table>
</body>

</html>


<?php

$styleJudul = [
  'alignment' => [
    'horizontal' => Alignment::HORIZONTAL_CENTER
  ]

];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->mergeCells('A1:I1');
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('A1', 'LAPORAN PENGADAAN BARANG');
$sheet->mergeCells('A3:B3');
$sheet->setCellValue('A3', 'KETERANGAN');
$sheet->mergeCells('A4:B4');
$sheet->setCellValue('A4', 'Nama Kategori');
$sheet->setCellValue('B4', ':');
$sheet->setCellValue('C4', $namaKategori);
$sheet->setCellValue('A5', 'No');
$sheet->setCellValue('B5', 'Tanggal');
$sheet->setCellValue('C5', 'No. Pengadaan');
$sheet->setCellValue('D5', 'Nama Petugas');
$sheet->setCellValue('E5', 'Type Barang');
$sheet->setCellValue('F5', 'Keterangan');
$sheet->setCellValue('G5', 'Qty Barang');
$sheet->setCellValue('H5', 'Harga');
$sheet->setCellValue('I5', 'Total Harga');

$mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen, petugas.nm_petugas, barang.nm_barang FROM pengadaan 
          LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
          LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
          LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
          LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
          LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
          $filterSQL";
$myQry = mysqli_query($koneksidb, $mySql)  or die("Query 1 salah : " . mysql_error());
$i = 6;
$no = 1;
$totalBarang = 0;
$totalBelanja = 0;
while ($d = mysqli_fetch_array($myQry)) {
  # Membaca Kode pengadaan/ Nomor transaksi
  $noNota = $d['no_pengadaan'];

  # Menghitung Total pengadaan (belanja) setiap nomor transaksi
  $my2Sql = "SELECT SUM(jumlah) AS total_barang,  
        SUM(harga_beli * jumlah) AS total_belanja, harga_beli 
     FROM pengadaan_item WHERE no_pengadaan='$noNota'";
  $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
  $my2Data = mysql_fetch_array($my2Qry);

  $sheet->setCellValue('A' . $i, $no++);
  $sheet->setCellValue('B' . $i, IndonesiaTgl2($d['tgl_pengadaan']));
  $sheet->setCellValue('C' . $i, $d['no_pengadaan']);
  $sheet->setCellValue('D' . $i, $d['nm_petugas']);
  $sheet->setCellValue('E' . $i, $d['nm_barang']);
  $sheet->setCellValue('F' . $i, $d['keterangan']);
  $sheet->setCellValue('G' . $i, $my2Data['total_barang']);
  $sheet->setCellValue('H' . $i, 'Rp. ' . format_angka($my2Data['harga_beli']));
  $sheet->setCellValue('I' . $i, 'Rp. ' . format_angka($my2Data['total_belanja']));
  $i++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('file/Data Pengadaan.xlsx');
echo "<script>window.location = 'file/Data Pengadaan.xlsx'</script>";
