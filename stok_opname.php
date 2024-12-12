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
  # Deklarasi variabel
  $filterSQL = "";
  $SQL = "";
  $SQLPage = "";

  if (isset($userLogin)) {

		$mySql = "DELETE FROM tmp_mutasi WHERE kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my1Sql = "DELETE FROM tmp_opname WHERE kd_petugas='$userLogin'";
		mysql_query($my1Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my2Sql = "DELETE FROM tmp_peminjaman WHERE kd_petugas='$userLogin'";
		mysql_query($my2Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my3Sql = "DELETE FROM tmp_penempatan WHERE kd_petugas='$userLogin'";
		mysql_query($my3Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my4Sql = "DELETE FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
		mysql_query($my4Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());

		$my5Sql = "DELETE FROM tmp_service WHERE kd_petugas='$userLogin'";
		mysql_query($my5Sql, $koneksidb) or die("Gagal menghapus tmp : " . mysql_error());
	}

  # BACA VARIABEL KATEGORI
  $kodeKategori = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
  $kodeKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;
  # Set Tanggal skrg
  $statusBarang = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
  $statusBarang = isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : $statusBarang;


  # PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
  if (isset($_POST['btnCari'])) {
    $txtKataKunci  = trim($_POST['txtKataKunci']);

    // Pencarian Multi String (beberapa kata)
    $keyWord     = explode(" ", $txtKataKunci);
    $cariSQL    = " WHERE opname_item.kd_inventaris='$txtKataKunci' OR barang.nm_barang LIKE '%$txtKataKunci%' ";
    // if (count($keyWord) > 1) {
    //   foreach ($keyWord as $kata) {
    //     $cariSQL  .= " OR barang.nm_barang LIKE'%$kata%'";
    //   }
    // }

    if (trim($_POST['cmbKategori']) == "Semua") {
      //Query #1 (all)
      if ($_POST['cmbStatus'] == "Semua") {
        $filterSQL   = $cariSQL;
      } else {
        $filterSQL = $cariSQL . "AND opname.status='$statusBarang'";
      }
    } else {
      //Query #2 (filter)
      if ($_POST['cmbStatus'] == "Semua") {
        $filterSQL   = $cariSQL . " AND barang.kd_kategori ='$kodeKategori'";
      } else {
        $filterSQL = $cariSQL . "AND barang.kd_kategori ='$kodeKategori' AND opname.status='$statusBarang'";
      }
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
  $pageSql = "SELECT opname_item.*, opname.*, barang.nm_barang FROM opname 
  LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
  LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
  LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
  LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
  $filterSQL GROUP BY opname_item.kd_inventaris ORDER BY opname_item.kd_inventaris ASC ";
  $pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
  $jml   = mysql_num_rows($pageQry);
  $max   = ceil($jml / $row);
  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">
      <h2>TAMPIL DATA STOK OPNAME <a href="?open=Stok-Add" target="_self"><img style='padding-right:0px !important' src="images/btn_add_data.png" border="0" /></a></h2>
      <form style='padding-top:0px !important' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
        <table width="900" border="0" class="table-list">
          <tr>
            <td colspan="9" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
          </tr>
          <tr>
            <td width="134"><strong> Kategori </strong></td>
            <td width="5"><strong>:</strong></td>
            <td width="741">
              <select name="cmbKategori" data-live-search="true" class="selectpicker">
                <option value="Semua"> Semua </option>
                <?php
                $mySql = "SELECT * FROM kategori ORDER BY kd_kategori";
                $myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
                while ($myData = mysql_fetch_array($myQry)) {
                  if ($kodeKategori == $myData['kd_kategori']) {
                    $cek = " selected";
                  } else {
                    $cek = "";
                  }
                  echo "<option value='$myData[kd_kategori]' $cek>$myData[nm_kategori]</option>";
                }
                $mySql = "";
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td width="134"><strong> Status </strong></td>
            <td width="5"><strong>:</strong></td>
            <td width="70">
              <select name="cmbStatus" data-live-search="true" class="selectpicker">
                <option value="Semua"> Semua </option>
                <?php
                foreach ($status as $nilai) {
                  if ($statusBarang == $nilai) {
                    $cek = " selected";
                  } else {
                    $cek = "";
                  }
                  echo "<option value='$nilai' $cek>$nilai</option>";
                }
                ?>
              </select>
              <input name="btnCari" type="submit" value=" Tampilkan " />
            </td>
          </tr>
        </table>
      </form>
      <table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
        <thead>
          <tr>
            <td width="50" bgcolor="#CCCCCC"><strong>No</strong></td>
            <td width="100" bgcolor="#CCCCCC"><strong>Kode Opname</strong></td>
            <td width="130" bgcolor="#CCCCCC"><strong>Kode Label</strong></td>
            <td width="320" bgcolor="#CCCCCC"><strong>Type</strong></td>
            <td width="100" bgcolor="#CCCCCC"><strong>Tgl Opname</strong></td>
            <td width="100" bgcolor="#CCCCCC"><strong>Kondisi</strong></td>
            <td width="100" bgcolor="#CCCCCC"><strong>Status</strong></td>
            <td width="150" bgcolor="#CCCCCC"><strong>Foto Barang</strong></td>
            <td width="60" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
          </tr>
        </thead>
        <tbody>
          <?php
          # Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
          $mySql  = "SELECT opname.*, barang.nm_barang, barang_inventaris.kd_inventaris 
          FROM opname
          LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
          LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
          LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
          LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori 
          $filterSQL 
          ORDER BY kd_opname ASC";
          $myQry = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
          $nomor  = $hal;
          while ($myData = mysql_fetch_array($myQry)) {
            $nomor++;
            $Kode = $myData['kd_opname'];

            // gradasi warna
            if ($nomor % 2 == 1) {
              $warna = "";
            } else {
              $warna = "#F5F5F5";
            }
          ?>
            <tr bgcolor="<?php echo $warna; ?>">
              <td><?php echo $nomor; ?></td>
              <td><?php echo $myData['kd_opname']; ?></td>
              <td><?php echo $myData['kd_inventaris']; ?></td>
              <td><?php echo $myData['nm_barang']; ?></td>
              <td><?php echo IndonesiaTgl($myData['tahun_opname']); ?></td>
              <td><?php echo $myData['keterangan']; ?></td>
              <td><?php echo $myData['status']; ?></td>
              <td><?php
                  $ex = explode(';', $myData['foto_barang']);
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
                <a href="?open=Stok-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('YAKIN AKAN MENGHAPUS DATA OPNAME INI ... ?')">
                  <button class="btn btn-danger" title="Hapus Data"><i class="fa fa-trash"></i>
                  </button>
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>