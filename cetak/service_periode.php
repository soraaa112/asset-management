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
      $infoSql = "SELECT * FROM services
      LEFT JOIN service_item ON services.no_service = service_item.no_service
      LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori";
      $infoQry = mysql_query($infoSql, $koneksidb);
      $infoData = mysql_fetch_array($infoQry);
      $namaKategori = $infoData['nm_kategori'];
    } else {
      $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND barang.nm_barang LIKE'%$dataKataKunci%'";

      // Mendapatkan informasi nama kategori
      $infoSql = "SELECT * FROM services
      LEFT JOIN service_item ON services.no_service = service_item.no_service
      LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori";
      $infoQry = mysql_query($infoSql, $koneksidb);
      $infoData = mysql_fetch_array($infoQry);
      $namaKategori = $infoData['nm_kategori'];
    }
  }
}
?>
<html>

<head>
  <title>:: Laporan Servis Periode - Inventory Kantor (Aset Barang)</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print()">
  <h2>LAPORAN DATA SERVIS</h2>
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
      <td width="20" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="90" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
      <td width="110" bgcolor="#CCCCCC"><strong>No. Service</strong></td>
      <td width="110" bgcolor="#CCCCCC"><strong>Kode Label</strong></td>
      <td width="154" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
      <td width="229" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
      <td width="250" bgcolor="#CCCCCC"><strong>Departemen &amp; Lokasi</strong></td>
      <td width="154" bgcolor="#CCCCCC"><strong>Vendor Service</strong></td>
      <td width="120" align="right" bgcolor="#CCCCCC"><strong>Total Biaya (Rp) </strong></td>
    </tr>
    <?php
    # Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
    if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
      # Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
      $mySql  = "SELECT services.*, vendor_service.nm_vendor_service, barang.nm_barang, 
              barang_inventaris.*, departemen.nm_departemen, nm_lokasi
              FROM services 
              LEFT JOIN vendor_service ON services.kd_vendor_service=vendor_service.kd_vendor_service
              LEFT JOIN service_item on services.no_service=service_item.no_service
              LEFT JOIN barang_inventaris on service_item.kd_inventaris=barang_inventaris.kd_inventaris
              LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
              LEFT JOIN pengadaan on barang_inventaris.no_pengadaan=pengadaan.no_pengadaan
              LEFT JOIN petugas on pengadaan.kd_petugas=petugas.kd_petugas
              LEFT JOIN departemen on petugas.kd_departemen=departemen.kd_departemen
              LEFT JOIN penempatan_item on barang_inventaris.kd_inventaris=penempatan_item.kd_inventaris
              LEFT JOIN penempatan ON penempatan_item.no_penempatan=penempatan.no_penempatan
              LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi  
              $filterSQL
              AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
              ORDER BY services.no_service DESC";
      $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
      $nomor  = 0;
    } else {
      $mySql  = "SELECT services.*, vendor_service.nm_vendor_service, barang.nm_barang, barang_inventaris.*, departemen.nm_departemen, service_item.keterangan
              FROM services 
              LEFT JOIN vendor_service ON services.kd_vendor_service=vendor_service.kd_vendor_service
              LEFT JOIN service_item on services.no_service=service_item.no_service
              LEFT JOIN barang_inventaris on service_item.kd_inventaris=barang_inventaris.kd_inventaris
              LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
              LEFT JOIN pengadaan on barang_inventaris.no_pengadaan=pengadaan.no_pengadaan
              LEFT JOIN petugas on pengadaan.kd_petugas=petugas.kd_petugas
              LEFT JOIN departemen on petugas.kd_departemen=departemen.kd_departemen
    $filterSQL
    ORDER BY services.no_service DESC";
      $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
      $nomor  = 0;
    }
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['no_service'];
      $inventaris = $myData['kd_inventaris'];

      // Mencari lokasi Penempatan Barang
      if ($myData['status_barang'] == "Ditempatkan") {
        $my2Sql = "SELECT lokasi.nm_lokasi, departemen.nm_departemen FROM penempatan_item as PI
				LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
				LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
				LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
				WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$inventaris'";
        $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
        $my2Data = mysql_fetch_array($my2Qry);
        $infoLokasi  = $my2Data['nm_lokasi'];
        $infoDepartemen = $my2Data['nm_departemen'];
      }

      // Mencari Siapa Penempatan Barang
      if ($myData['status_barang'] == "Dipinjam") {
        $my3Sql = "SELECT pegawai.nm_pegawai, departemen.nm_departemen FROM peminjaman_item as PI
				LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
				LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
				WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$inventaris'";
        $my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query 3 salah : " . mysql_error());
        $my3Data = mysql_fetch_array($my3Qry);
        $infoLokasi  = $my3Data['nm_pegawai'];
        $infoDepartemen = $my2Data['nm_departemen'];
      }

      if ($myData['status_barang'] == "Tersedia") {
        $my4Sql = "SELECT pengadaan.*, barang_inventaris.*, petugas.nm_petugas, departemen.nm_departemen FROM pengadaan 
				LEFT JOIN barang_inventaris ON pengadaan.no_pengadaan=barang_inventaris.no_pengadaan
				LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
				LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
				WHERE barang_inventaris.kd_inventaris='$inventaris'";
        $my4Qry = mysql_query($my4Sql, $koneksidb)  or die("Query 4 salah : " . mysql_error());
        $my4Data = mysql_fetch_array($my4Qry);
        $infoLokasi  = $my4Data['status_barang'];
        $infoDepartemen = $my4Data['nm_departemen'];
      }

      # Menghitung Total pengadaan (belanja) setiap nomor transaksi
      $my2Sql = "SELECT harga_service
        FROM service_item WHERE no_service='$Kode'";
      $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
      $my2Data = mysql_fetch_array($my2Qry);

    ?>
      <tr>
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_service']); ?></td>
        <td><?php echo $myData['no_service']; ?></td>
        <td><?php echo $myData['kd_inventaris']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['keterangan']; ?></td>
        <?php if ($myData['status_barang'] == "Ditempatkan") : ?>
          <td><?php echo $infoLokasi . ", " . $infoDepartemen; ?></td>
        <?php elseif ($myData['status_barang'] == "Dipinjam") : ?>
          <td><?php echo $infoLokasi . ", " . $infoDepartemen; ?></td>
        <?php else : ?>
          <td><?php echo $infoDepartemen . ", " . $myData['status_barang']; ?></td>
        <?php endif; ?>
        <td><?php echo $myData['nm_vendor_service']; ?></td>
        <td align="right"><?php echo format_angka($my2Data['harga_service']); ?></td>
      </tr>
    <?php } ?>
  </table> <br><br></td>
  </tr>
  </table>

  <?php

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();

  $sheet->mergeCells('A1:I1');
  $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->setCellValue('A1', 'LAPORAN DATA SERVIS');
  $sheet->setCellValue('A3', 'KETERANGAN');
  $sheet->setCellValue('A4', 'Nama Kategori');
  $sheet->setCellValue('B4', ':');
  $sheet->setCellValue('C4', $namaKategori);
  $sheet->setCellValue('A5', 'No');
  $sheet->setCellValue('B5', 'Tanggal');
  $sheet->setCellValue('C5', 'No. Service');
  $sheet->setCellValue('D5', 'Kode Label');
  $sheet->setCellValue('E5', 'Type Barang');
  $sheet->setCellValue('F5', 'Keterangan');
  $sheet->setCellValue('G5', 'Departemen & Lokasi');
  $sheet->setCellValue('H5', 'Vendor Service');
  $sheet->setCellValue('I5', 'Total Biaya (Rp)');

  # Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
  if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    # Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
    $mySql  = "SELECT services.*, vendor_service.nm_vendor_service, barang.nm_barang, 
          barang_inventaris.*, departemen.nm_departemen, nm_lokasi
          FROM services 
          LEFT JOIN vendor_service ON services.kd_vendor_service=vendor_service.kd_vendor_service
          LEFT JOIN service_item on services.no_service=service_item.no_service
          LEFT JOIN barang_inventaris on service_item.kd_inventaris=barang_inventaris.kd_inventaris
          LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
          LEFT JOIN pengadaan on barang_inventaris.no_pengadaan=pengadaan.no_pengadaan
          LEFT JOIN petugas on pengadaan.kd_petugas=petugas.kd_petugas
          LEFT JOIN departemen on petugas.kd_departemen=departemen.kd_departemen
          LEFT JOIN penempatan_item on barang_inventaris.kd_inventaris=penempatan_item.kd_inventaris
          LEFT JOIN penempatan ON penempatan_item.no_penempatan=penempatan.no_penempatan
          LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi  
          $filterSQL
          AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
          ORDER BY services.no_service DESC";
    $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
  } else {
    $mySql  = "SELECT services.*, vendor_service.nm_vendor_service, barang.nm_barang, service_item.keterangan, barang_inventaris.*, departemen.nm_departemen
        FROM services 
        LEFT JOIN vendor_service ON services.kd_vendor_service=vendor_service.kd_vendor_service
        LEFT JOIN service_item on services.no_service=service_item.no_service
        LEFT JOIN barang_inventaris on service_item.kd_inventaris=barang_inventaris.kd_inventaris
        LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
        LEFT JOIN pengadaan on barang_inventaris.no_pengadaan=pengadaan.no_pengadaan
        LEFT JOIN petugas on pengadaan.kd_petugas=petugas.kd_petugas
        LEFT JOIN departemen on petugas.kd_departemen=departemen.kd_departemen
 
        $filterSQL
        ORDER BY services.no_service DESC";
    $myQry = mysqli_query($koneksidb, $mySql)  or die("Query salah : " . mysql_error());
  }
  $i = 6;
  $no = 1;
  while ($d = mysqli_fetch_array($myQry)) {
    $Kode = $d['no_service'];
    $inventaris = $d['kd_inventaris'];

    // Mencari lokasi Penempatan Barang
    if ($d['status_barang'] == "Ditempatkan") {
      $my2Sql = "SELECT lokasi.nm_lokasi, departemen.nm_departemen FROM penempatan_item as PI
				LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
				LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
				LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
				WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$inventaris'";
      $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
      $my2Data = mysql_fetch_array($my2Qry);
      $infoLokasi  = $my2Data['nm_lokasi'];
      $infoDepartemen = $my2Data['nm_departemen'];
    }

    // Mencari Siapa Penempatan Barang
    if ($d['status_barang'] == "Dipinjam") {
      $my3Sql = "SELECT pegawai.nm_pegawai, departemen.nm_departemen FROM peminjaman_item as PI
				LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
				LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
				WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$inventaris'";
      $my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query 3 salah : " . mysql_error());
      $my3Data = mysql_fetch_array($my3Qry);
      $infoLokasi  = $my3Data['nm_pegawai'];
      $infoDepartemen = $my2Data['nm_departemen'];
    }

    if ($d['status_barang'] == "Tersedia") {
      $my4Sql = "SELECT pengadaan.*, barang_inventaris.*, petugas.nm_petugas, departemen.nm_departemen FROM pengadaan 
				LEFT JOIN barang_inventaris ON pengadaan.no_pengadaan=barang_inventaris.no_pengadaan
				LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
				LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
				WHERE barang_inventaris.kd_inventaris='$inventaris'";
      $my4Qry = mysql_query($my4Sql, $koneksidb)  or die("Query 4 salah : " . mysql_error());
      $my4Data = mysql_fetch_array($my4Qry);
      $infoLokasi  = $my4Data['status_barang'];
      $infoDepartemen = $my4Data['nm_departemen'];
    }

    # Menghitung Total pengadaan (belanja) setiap nomor transaksi
    $my2Sql = "SELECT harga_service
        FROM service_item WHERE no_service='$Kode'";
    $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
    $my2Data = mysql_fetch_array($my2Qry);

    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $d['tgl_service']);
    $sheet->setCellValue('C' . $i, $d['no_service']);
    $sheet->setCellValue('D' . $i, $d['kd_inventaris']);
    $sheet->setCellValue('E' . $i, $d['nm_barang']);
    $sheet->setCellValue('F' . $i, $d['keterangan']);
    $sheet->setCellValue('G' . $i, $infoLokasi . ", " . $infoDepartemen);
    $sheet->setCellValue('H' . $i, $d['nm_vendor_service']);
    $sheet->setCellValue('I' . $i, $my2Data['harga_service']);
    $i++;
  }

  $writer = new Xlsx($spreadsheet);
  $writer->save('file/Data servis per kategori.xlsx');
  echo "<script>window.location = 'file/Data servis per kategori.xlsx'</script>";

  ?>