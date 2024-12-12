<?php
include_once "library/inc.seslogin.php";

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal  = ""; 
$tglAkhir = "";

# Set Tanggal skrg
$tglAwal  = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAwal  = isset($_POST['txtTanggalAwal']) ? $_POST['txtTanggalAwal'] : $tglAwal;

$tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');
$tglAkhir   = isset($_POST['txtTanggalAkhir']) ? $_POST['txtTanggalAkhir'] : $tglAkhir; 

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
  $filterSQL = "WHERE ( tgl_mutasi BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
  $filterSQL = "";
}


# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
  // Buka file
  echo "<script>";
  echo "window.open('cetak/mutasi_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir', width=330,height=330,left=100, top=25)";
  echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM mutasi $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml   = mysql_num_rows($pageQry);
$max   = ceil($jml/$row);
?>
<div class="table-border">
<h2>LAPORAN DATA MUTASI PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="770"><input name="txtTanggalAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d
        <input name="txtTanggalAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " />
          <input name="btnCetak" type="submit"  value=" Cetak " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="63" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>No. Mutasi</strong></td>
    <td width="140" bgcolor="#CCCCCC"><strong>Lokasi Lama </strong></td>
    <td width="110" bgcolor="#CCCCCC"><strong>No. Penempatan </strong></td>
    <td width="154" bgcolor="#CCCCCC"><strong>Lokasi Baru </strong></td>
    <td width="139" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="82" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
  // Perintah untuk menampilkan data Mutasi
  $mySql = "SELECT mutasi.*, lokasi.nm_lokasi FROM mutasi 
        JOIN mutasi_tujuan ON mutasi.no_mutasi=mutasi_tujuan.no_mutasi
        JOIN penempatan ON penempatan.no_penempatan=mutasi_tujuan.no_penempatan
        LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
        $filterSQL
        ORDER BY mutasi.no_mutasi DESC LIMIT $hal, $row";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
  $nomor = $hal; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
    
    # Membaca Kode mutasi/ Nomor transaksi
    $noMutasi = $myData['no_mutasi'];

    # Perintah untuk mendapatkan data dari hasil Penempatan Baru
    $noPenempatan = $myData['no_penempatan'];
    $my2Sql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
          LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
          WHERE penempatan.no_penempatan='$noPenempatan'";
    $my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
    $my2Data = mysql_fetch_array($my2Qry);
    
    # Menghitung Total barang yang dimutasi setiap nomor transaksi
    $my3Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noPenempatan'";
    $my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
    $my3Data = mysql_fetch_array($my3Qry);
    
    // gradasi warna
    if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
  ?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $my2Data['nm_lokasi']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my3Data['total_barang']); ?></td>
    <td align="center"><a href="cetak/mutasi_cetak.php?noMutasi=<?php echo $noMutasi; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="6" align="right"><b>Halaman ke :</b>
        <?php
  for ($h = 1; $h <= $max; $h++) {
    $list[$h] = $row * $h - $row;
    echo " <a href='?open=Laporan-Mutasi-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
  }
  ?></td>
  </tr>
</table>
<br />
<a href="cetak/mutasi_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png"  border="0" title="Cetak ke Format HTML"/></a>
</div>