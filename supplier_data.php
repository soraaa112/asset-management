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

  # UNTUK PAGING (PEMBAGIAN HALAMAN)
  $row = 10;
  $hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
  $pageSql = "SELECT * FROM supplier";
  $pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
  $jml   = mysql_num_rows($pageQry);
  $max   = ceil($jml / $row);
  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">
      <h2><b>DATA SUPPLIER </b><a href="?open=Supplier-Add" target="_self"><img src="images/btn_add_data.png" border="0" /></a></h2>
      <table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
        <thead>
          <tr>
            <th width="15" align="center">No.</th>
            <th width="45">Kode</th>
            <th width="180">Nama Supplier </th>
            <th width="412">Alamat</th>
            <th width="120">No. Telepon </th>
            <th width="140">
              <center><b>Aksi</b></center>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Skrip menampilkan data Supplier
          $mySql = "SELECT * FROM supplier ORDER BY kd_supplier ASC";
          $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
          $nomor = $hal;
          while ($myData = mysql_fetch_array($myQry)) {
            $nomor++;
            $Kode = $myData['kd_supplier'];

            // gradasi warna
            if ($nomor % 2 == 1) {
              $warna = "";
            } else {
              $warna = "#F5F5F5";
            }
          ?>
            <tr bgcolor="<?php echo $warna; ?>">
              <td><?php echo $nomor; ?>.</td>
              <td><?php echo $myData['kd_supplier']; ?></td>
              <td><?php echo $myData['nm_supplier']; ?></td>
              <td><?php echo $myData['alamat']; ?></td>
              <td><?php echo $myData['no_telepon']; ?></td>
              <td width="40" align="center">
                <a href="?open=Supplier-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('YAKIN AKAN MENGHAPUS DATA SUPPLIER INI ... ?')">
                  <button class="btn btn-danger" title="Hapus Data"><i class="fa fa-trash"></i>
                  </button>
                </a>
                &nbsp;
                <a href="?open=Supplier-Edit&Kode=<?php echo $Kode; ?>" target="_self">
                  <button class="btn btn-warning" title="Edit Data"><i class="fa fa-pencil"></i>
                  </button>
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>