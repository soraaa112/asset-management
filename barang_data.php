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
  $dataKategori  = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua'; // dari URL
  $dataKategori  = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $dataKategori; // dari Form

  if (isset($_POST['btnTampil'])) {
    if (trim($_POST['cmbKategori']) == "Semua") {
      //Query #1 (all)
      $filterSQL   = "";
    } else {
      //Query #2 (filter)
      $filterSQL   = " WHERE barang.kd_kategori ='$dataKategori'";
    }
  } else {
    //Query #1 (all)
    $filterSQL   = "";
  }

  # Simpan Variabel TMP
  $dataKataKunci = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

  # UNTUK PAGING (PEMBAGIAN HALAMAN)
  $row = 10;
  $hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
  $pageSql = "SELECT barang.*, kategori.nm_kategori FROM barang
  LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
  $filterSQL";
  $pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
  $jml   = mysql_num_rows($pageQry);
  $max   = ceil($jml / $row);
  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">
      <h2><b>DATA ASET BARANG </b><a href="?open=Barang-Add" target="_self"><img src="images/btn_add_data.png" border="0" /></a></h2>
      <form style='margin-top:-10px' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
        <table width="100%" border="0" class="table-list" cellspacing="1" cellpadding="2">
          <tr>
            <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
          </tr>
          <tr>
            <td width="159"><b>Nama Kategori </b></td>
            <td width="5"><b>:</b></td>
            <td width="716"><select name="cmbKategori" data-live-search="true" class="selectpicker">
                <option value="Semua"> Pilih Kategori </option>
                <?php
                // Menampilkan data Kategori
                $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
                $dataQry = mysql_query($dataSql, $koneksidb) or die("Gagal Query" . mysql_error());
                while ($dataRow = mysql_fetch_array($dataQry)) {
                  if ($dataKategori == $dataRow['kd_kategori']) {
                    $cek = " selected";
                  } else {
                    $cek = "";
                  }
                  echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
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
            <th width="23">
              <center><strong>No</strong></center>
            </th>
            <th width="51"><strong>Kode</strong></th>
            <th width="317"><strong>Type</strong></th>
            <th width="70">
              <center><strong>Jumlah</strong></center>
            </th>
            <th width="80"><strong>Satuan</strong></th>
            <th width="200">Foto</th>
            <th width="100">
              <center><strong>Aksi</strong></center>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Menampilkan data Barang
          $mySql = "SELECT * FROM barang $filterSQL ORDER BY kd_barang ASC";
          $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
          $nomor = $hal;
          while ($myData = mysql_fetch_array($myQry)) {
            $nomor++;
            $Kode = $myData['kd_barang'];
            $Barang = $myData['nm_barang'];

            // gradasi warna
            if ($nomor % 2 == 1) {
              $warna = "";
            } else {
              $warna = "#F5F5F5";
            }
          ?>
            <tr bgcolor="<?php echo $warna; ?>">
              <td align="center"><?php echo $nomor; ?></td>
              <td><?php echo $myData['kd_barang']; ?></td>
              <td><?php echo $myData['nm_barang']; ?></td>
              <td align="center"><?php echo $myData['jumlah']; ?></td>
              <td><?php echo $myData['satuan']; ?></td>
              <td><?php
                  $ex = explode(';', $myData['foto']);
                  $no = 1;
                  for ($i = 0; $i < count($ex); $i++) {
                    if ($ex[$i] != '') {
                      echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'>" . $ex[$i] . "</a>, ";
                    }
                    $no++;
                  }
                  ?>
              </td>
              <td align="center">
                <a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('YAKIN AKAN MENGHAPUS DATA BARANG ( <?php echo $Barang; ?> ) INI ... ?')">
                  <button class="btn btn-danger" title="Hapus Data"><i class="fa fa-trash"></i>
                  </button>
                </a>
                &nbsp;
                <a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">
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