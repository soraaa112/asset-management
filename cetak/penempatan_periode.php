<?php
session_start();
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
if ($kodeKategori == "Semua") {
  if ($dataKataKunci == "") {
    $filterSQL = "WHERE penempatan_item.status_aktif='Yes'";
  } else {
    $filterSQL = "WHERE barang.nm_barang LIKE'%$dataKataKunci%' AND penempatan_item.status_aktif='Yes'";
  }
} else {
  if ($dataKataKunci == "") {
    $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND penempatan_item.status_aktif='Yes'";
  } else {
    $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND barang.nm_barang LIKE'%$dataKataKunci%' AND penempatan_item.status_aktif='Yes'";
  }
}
?>
<html>

<head>
  <title>:: Laporan Penempatan Periode - Inventory Kantor (Aset Barang)</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print()">
  <h2>LAPORAN DATA PENEMPATAN BARANG</h2>
  <br />
  <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="15" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="30" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
      <td width="50" bgcolor="#CCCCCC"><strong>No. Penempatan</strong></td>
      <td width="200" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
      <td width="100" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
      <td width="100" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
      <td width="100" bgcolor="#CCCCCC"><strong>Lokasi</strong></td>
      <td width="80" align="center" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
    </tr>
    <?php
    if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
      $mySql = "SELECT penempatan.*, penempatan_item.*, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang, kategori.nm_kategori FROM penempatan 
     LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
     LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
     LEFT JOIN penempatan_item ON penempatan.no_penempatan=penempatan_item.no_penempatan
     LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
     LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
     LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
     $filterSQL
     AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
     GROUP BY penempatan_item.no_penempatan ASC";
      $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
    } else {
      # Perintah untuk menampilkan Semua Daftar Transaksi penempatan
      $mySql = "SELECT penempatan.*, penempatan_item.*, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang, kategori.nm_kategori FROM penempatan
     LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
     LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
     LEFT JOIN penempatan_item ON penempatan.no_penempatan=penempatan_item.no_penempatan
     LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
     LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
     LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
     $filterSQL
     GROUP BY penempatan_item.no_penempatan ASC";
      $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
    }
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
        <td><?php echo $myData['nm_kategori']; ?></td>
        <td><?php echo $myData['nm_departemen']; ?></td>
        <td><?php echo $myData['nm_lokasi']; ?></td>
        <td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
      </tr>
    <?php } ?>
  </table>
</body>

</html>

<?php
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->mergeCells('A1:I1');
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('A1', 'LAPORAN DATA PENEMPATAN BARANG');
$sheet->setCellValue('A3', 'No');
$sheet->setCellValue('B3', 'Tanggal');
$sheet->setCellValue('C3', 'No. Penempatan');
$sheet->setCellValue('D3', 'Kategori');
$sheet->setCellValue('E3', 'Type Barang');
$sheet->setCellValue('F3', 'Departemen');
$sheet->setCellValue('G3', 'Lokasi');
$sheet->setCellValue('H3', 'Qty Barang');

if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
  $mySql = "SELECT penempatan.*, penempatan_item.*, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang, kategori.nm_kategori FROM penempatan 
 LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
 LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
 LEFT JOIN penempatan_item ON penempatan.no_penempatan=penempatan_item.no_penempatan
 LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
 LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
 LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
 $filterSQL
 AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
 GROUP BY penempatan_item.no_penempatan ASC";
  $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
} else {
  # Perintah untuk menampilkan Semua Daftar Transaksi penempatan
  $mySql = "SELECT penempatan.*, penempatan_item.*, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang, kategori.nm_kategori FROM penempatan 
 LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
 LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
 LEFT JOIN penempatan_item ON penempatan.no_penempatan=penempatan_item.no_penempatan
 LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
 LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
 LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
 $filterSQL
 GROUP BY penempatan_item.no_penempatan ASC";
  $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
}
$i = 4;
$no = 1;
while ($d = mysqli_fetch_array($myQry)) {
  # Membaca Kode penempatan/ Nomor transaksi
  $noNota = $d['no_penempatan'];

  # Menghitung Total penempatan (belanja) setiap nomor transaksi
  $my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noNota'";
  $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
  $my2Data = mysql_fetch_array($my2Qry);
  $sheet->setCellValue('A' . $i, $no++);
  $sheet->setCellValue('B' . $i, IndonesiaTgl($d['tgl_penempatan']));
  $sheet->setCellValue('C' . $i, $d['no_penempatan']);
  $sheet->setCellValue('D' . $i, $d['nm_kategori']);
  $sheet->setCellValue('E' . $i, $d['nm_barang']);
  $sheet->setCellValue('F' . $i, $d['nm_departemen']);
  $sheet->setCellValue('G' . $i, $d['nm_lokasi']);
  $sheet->setCellValue('H' . $i, $my2Data['total_barang']);
  $i++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('file/Penempatan Periode.xlsx');
echo "<script>window.location = 'file/Penempatan Periode.xlsx'</script>";

?>