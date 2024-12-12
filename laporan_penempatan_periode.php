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

  if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    # Pegawai terpilih
    $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : $_SESSION['SES_UNIT'];
  }

  # BACA VARIABEL KATEGORI
  $kodeKategori = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
  $kodeKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

  # PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
  if (isset($_POST['btnCari'])) {
    $txtKataKunci  = trim($_POST['txtKataKunci']);

    // Pencarian Multi String (beberapa kata)
    $keyWord     = explode(" ", $txtKataKunci);
    $cariSQL    = " WHERE barang_inventaris.kd_inventaris='$txtKataKunci' OR barang.nm_barang LIKE '%$txtKataKunci%' ";
    // if (count($keyWord) > 1) {
    //   foreach ($keyWord as $kata) {
    //     $cariSQL  .= " OR barang.nm_barang LIKE'%$kata%'";
    //   }
    // }

    if (trim($_POST['cmbKategori']) == "Semua") {
      //Query #1 (all)
      $filterSQL   = $cariSQL . "AND penempatan_item.status_aktif='Yes'";
    } else {
      //Query #2 (filter)
      $filterSQL   = $cariSQL . " AND barang.kd_kategori ='$kodeKategori' AND penempatan_item.status_aktif='Yes'";
    }
  } else {
    //Query #1 (all)
    $filterSQL   = "WHERE penempatan_item.status_aktif='Yes'";
  }

  # Simpan Variabel TMP
  $dataKataKunci = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

  # UNTUK PAGING (PEMBAGIAN HALAMAN)
  $row = 10;
  $hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
  if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    $pageSql = "SELECT penempatan.*, penempatan_item.*, kategori.nm_kategori, barang.nm_barang, departemen.nm_departemen FROM penempatan 
    LEFT JOIN penempatan_item ON penempatan.no_penempatan = penempatan_item.no_penempatan
    LEFT JOIN departemen ON penempatan.kd_departemen=departemen.kd_departemen
    LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris = barang_inventaris.kd_inventaris
    LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
    LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
    $filterSQL AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' GROUP BY penempatan_item.no_penempatan ORDER BY penempatan_item.no_penempatan ASC";
  } else {
    $pageSql = "SELECT penempatan.*, penempatan_item.*, kategori.nm_kategori, barang.nm_barang FROM penempatan 
    LEFT JOIN penempatan_item ON penempatan.no_penempatan = penempatan_item.no_penempatan
    LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris = barang_inventaris.kd_inventaris
    LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
    LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
    $filterSQL GROUP BY penempatan_item.no_penempatan ORDER BY penempatan_item.no_penempatan ASC";
  }
  $pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
  $jml   = mysql_num_rows($pageQry);
  $max   = ceil($jml / $row);
  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">
      <h2>LAPORAN DATA PENEMPATAN</h2>
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
        <table width="900" border="0" class="table-list">
          <tr>
            <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
          </tr>
          <tr>
            <td width="134"><strong> Kategori </strong></td>
            <td width="5"><strong>:</strong></td>
            <td width="741">
              <select name="cmbKategori" data-live-search="true" class="selectpicker">
                <option value="Semua"> Semua Kategori </option>
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
            <td><strong>Cari Barang </strong></td>
            <td><strong>:</strong></td>
            <td><input id="txtBarang" name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="45" maxlength="100" autocomplete="off" autofocus />
              <input name="btnCari" type="submit" value="Cari " />
            </td>
          </tr>
        </table>
      </form>
      <form <?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) { ?> action="cetak/cetak_penempatan.php?kodeDepartemen=<?php echo $kodeDepartemen; ?>&kodeKategori=<?php echo $kodeKategori; ?>&txtKataKunci=<?php echo $dataKataKunci ?>" <?php } else { ?> action="cetak/cetak_penempatan.php?kodeKategori=<?php echo $kodeKategori; ?>&txtKataKunci=<?php echo $dataKataKunci ?>" <?php } ?> method="post" name="form2" target="_blank">
        <table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
          <thead>
            <tr>
              <td width="15" align="center" bgcolor="#CCCCCC"><input type="checkbox" name="cbKode[]" id="cbkode-all"></td>
              <td width="15" bgcolor="#CCCCCC"><strong>No</strong></td>
              <td width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
              <td width="50" bgcolor="#CCCCCC"><strong>No. Penempatan</strong></td>
              <td width="200" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
              <td width="100" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
              <td width="100" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
              <td width="100" bgcolor="#CCCCCC"><strong>Lokasi</strong></td>
              <td width="50" align="center" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
              $mySql = "SELECT penempatan_item.*, penempatan.form_bast, penempatan.keterangan, penempatan.tgl_penempatan, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang, kategori.nm_kategori FROM penempatan_item 
                LEFT JOIN penempatan ON penempatan_item.no_penempatan=penempatan.no_penempatan
                LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
                LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
                LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
                LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
                $filterSQL
                AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
                GROUP BY penempatan_item.no_penempatan ORDER BY penempatan_item.no_penempatan ASC";
            } else {
              // Skrip menampilkan data Transaksi Penempatan
              $mySql = "SELECT penempatan_item.*, penempatan.form_bast, penempatan.keterangan, penempatan.tgl_penempatan, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang, kategori.nm_kategori FROM penempatan_item 
                LEFT JOIN penempatan ON penempatan_item.no_penempatan=penempatan.no_penempatan
                LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
                LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
                LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
                LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
                $filterSQL
                GROUP BY penempatan_item.no_penempatan ORDER BY penempatan_item.no_penempatan ASC";
            }
            $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
            $nomor = $hal;
            while ($myData = mysql_fetch_array($myQry)) {
              $nomor++;

              # Membaca Kode penempatan/ Nomor transaksi
              $Kode = $myData['no_penempatan'];

              # Menghitung Total penempatan (belanja) setiap nomor transaksi
              $my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$Kode'";
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
                <td>
                  <input name="cbKode[]" class="check-item" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" />
                </td>
                <td><?php echo $nomor; ?>.</td>
                <td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
                <td><?php echo $myData['no_penempatan']; ?></td>
                <td><?php echo $myData['nm_barang']; ?></td>
                <td><?php echo $myData['nm_kategori']; ?></td>
                <td><?php echo $myData['nm_departemen']; ?></td>
                <td><?php echo $myData['nm_lokasi']; ?></td>
                <td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <center>
          <button type="submit" name="btnPdf" class="btn btn-danger" title="Cetak PDF"><i class="fa fa-print"> PDF</i>
          </button>
          <button type="submit" name="btnExcel" class="btn btn-success" title="Cetak Excel"><i class="fa fa-print"> Excel</i>
          </button>
        </center>
      </form>
    </div>
  </div>
  <script>
    $(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
      $("#cbkode-all").click(function() { // Ketika user men-cek checkbox all
        if ($(this).is(":checked")) // Jika checkbox all diceklis        
          $(".check-item").prop("checked", true); // ceklis semua checkbox siswa dengan class "check-item"      
        else // Jika checkbox all tidak diceklis        
          $(".check-item").prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"    
      });
    });
  </script>