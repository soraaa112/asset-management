<?php
session_start();
include_once "library/inc.seslogin.php";

# Deklarasi variabel
$filterSQL   = "";
$tglAwal  = "";
$tglAkhir  = "";

# Set Tanggal skrg
$tglAwal   = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-" . date('m-Y');
$tglAwal   = isset($_POST['txtTanggalAwal']) ? $_POST['txtTanggalAwal'] : $tglAwal;

$tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');
$tglAkhir   = isset($_POST['txtTanggalAkhir']) ? $_POST['txtTanggalAkhir'] : $tglAkhir;

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
  $filterSQL = "WHERE ( tgl_peminjaman BETWEEN '" . InggrisTgl($tglAwal) . "' AND '" . InggrisTgl($tglAkhir) . "')";
} else {
  $filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
  // Buka file
  echo "<script>";
  //echo "window.open('cetak/peminjaman_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir', width=330,height=330,left=100, top=25)";
  echo "window.open('cetak/peminjaman_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
  echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris   = 50;
$hal   = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM peminjaman $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
$jml   = mysql_num_rows($pageQry);
$max   = ceil($jml / $baris);
?>
<div class="table-border">
  <h2>LAPORAN DATA PEMINJAMAN PER PERIODE</h2>
  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
    <table width="900" border="0" class="table-list">
      <tr>
        <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
      </tr>
      <tr>
        <td width="111"><strong>Periode </strong></td>
        <td width="5"><strong>:</strong></td>
        <td width="770"><input name="txtTanggalAwal" id="date" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
          s/d
          <input name="txtTanggalAkhir" id="date2" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" />
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input name="btnTampil" type="submit" value=" Tampilkan " />
        </td>
      </tr>
    </table>
  </form>

  <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
      <td width="110" bgcolor="#CCCCCC"><strong>No. Peminjaman</strong></td>
      <td width="229" bgcolor="#CCCCCC"><strong>Type barang</strong></td>
      <td width="120" bgcolor="#CCCCCC"><strong>Pegawai/ Peminjam </strong></td>
      <td width="100" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
      <td width="50" bgcolor="#CCCCCC"><strong>Status</strong></td>
      <td width="50" align="center" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
      <td width="37" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
    </tr>
    <?php
    if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
      if (isset($_POST['btnTampil'])) {
        $mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
        LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
        $filterSQL
        AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
        ORDER BY peminjaman.no_peminjaman DESC LIMIT $hal, $baris";
      } else {
        $mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
        LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
        $filterSQL
        WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'
        ORDER BY peminjaman.no_peminjaman DESC LIMIT $hal, $baris";
      }
      $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
      $nomor = $hal;
    } else {
      // Skrip menampilkan data Transaksi Peminjaman dilengkapi informasi Pegawai
      $mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
			LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
			LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
      LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
      LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
			$filterSQL
			ORDER BY peminjaman.no_peminjaman DESC LIMIT $hal, $baris";
      $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
      $nomor = $hal;
    }
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;

      // Membaca Kode peminjaman/ Nomor transaksi
      $noNota = $myData['no_peminjaman'];

      // Menghitung Total barang yang dipinjam setiap nomor transaksi
      $my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
      $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
      $my2Data = mysql_fetch_array($my2Qry);

      // gradasi warna
      if ($nomor % 2 == 1) {
        $warna = "";
      } else {
        $warna = "#F5F5F5";
      }
    ?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?></td>
        <td><?php echo $myData['no_peminjaman']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['nm_pegawai']; ?></td>
        <td><?php echo $myData['nm_departemen']; ?></td>
        <td><?php echo $myData['status_kembali']; ?></td>
        <td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
        <td align="center">
          <a href="cetak/peminjaman_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">
            <button class="btn btn-success" title="Cetak Data"><i class="fa fa-print"></i>
            </button>
          </a>
        </td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
      <td colspan="6" align="right"><b>Halaman ke :</b>
        <?php
        for ($h = 1; $h <= $max; $h++) {
          $list[$h] = $baris * $h - $baris;
          echo " <a href='?open=Laporan-Peminjaman-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
        }
        ?></td>
    </tr>
  </table>
  <br />
  <a href="cetak/peminjaman_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" border="0" title="Cetak ke Format HTML" /></a>
</div>