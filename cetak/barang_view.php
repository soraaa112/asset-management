<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Menampilkan data Barang, dilengkapi informasi Kategori dari tabel relasi
$Kode  = isset($_GET['Kode']) ? $_GET['Kode'] : '-';

$infoSql = "SELECT barang.*, kategori.nm_kategori, departemen.nm_departemen FROM barang 
			LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
      LEFT JOIN tmp_pengadaan ON barang.kd_barang=tmp_pengadaan.kd_barang 
      LEFT JOIN penempatan ON tmp_pengadaan.kd_petugas=penempatan.kd_petugas
      LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
      LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen 
			WHERE barang.kd_barang='$Kode'";
$infoQry = mysql_query($infoSql, $koneksidb);
$infoData = mysql_fetch_array($infoQry);
?>
<html>

<head>
  <title>:: Laporan Detail Barang - Inventory Kantor ( Aset Barang )</title>
  <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="javascript:window.print()">
  <h2>VIEW DETAIL BARANG </h2>
  <table width="800" border="0" cellpadding="2" cellspacing="1" class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><b>DATA BARANG </b></td>
    </tr>
    <tr>
      <td width="186"><strong>Kode</strong></td>
      <td width="5"><b>:</b></td>
      <td width="1007"><?php echo $infoData['kd_barang']; ?></td>
    </tr>
    <tr>
      <td><strong>Type Barang</strong></td>
      <td><b>:</b></td>
      <td><?php echo $infoData['nm_barang']; ?></td>
    </tr>
    <tr>
      <td><strong>Kategori</strong></td>
      <td><b>:</b></td>
      <td><?php echo $infoData['nm_kategori']; ?></td>
    </tr>
    <tr>
      <td><strong>Departemen</strong></td>
      <td><b>:</b></td>
      <td><?php echo $_SESSION['SES_NAMA']; ?> | <?php echo $_SESSION['SES_UNIT']; ?></td>
    </tr>
    <tr>
      <td><strong>Satuan</strong></td>
      <td><b>:</b></td>
      <td><?php echo $infoData['satuan']; ?></td>
    </tr>
  </table>

  <table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td colspan="5"><strong>DAFTAR INVENTARIS</strong> </td>
    </tr>
    <tr>
      <td width="26" bgcolor="#F5F5F5"><strong>No</strong></td>
      <td width="240" bgcolor="#F5F5F5"><strong>Kode Inventaris </strong></td>
      <td width="163" bgcolor="#F5F5F5"><strong>Status</strong></td>
      <td width="350" bgcolor="#F5F5F5"><strong>Lokasi Sekarang </strong></td>
      <td width="163" bgcolor="#F5F5F5"><strong>Departemen</strong></td>
    </tr>
    <?php
    // Menampilkan data Koleksi Barang (Inventaris Barang)
    $mySql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";
    $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
    $nomor = 0;
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $KodeInventory = $myData['kd_inventaris'];

      $infoLokasi  = "";

      // Mencari lokasi Penempatan Barang
      if ($myData['status_barang'] == "Ditempatkan") {
        $my2Sql = "SELECT lokasi.nm_lokasi, departemen.nm_departemen, PI.status_aktif FROM penempatan_item as PI
						LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
						LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
            LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
						WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$KodeInventory'";
        $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my2Data = mysql_fetch_array($my2Qry);
        $infoLokasi  = $my2Data['nm_lokasi'];
        $infoDepartemen = $my2Data['nm_departemen'];
      }

      // Mencari Siapa Penempatan Barang
      if ($myData['status_barang'] == "Dipinjam") {
        $my3Sql = "SELECT pegawai.nm_pegawai, departemen.nm_departemen, peminjaman.status_kembali FROM peminjaman_item as PI
						LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
						LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
            LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
						WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$KodeInventory'";
        $my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my3Data = mysql_fetch_array($my3Qry);
        $infoLokasi  = $my3Data['nm_pegawai'];
        $infoDepartemen = $my3Data['nm_departemen'];
      }
    ?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $KodeInventory; ?></td>
        <td><?php echo $myData['status_barang']; ?></td>
        <td><?php echo $infoLokasi; ?></td>
        <?php if ($myData['status_barang'] == "Tersedia") { ?>
          <td></td>
        <?php } else { ?>
          <td><?php echo $infoDepartemen; ?></td>
        <?php } ?>
      </tr>
    <?php } ?>
  </table>

</body>

</html>