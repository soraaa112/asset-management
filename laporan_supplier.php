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
  $pageSql = "SELECT * FROM supplier";
  $pageQry = mysqli_query($koneksidb, $pageSql) or die("error paging: " . mysql_error());
  $jml   = mysqli_num_rows($pageQry);
  $max   = ceil($jml / $row);

  ?>
  <div style="overflow-x:auto;">
    <div class="table-border">
      <h2> LAPORAN DATA SUPPLIER </h2>
      <table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
        <thead>
          <tr>
            <td width="24" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
            <td width="51" bgcolor="#CCCCCC"><strong>Kode</strong></td>
            <td width="200" bgcolor="#CCCCCC"><strong>Nama Supplier </strong></td>
            <td width="475" bgcolor="#CCCCCC"><strong>Alamat Lengkap </strong></td>
            <td width="124" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
          </tr>
        </thead>
        <tbody>
          <?php
          // Menampilkan data Supplier
          $mySql = "SELECT * FROM supplier ORDER BY kd_supplier ASC";
          $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
          $nomor = $hal;
          while ($myData = mysql_fetch_array($myQry)) {
            $nomor++;

            // gradasi warna
            if ($nomor % 2 == 1) {
              $warna = "";
            } else {
              $warna = "#F5F5F5";
            }
          ?>
            <tr bgcolor="<?php echo $warna; ?>">
              <td align="center"><?php echo $nomor; ?></td>
              <td><?php echo $myData['kd_supplier']; ?></td>
              <td><?php echo $myData['nm_supplier']; ?></td>
              <td><?php echo $myData['alamat']; ?></td>
              <td><?php echo $myData['no_telepon']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <a href="cetak/supplier.php" target="_blank"><img src="images/btn_print2.png" border="0" title="Cetak ke Format HTML" /></a>
    </div>
  </div>