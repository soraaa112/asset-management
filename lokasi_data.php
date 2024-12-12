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

  // Variabel SQL
  $filterSQL = "";

  // Temporary Variabel form
  $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
  $kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;

  if (trim($kodeDepartemen) == "Semua") {
    $filterSQL = "";
  } else {
    $filterSQL = "WHERE lokasi.kd_departemen='$kodeDepartemen'";
  }

  # UNTUK PAGING (PEMlokasi HALAMAN)
  $row = 10;
  $hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
  $pageSql = "SELECT * FROM lokasi $filterSQL";
  $pageQry = mysql_query($pageSql, $koneksidb) or die("error: " . mysql_error());
  $jml   = mysql_num_rows($pageQry);
  $max   = ceil($jml / $row);
  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">
      <h2><b>DATA LOKASI</b><a href="?open=Lokasi-Add" target="_self"><img src="images/btn_add_data.png" border="0" /></a></h2>
      <form style='margin-top:-10px' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
        <table width="100%" border="0" class="table-list">
          <tr>
            <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
          </tr>
          <tr>
            <td width="134"><b> Departemen </b></td>
            <td width="5"><b>:</b></td>
            <td width="741">
                <select name="cmbDepartemen" data-live-search="true" class="selectpicker">
                  <option value="Semua">Semua</option>
                  <?php
                  $mySql = "SELECT * FROM departemen ORDER BY kd_departemen";
                  $myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
                  while ($myData = mysql_fetch_array($myQry)) {
                    if ($kodeDepartemen == $myData['kd_departemen']) {
                      $cek = " selected";
                    } else {
                      $cek = "";
                    }
                    echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen]</option>";
                  }
                  $mySql = "";
                  ?>
                </select>
              <input name="btnTampil" type="submit" value=" Tampilkan " />
            </td>
          </tr>
        </table>
      </form>

      <table id="example1" class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
        <thead>
          <tr>
            <th width="20" align="center"><b>No</b></th>
            <th width="50">Kode</th>
            <th width="250"><b>Nama Lokasi </b></th>
            <th width="350"><b>Departemen </b> </th>
            <th width="100">
              <center><b>Aksi</b></center>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Menampilkan data Lokasi, dilengkapi dengan data Departemen dari tabel relasi
          $mySql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi 
          LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
          $filterSQL
          ORDER BY kd_lokasi ASC";
          $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
          $nomor = $hal;
          while ($myData = mysql_fetch_array($myQry)) {
            $nomor++;
            $Kode = $myData['kd_lokasi'];
            $lokasi = $myData['nm_lokasi'];

            // gradasi warna
            if ($nomor % 2 == 1) {
              $warna = "";
            } else {
              $warna = "#F5F5F5";
            }
          ?>
            <tr bgcolor="<?php echo $warna; ?>">
              <td align="center"><?php echo $nomor; ?></td>
              <td><?php echo $myData['kd_lokasi']; ?></td>
              <td><?php echo $myData['nm_lokasi']; ?></td>
              <td><?php echo $myData['nm_departemen']; ?></td>
              <td align="center">
                <a href="?open=Lokasi-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('AKAN MENGHAPUS DATA LOKASI ( <?php echo $lokasi; ?> ) INI ... ?')">
                  <button class="btn btn-danger" title="Hapus Data"><i class="fa fa-trash"></i>
                  </button>
                </a>
                &nbsp;
                <a href="?open=Lokasi-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">
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