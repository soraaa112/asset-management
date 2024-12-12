<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

$Kode  = isset($_GET['Kode']) ? $_GET['Kode'] : '-';
$kodeStatusBarang  = isset($_GET['statusBarang']) ? $_GET['statusBarang'] : '';

if ($kodeStatusBarang == "Kosong") {
  //Query #1 (all)
  $filterSQL   = "";
} else {
  //Query #1 (all)
  $filterSQL   = "AND barang_inventaris.status_barang = '$kodeStatusBarang'";
}

$baris = 10;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$infoSql = "SELECT barang.*, barang_inventaris.status_barang, kategori.nm_kategori, barang_inventaris.tgl_masuk FROM barang_inventaris
LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
WHERE barang_inventaris.kd_inventaris ='$Kode' $filterSQL";
$infoQry = mysql_query($infoSql, $koneksidb);
$infoData = mysql_fetch_array($infoQry);
?>
<div class='table-border'>
  <table width="800" border="0" cellpadding="2" cellspacing="1" class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><b>DATA BARANG </b></td>
    </tr>
    <tr>
      <td><strong>Tanggal Pengadaan</strong></td>
      <td><b>:</b></td>
      <td><?php echo IndonesiaTgl($infoData['tgl_masuk']); ?></td>
    </tr>
    <tr>
      <td><strong>Kode</strong></td>
      <td><b>:</b></td>
      <td><?php echo $infoData['kd_barang']; ?></td>
    </tr>
    <tr>
      <td width="186"><strong>Type Barang </strong></td>
      <td width="5"><b>:</b></td>
      <td width="1007"><?php echo $infoData['nm_barang']; ?></td>
    </tr>
    <tr>
      <td><strong>Kategori</strong></td>
      <td><b>:</b></td>
      <td><?php echo $infoData['nm_kategori']; ?></td>
    </tr>
    <tr>
      <td><strong>Satuan</strong></td>
      <td><b>:</b></td>
      <td><?php echo $infoData['satuan']; ?></td>
    </tr>
    <tr>
      <td><strong>Foto</strong></td>
      <td><b>:</b></td>
      <td><?php
          $ex = explode(';', $infoData['foto']);
          $no = 1;
          for ($i = 0; $i < count($ex); $i++) {
            if ($ex[$i] != '') {
              echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'>" . $ex[$i] . "</a>, ";
            }
            $no++;
          }
          ?></td>
    </tr>
  </table>

  <br>

  <table id="example1" class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
    <thead>
      <tr>
        <td colspan="8"><strong>DAFTAR INVENTARIS</strong> </td>
      </tr>
      <tr>
        <td width="24" bgcolor="#F5F5F5"><strong>No</strong></td>
        <td width="130" bgcolor="#F5F5F5"><strong>No. Penempatan / Peminjaman </strong></td>
        <td width="110" bgcolor="#F5F5F5"><strong>Kode Label </strong></td>
        <td width="100" bgcolor="#F5F5F5"><strong>Status</strong></td>
        <td width="120" bgcolor="#F5F5F5"><strong>Tanggal Mulai </strong></td>
        <td width="120" bgcolor="#F5F5F5"><strong>Tanggal Akhir </strong></td>
        <td width="200" bgcolor="#F5F5F5"><strong>Lokasi / Nama Pegawai</strong></td>
        <td width="200" bgcolor="#F5F5F5"><strong>Departemen</strong></td>
      </tr>
    </thead>
    <tbody>
      <?php
      # MENJALANKAN QUERY , 
      $mySql = "SELECT * FROM barang_inventaris
      LEFT JOIN penempatan_item ON barang_inventaris.kd_inventaris = penempatan_item.kd_inventaris
      LEFT JOIN peminjaman_item ON barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris WHERE barang_inventaris.kd_inventaris='$Kode' $filterSQL";
      $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
      $nomor = $hal;
      while ($myData = mysql_fetch_array($myQry)) {
        $nomor++;
        $KodeInventory = $myData['kd_inventaris'];
        $penempatan = $myData['no_penempatan'];
        $peminjaman = $myData['no_peminjaman'];

        if ($myData['status_barang'] == "Ditempatkan") {
          $my2Sql = "SELECT penempatan_item.no_penempatan, penempatan_item.kd_inventaris, penempatan_item.status_aktif, penempatan.tgl_penempatan, mutasi.tgl_mutasi, lokasi.nm_lokasi, departemen.nm_departemen FROM penempatan_item
          RIGHT JOIN penempatan ON penempatan_item.no_penempatan=penempatan.no_penempatan
          LEFT JOIN mutasi_asal ON penempatan.no_penempatan = mutasi_asal.no_penempatan_lama
          LEFT JOIN mutasi ON mutasi_asal.no_mutasi = mutasi.no_mutasi
          LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
          LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
          WHERE penempatan_item.kd_inventaris = '$Kode' AND penempatan_item.no_penempatan = '$penempatan'";
          $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query salah : " . mysql_error());
          $my2Data = mysql_fetch_array($my2Qry);
          $status = $my2Data['status_aktif'];
          $tglMulai = $my2Data['tgl_penempatan'];
          $tglAkhir = $my2Data['tgl_mutasi'];
          $infoLokasi  = $my2Data['nm_lokasi'];
          $infoDepartemen = $my2Data['nm_departemen'];
        }
        // Mencari Siapa Penempatan Barang
        if ($myData['status_barang'] == "Dipinjam") {
          $my3Sql = "SELECT PI.no_peminjaman, PI.kd_inventaris, peminjaman.tgl_peminjaman, peminjaman.tgl_kembali, peminjaman.status_kembali, pegawai.nm_pegawai, departemen.nm_departemen FROM peminjaman_item as PI
          LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
          LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
          LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
          WHERE PI.kd_inventaris='$Kode' AND peminjaman.no_peminjaman = '$peminjaman'";
          $my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query salah : " . mysql_error());
          $my3Data = mysql_fetch_array($my3Qry);
          $status = $my3Data['status_kembali'];
          $tglMulai = $my3Data['tgl_peminjaman'];
          $tglAkhir = $my3Data['tgl_kembali'];
          $infoLokasi  = $my3Data['nm_pegawai'];
          $infoDepartemen = $my3Data['nm_departemen'];
        }

        if ($myData['status_barang'] == "Tersedia") {
          if ($peminjaman != '') {
            $my4Sql = "SELECT barang_inventaris.*, peminjaman_item.no_peminjaman, peminjaman.tgl_peminjaman, peminjaman.tgl_kembali, peminjaman.status_kembali, pegawai.nm_pegawai, departemen.nm_departemen FROM barang_inventaris
              LEFT JOIN peminjaman_item ON barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris
              LEFT JOIN peminjaman ON peminjaman_item.no_peminjaman = peminjaman.no_peminjaman
              LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
              LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen WHERE peminjaman.no_peminjaman = '$peminjaman' AND peminjaman.status_kembali = 'Kembali'";
            $my4Qry = mysql_query($my4Sql, $koneksidb)  or die("Query salah : " . mysql_error());
            $my4Data = mysql_fetch_array($my4Qry);
            $pj = $my4Data['status_kembali'];
            $status = $my4Data['status_kembali'];
            $tglMulai = $my4Data['tgl_peminjaman'];
            $tglAkhir = $my4Data['tgl_kembali'];
            $infoLokasi  = $my4Data['nm_pegawai'];
            $infoDepartemen = $my4Data['nm_departemen'];
          }
        }

        // gradasi warna
        if ($nomor % 2 == 1) {
          $warna = "";
        } else {
          $warna = "#F5F5F5";
        }
      ?>
        <?php if ($myData['status_barang'] == "Ditempatkan") { ?>
          <tr bgcolor="<?php echo $warna; ?>">
            <td><?php echo $nomor; ?>.</td>
            <td><?php echo $penempatan; ?></td>
            <td><?php echo $my2Data['kd_inventaris']; ?></td>
            <?php if ($status == 'No') { ?>
              <td>Sudah Dimutasi</td>
            <?php } else { ?>
              <td><?php echo $myData['status_barang']; ?></td>
            <?php } ?>
            <td><?php echo IndonesiaTgl($tglMulai); ?></td>
            <?php if ($status == 'No') { ?>
              <td><?php echo IndonesiaTgl($tglAkhir); ?></td>
            <?php } else { ?>
              <td> - </td>
            <?php } ?>
            <td><?php echo $infoLokasi; ?></td>
            <td><?php echo $infoDepartemen; ?></td>
          </tr>
        <?php } ?>

        <?php if ($myData['status_barang'] == "Dipinjam") { ?>
          <tr bgcolor="<?php echo $warna; ?>">
            <td><?php echo $nomor; ?>.</td>
            <td><?php echo $peminjaman; ?></td>
            <td><?php echo $myData['kd_inventaris'] ?></td>
            <?php if ($status == 'Kembali') { ?>
              <td>Dikembalikan</td>
            <?php } else { ?>
              <td><?php echo $myData['status_barang'] ?></td>
            <?php } ?>
            <td><?php echo IndonesiaTgl($tglMulai); ?></td>
            <?php if ($status == 'Kembali') { ?>
              <td><?php echo IndonesiaTgl($tglAkhir); ?></td>
            <?php } else { ?>
              <td> - </td>
            <?php } ?>
            <td><?php echo $infoLokasi; ?></td>
            <td><?php echo $infoDepartemen; ?></td>
          </tr>
        <?php }  ?>

        <?php if ($myData['status_barang'] == "Tersedia") { ?>
          <?php if ($peminjaman != '') { ?>
            <tr bgcolor="<?php echo $warna; ?>">
              <td><?php echo $nomor; ?>.</td>
              <td><?php echo $my4Data['no_peminjaman'] ?></td>
              <td><?php echo $my4Data['kd_inventaris'] ?></td>
              <td>Dikembalikan</td>
              <td><?php echo IndonesiaTgl($tglMulai); ?></td>
              <td><?php echo IndonesiaTgl($tglAkhir); ?></td>
              <td><?php echo $infoLokasi; ?></td>
              <td><?php echo $infoDepartemen; ?></td>
            </tr>
          <?php }  ?>
        <?php }  ?>
      <?php } ?>
    </tbody>
  </table>
</div>