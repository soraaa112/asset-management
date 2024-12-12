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

  if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    # Pegawai terpilih
    $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : $_SESSION['SES_UNIT'];
    $kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;
  } else {
    $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
    $kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;
  }

  if (trim($kodeDepartemen) == "Semua") {
    $filterSQL = "";
  } else {
    $filterSQL = "WHERE lokasi.kd_departemen='$kodeDepartemen'";
  }

  $row = 10;
  $hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
  if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    $pageSql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen WHERE departemen.nm_departemen = '$_SESSION[SE_UNIT]'";
  } else {
    $pageSql = "SELECT * FROM lokasi $filterSQL";
  }
  $pageQry = mysqli_query($koneksidb, $pageSql) or die("error paging: " . mysql_error());
  $jml   = mysqli_num_rows($pageQry);
  $max   = ceil($jml / $row);

  ?>
  <div style="overflow-x:auto;">
    <div class="table-border">
      <h2> LAPORAN DATA LOKASI </h2>
      <form style='margin-top:-10px' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
        <table width="100%" border="0" class="table-list">
          <tr>
            <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
          </tr>
          <tr>
            <td width="134"><b> Departemen </b></td>
            <td width="5"><b>:</b></td>
            <td width="741">
              <?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) { ?>
                <select name="cmbDepartemen" data-live-search="true" class="selectpicker">
                  <?php
                  $mySql = "SELECT * FROM departemen WHERE nm_departemen='$_SESSION[SES_UNIT]' ORDER BY kd_departemen";
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
              <?php } else { ?>
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
              <?php } ?>
              <input name="btnTampil" type="submit" value=" Tampilkan " />
            </td>
          </tr>
        </table>
      </form>
      <table id="example1" class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
        <thead>
          <tr>
            <td width="23" align="center" bgcolor="#CCCCCC"><b>No</b></td>
            <td width="54" bgcolor="#CCCCCC"><strong>Kode</strong></td>
            <td width="380" bgcolor="#CCCCCC"><b>Nama Lokasi </b></td>
            <td width="322" bgcolor="#CCCCCC"><b>Departemen </b></td>
          </tr>
        </thead>
        <tbody>
          <?php
          // Menampilkan data Lokasi, dilengkapi dengan data Departemen dari tabel relasi
          if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
            $mySql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi 
            LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
            WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]' ORDER BY kd_lokasi ASC";
          } else {
            $mySql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi 
            LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
            $filterSQL ORDER BY kd_lokasi ASC";
          }
          $myQry = mysql_query($mySql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
          $nomor = $hal;
          while ($myData = mysql_fetch_array($myQry)) {
            $nomor++;
            $Kode = $myData['kd_lokasi'];

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
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <a href="cetak/lokasi.php" target="_blank"><img src="images/btn_print2.png" border="0" title="Cetak ke Format HTML" /></a>
    </div>
  </div>