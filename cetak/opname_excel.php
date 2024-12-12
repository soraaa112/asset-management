<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../vendor/autoload.php";


$filterSQL = "";

# Set Tanggal skrg
$status = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
$kodeKategori  = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
$dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

// PILIH KATEGORI
if ($kodeKategori == "Semua") {
  if ($status ==  "Semua") {
    if ($dataKataKunci ==  "") {
      $filterSQL   = "";
      $statusBarang = "";
      $namaKategori = "Semua";
    } else {
      $filterSQL   = " WHERE barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = "";
      $namaKategori = "Semua";
    }
  } else {
    if ($dataKataKunci ==  "") {
      $filterSQL   = "WHERE opname.status = '$status'";

      $infoSql   = "SELECT * FROM opname
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = $kolomData['status'];
      $namaKategori = "Semua";
    } else {
      $filterSQL   = " WHERE barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%' AND opname.status = '$status'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = $kolomData['status'];
      $namaKategori = "Semua";
    }
  }
} else {
  if ($status ==  "Semua") {
    if ($dataKataKunci ==  "") {
      $filterSQL   = " WHERE kategori.kd_kategori ='$kodeKategori'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = "";
      $namaKategori = $kolomData['nm_kategori'];
    } else {
      $filterSQL   = " WHERE kategori.kd_kategori ='$kodeKategori' AND barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = "";
      $namaKategori = $kolomData['nm_kategori'];
    }
  } else {
    if ($dataKataKunci ==  "") {
      $filterSQL   = "WHERE kategori.kd_kategori ='$kodeKategori' AND opname.status = '$status'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = $kolomData['status'];
      $namaKategori = $kolomData['nm_kategori'];
    } else {
      $filterSQL   = " WHERE kategori.kd_kategori ='$kodeKategori' AND barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%' AND opname.status = '$status'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = $kolomData['status'];
      $namaKategori = $kolomData['nm_kategori'];
    }
  }
}
?>
<html>

<head>
  <title>:: Laporan Opname Periode - Inventory Kantor (Aset Barang)</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print()">
  <h2>LAPORAN OPNAME PER PERIODE</h2>
  <table width="500" border="0" class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
    </tr>
    <tr>
      <td width="108"><strong>Kategori </strong></td>
      <td width="15"><strong>:</strong></td>
      <td width="363"><?php echo $namaKategori; ?></td>
    </tr>
    <?php if ($status != "Semua") : ?>
      <tr>
        <td width="108"><strong>Status </strong></td>
        <td width="15"><strong>:</strong></td>
        <td width="363"><?php echo $statusBarang; ?></td>
      </tr>
    <?php endif; ?>
  </table>
  <br />
  <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="35" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="90" bgcolor="#CCCCCC"><strong>Kode Opname</strong></td>
      <td width="100" bgcolor="#CCCCCC"><strong>Kode Label</strong></td>
      <td width="250" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
      <td width="100" bgcolor="#CCCCCC"><strong>Tgl Opname</strong></td>
      <td width="70" bgcolor="#CCCCCC"><strong>Kondisi</strong></td>
      <td width="70" bgcolor="#CCCCCC"><strong>Status</strong></td>
    </tr>
    <?php
    # Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
    $mySql  = "SELECT opname.*, barang.nm_barang, barang_inventaris.kd_inventaris 
    FROM opname
    LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
    LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
    LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
    LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori $filterSQL 
    ORDER BY kd_opname ASC";
    $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
    $nomor  = 0;
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_opname'];

      // gradasi warna
      if ($nomor % 2 == 1) {
        $warna = "";
      } else {
        $warna = "#F5F5F5";
      }
    ?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_opname']; ?></td>
        <td><?php echo $myData['kd_inventaris']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tahun_opname']); ?></td>
        <td><?php echo $myData['keterangan']; ?></td>
        <td><?php echo $myData['status']; ?></td>
      </tr>
    <?php } ?>
  </table> <br><br></td>
  </tr>
  </table>

  <?php

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();

  $sheet->setCellValue('A1', 'LAPORAN OPNAME PER PERIODE');
  $sheet->setCellValue('A3', 'KETERANGAN');
  $sheet->setCellValue('A4', 'Periode');
  $sheet->setCellValue('B4', ':');
  $sheet->setCellValue('D3', $statusBarang);
  $sheet->setCellValue('A5', 'No');
  $sheet->setCellValue('B5', 'Kode Opname');
  $sheet->setCellValue('C5', 'Kode Label');
  $sheet->setCellValue('D5', 'Type Barang');
  $sheet->setCellValue('E5', 'Tgl Opname');
  $sheet->setCellValue('F5', 'Kondisi');
  $sheet->setCellValue('G5', 'Status');

  $mySql  = "SELECT opname.*, barang.nm_barang, barang_inventaris.kd_inventaris 
    FROM opname
    LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
    LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
    LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
    LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori $filterSQL 
    ORDER BY kd_opname ASC";
  $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
  $i = 6;
  $no = 1;
  while ($d = mysql_fetch_array($myQry)) {
    $Kode = $d['kd_opname'];

    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $d['kd_opname']);
    $sheet->setCellValue('C' . $i, $d['kd_inventaris']);
    $sheet->setCellValue('D' . $i, $d['nm_barang']);
    $sheet->setCellValue('E' . $i, $d['tahun_opname']);
    $sheet->setCellValue('F' . $i, $d['keterangan']);
    $sheet->setCellValue('G' . $i, $d['status']);
    $i++;
  }

  $writer = new Xlsx($spreadsheet);
  $writer->save('file/Opname Periode.xlsx');
  echo "<script>window.location = 'file/Opname Periode.xlsx'</script>";
  ?>