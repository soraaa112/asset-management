<?php
session_start();
# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:" . mysql_error());
$jml   = mysql_num_rows($pageQry);
$max   = ceil($jml / $row);
?>
<div class="table-border">
  <h2>LAPORAN DATA BARANG</h2>
  <table id='example1' class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
    <thead>
      <tr>
        <td width="23" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="261" bgcolor="#CCCCCC"><strong>Type</strong></td>
        <td width="261" bgcolor="#CCCCCC"><strong>Foto</td>
        <td width="155" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
        <td width="67" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
        <td width="73" align="right" bgcolor="#CCCCCC"><strong> Tersedia </strong></td>
        <td width="92" align="right" bgcolor="#CCCCCC"><strong>Ditempatkan</strong></td>
        <td width="93" align="right" bgcolor="#CCCCCC"><strong>Dipinjam</strong></td>
        <td width="40" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
      </tr>
    </thead>
    <tbody>
      <?php
      if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
        // Query menampilkan data Inventaris per Kode barang
        $mySql = "SELECT barang.*, kategori.nm_kategori, departemen.nm_departemen FROM barang
              LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
              LEFT JOIN pengadaan_item ON barang.kd_barang = pengadaan_item.kd_barang
              LEFT JOIN pengadaan ON pengadaan_item.no_pengadaan = pengadaan.no_pengadaan
              LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
              LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
              WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'
              ORDER BY barang.kd_barang ASC LIMIT $hal, $row";
        $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
      } else {
        # MENJALANKAN QUERY
        $mySql   = "SELECT barang.*, kategori.nm_kategori FROM barang 
				LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
				ORDER BY barang.kd_barang ASC LIMIT $hal, $row";
        $myQry   = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
      }
      $nomor  = $hal;
      while ($myData = mysql_fetch_array($myQry)) {
        $nomor++;
        $Kode = $myData['kd_barang'];

        // Membuat variabel akan diisi angka
        $jumTersedia = 0;
        $jumDitempatkan = 0;
        $jumDipinjam = 0;

        // Query menampilkan data Inventaris per Kode barang
        $my2Sql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";
        $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
        while ($my2Data = mysql_fetch_array($my2Qry)) {
          if ($my2Data['status_barang'] == "Tersedia") {
            $jumTersedia++;
          }

          if ($my2Data['status_barang'] == "Ditempatkan") {
            $jumDitempatkan++;
          }

          if ($my2Data['status_barang'] == "Dipinjam") {
            $jumDipinjam++;
          }
        }
        // gradasi warna
        if ($nomor % 2 == 1) {
          $warna = "";
        } else {
          $warna = "#F5F5F5";
        }
      ?>
        <tr bgcolor="<?php echo $warna; ?>">
          <td><?php echo $nomor; ?></td>
          <td><?php echo $myData['kd_barang']; ?></td>
          <td><?php echo $myData['nm_barang']; ?></td>
          <td><?php
              $ex = explode(';', $myData['foto']);
              $no = 1;
              for ($i = 0; $i < count($ex); $i++) {
                if ($ex[$i] != '') {
                  echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'>" . $ex[$i] . "</a>, ";
                }
                $no++;
              }
              ?></td>
          <td><?php echo $myData['nm_kategori']; ?></td>
          <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $myData['jumlah']; ?></td>
          <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumTersedia; ?></td>
          <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDitempatkan; ?></td>
          <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDipinjam; ?></td>
          <td align="center">
            <a href="cetak/barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank">
              <button class="btn btn-success" title="Cetak Data"><i class="fa fa-print"></i>
              </button>
            </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <center> <a href="cetak/barang.php" target="_blank"><img style='float:none !important' src="images/btn_print2.png" border="0" title="Cetak ke Format HTML" /></a></center>

</div>