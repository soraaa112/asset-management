<body>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
  <?php
  include_once "library/inc.seslogin.php";

  $row = 10;
  $hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
  $pageSql = "SELECT * FROM kategori";
  $pageQry = mysqli_query($koneksidb, $pageSql) or die("error paging: " . mysql_error());
  $jml   = mysqli_num_rows($pageQry);
  $max   = ceil($jml / $row);

  ?>
  <div class="table-border">
    <h2> LAPORAN DATA KATEGORI </h2>
    <table id="example1" class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
      <thead>
        <tr>
          <td width="21" align="center" bgcolor="#CCCCCC"><b>No</b></td>
          <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
          <td width="608" bgcolor="#CCCCCC"><b>Nama Kategori </b></td>
          <td width="100" align="center" bgcolor="#CCCCCC"><b>Qty Barang </b> </td>
        </tr>
      </thead>
      <tbody>
        <?php
        // Menampilkan daftar kategori
        $mySql = "SELECT * FROM kategori ORDER BY kd_kategori ASC";
        $myQry = mysql_query($mySql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
        $nomor = $hal;
        while ($myData = mysql_fetch_array($myQry)) {
          $nomor++;
          $Kode = $myData['kd_kategori'];

          // Menghitung jumlah barang per Kategori
          $my2Sql = "SELECT COUNT(*) As qty_barang FROM barang WHERE kd_kategori='$Kode'";
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
            <td><?php echo $myData['kd_kategori']; ?></td>
            <td><?php echo $myData['nm_kategori']; ?></td>
            <td align="center"><?php echo $my2Data['qty_barang']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <a href="cetak/kategori.php" target="_blank"><img src="images/btn_print2.png" border="0" title="Cetak ke Format HTML" /></a>
  </div>