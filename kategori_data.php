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
  $pageSql = "SELECT * FROM kategori";
  $pageQry = mysql_query($pageSql, $koneksidb) or die("error: " . mysql_error());
  $jml   = mysql_num_rows($pageQry);
  $max   = ceil($jml / $row);
  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">

      <h2><b>DATA KATEGORI</b><a href="?open=Kategori-Add" target="_self"><img src="images/btn_add_data.png" border="0" /></a></h2>

      <table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
        <thead>
          <tr>
            <th width="40">
              <center><b>No</b></center>
            </th>
            <th width="100"><b>Kode</b></th>
            <th width="400"><b>Nama Kategori </b></th>
            <th width="250"><b>Deskripsi </b></th>
            <th width="100">
              <center><b>Qty Barang </b></center>
            </th>
            <th width="100">
              <center><b>Aksi</b></center>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Menampilkan daftar kategori
          $mySql = "SELECT * FROM kategori ORDER BY kd_kategori ASC";
          $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
          $nomor = $hal;
          while ($myData = mysql_fetch_array($myQry)) {
            $nomor++;
            $Kode = $myData['kd_kategori'];
            $Kategori = $myData['nm_kategori'];

            // Menghitung jumlah barang per Kategori
            $my2Sql = "SELECT COUNT(*) As qty_barang FROM barang WHERE kd_kategori='$Kode'";
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
              <td><?php echo $myData['kd_kategori']; ?></td>
              <td><?php echo $myData['nm_kategori']; ?></td>
              <td><?php echo $myData['deskripsi']; ?></td>
              <td align="center"><?php echo $my2Data['qty_barang']; ?></td>
              <td align="center">
                <a href="?open=Kategori-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('YAKIN AKAN MENGHAPUS DATA KATEGORI ( <?php echo $Kategori; ?> ) INI ... ?')">
                  <button class="btn btn-danger" title="Hapus Data"><i class="fa fa-trash"></i>
                  </button>
                </a>
                &nbsp;
                <a href="?open=Kategori-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">
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