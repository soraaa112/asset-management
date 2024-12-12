<?php
include_once "library/inc.seslogin.php";

$row = 10;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM departemen";
$pageQry = mysqli_query($koneksidb, $pageSql) or die("error paging: " . mysql_error());
$jml   = mysqli_num_rows($pageQry);
$max   = ceil($jml / $row);

?>
<div style="overflow-x:auto;">
  <div class="table-border">
    <h2> LAPORAN DATA DEPARTEMEN </h2>
    <table id="example1" class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
      <thead>
        <tr>
          <td width="20" align="center" bgcolor="#CCCCCC"><b>No</b></td>
          <td width="50" align="center" bgcolor="#CCCCCC"><strong>Kode</strong></td>
          <td width="251" bgcolor="#CCCCCC"><b>Nama Departemen </b></td>
          <td width="200" align="center" bgcolor="#CCCCCC"><b>Qty Lokasi </b> </td>
        </tr>
      </thead>
      <tbody>
        <?php
        // Menampilkan data Departemen
        $mySql = "SELECT * FROM departemen ORDER BY kd_departemen ASC";
        $myQry = mysql_query($mySql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
        $nomor = $hal;
        while ($myData = mysql_fetch_array($myQry)) {
          $nomor++;
          $Kode = $myData['kd_departemen'];

          // Menghitung jumlah lokasi/lokasi per departemen
          $my2Sql = "SELECT COUNT(*) As qty_lokasi FROM lokasi WHERE kd_departemen='$Kode'";
          $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query salah : " . mysql_error());
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
            <td align="center"><?php echo $myData['kd_departemen']; ?></td>
            <td><?php echo $myData['nm_departemen']; ?></td>
            <td align="center" bgcolor="<?php echo $warna; ?>"><?php echo $my2Data['qty_lokasi']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <a href="cetak/departemen.php" target="_blank"><img src="images/btn_print2.png" border="0" title="Cetak ke Format HTML" /></a>
  </div>
</div>