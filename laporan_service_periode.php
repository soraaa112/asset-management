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

  $filterSQL  = "";
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
    $cariSQL    = " WHERE service_item.kd_inventaris='$txtKataKunci' OR barang.nm_barang LIKE '%$txtKataKunci%' ";
    // if (count($keyWord) > 1) {
    //   foreach ($keyWord as $kata) {
    //     $cariSQL  .= " OR barang.nm_barang LIKE'%$kata%'";
    //   }
    // }

    if (trim($_POST['cmbKategori']) == "Semua") {
      //Query #1 (all)
      $filterSQL   = $cariSQL;
    } else {
      //Query #2 (filter)
      $filterSQL   = $cariSQL . " AND barang.kd_kategori ='$kodeKategori'";
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
  if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    if (isset($_POST['btnCari'])) {
      $pageSql = "SELECT services.*, service_item.*, barang.nm_barang, barang.kd_kategori, departemen.nm_departemen 
      FROM services
      LEFT JOIN service_item ON services.no_service = service_item.no_service
      LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN petugas ON services.kd_petugas = petugas.kd_petugas
      LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen 
      $filterSQL AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' 
      GROUP BY services.no_service";
    } else {
      $pageSql = "SELECT services.*, service_item.*, barang.nm_barang, barang.kd_kategori, departemen.nm_departemen 
      FROM services
      LEFT JOIN service_item ON services.no_service = service_item.no_service
      LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN petugas ON services.kd_petugas = petugas.kd_petugas
      LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen 
      WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]' 
      GROUP BY services.no_service";
    }
  } else {
    $pageSql = "SELECT services.*, service_item.*, barang.nm_barang, barang.kd_kategori, departemen.nm_departemen 
    FROM services
    LEFT JOIN service_item ON services.no_service = service_item.no_service
    LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
    LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
    LEFT JOIN petugas ON services.kd_petugas = petugas.kd_petugas
    LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen  
    $filterSQL GROUP BY services.no_service";
  }
  $pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:" . mysql_error());
  $jml   = mysql_num_rows($pageQry);
  $max   = ceil($jml / $row);

  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">
      <h2>LAPORAN DATA SERVICE</a></h2>
      <form style='padding-top:0px !important' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
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
            <td><input name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="26" maxlength="100" autofocus />
              <input name="btnCari" type="submit" value="Cari " />
            </td>
          </tr>
        </table>
      </form>
      <form action="cetak/cetak_service.php?kodeKategori=<?php echo $kodeKategori; ?>&txtKataKunci=<?php echo $dataKataKunci ?>" method="post" name="form2" target="_blank">
        <table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
          <thead>
            <tr>
              <td width="15" align="center" bgcolor="#CCCCCC"><input type="checkbox" name="cbKode[]" id="cbkode-all"></td>
              <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
              <td width="90" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
              <td width="110" bgcolor="#CCCCCC"><strong>Kode Label</strong></td>
              <td width="154" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
              <td width="229" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
              <td width="250" bgcolor="#CCCCCC"><strong>Departemen &amp; Lokasi</strong></td>
              <td width="120" align="right" bgcolor="#CCCCCC"><strong>Total Biaya</strong></td>
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
              if (isset($_POST['btnCari'])) {
                $mySql  = "SELECT services.*, service_item.*, barang_inventaris.*, supplier.nm_supplier, barang.nm_barang, departemen.nm_departemen, service_item.kd_inventaris, service_item.keterangan
                FROM services
                LEFT JOIN service_item ON services.no_service = service_item.no_service
                LEFT JOIN supplier ON services.kd_supplier=supplier.kd_supplier
                LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                LEFT JOIN petugas ON services.kd_petugas = petugas.kd_petugas
                LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen 
                $filterSQL AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' 
                GROUP BY services.no_service";
              } else {
                $mySql  = "SELECT services.*, service_item.*, barang_inventaris.*, supplier.nm_supplier, barang.nm_barang, departemen.nm_departemen, service_item.kd_inventaris, service_item.keterangan
                FROM services 
                LEFT JOIN service_item on services.no_service=service_item.no_service
                LEFT JOIN supplier ON services.kd_supplier=supplier.kd_supplier
                LEFT JOIN barang_inventaris on service_item.kd_inventaris=barang_inventaris.kd_inventaris
                LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
                LEFT JOIN petugas on services.kd_petugas=petugas.kd_petugas 
                LEFT JOIN departemen on petugas.kd_departemen=departemen.kd_departemen 
                WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'
                GROUP BY services.no_service ORDER BY services.no_service ASC";
              }
            } else {
              $mySql  = "SELECT services.*, supplier.nm_supplier, barang.nm_barang, barang_inventaris.*, service_item.kd_inventaris, service_item.keterangan
              FROM services 
              LEFT JOIN supplier ON services.kd_supplier=supplier.kd_supplier
              LEFT JOIN service_item on services.no_service=service_item.no_service
              LEFT JOIN barang_inventaris on service_item.kd_inventaris=barang_inventaris.kd_inventaris
              LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
              LEFT JOIN pengadaan on barang_inventaris.no_pengadaan=pengadaan.no_pengadaan
              LEFT JOIN petugas on pengadaan.kd_petugas=petugas.kd_petugas 
              $filterSQL GROUP BY services.no_service ORDER BY services.no_service ASC";
            }
            $myQry  = mysql_query($mySql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
            $nomor  = $hal;
            while ($myData = mysql_fetch_array($myQry)) {
              $nomor++;
              $Kode = $myData['no_service'];
              $inventaris = $myData['kd_inventaris'];

              if ($myData['status_barang'] == "Ditempatkan") {
                $my1Sql = "SELECT lokasi.nm_lokasi, departemen.nm_departemen FROM penempatan_item as PI
                LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
                LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
                LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
                WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$inventaris'";
                $my1Qry = mysql_query($my1Sql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
                $my1Data = mysql_fetch_array($my1Qry);
                $infoLokasi  = $my1Data['nm_lokasi'];
                $infoDepartemen = $my1Data['nm_departemen'];
              }

              // Mencari Siapa Penempatan Barang
              if ($myData['status_barang'] == "Dipinjam") {
                $my3Sql = "SELECT pegawai.nm_pegawai, departemen.nm_departemen FROM peminjaman_item as PI
                LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
                LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
                LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
                WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$inventaris'";
                $my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query 3 salah : " . mysql_error());
                $my3Data = mysql_fetch_array($my3Qry);
                $infoLokasi  = $my3Data['nm_pegawai'];
                $infoDepartemen = $my3Data['nm_departemen'];
              }

              if ($myData['status_barang'] == "Tersedia") {
                $my4Sql = "SELECT pengadaan.*, barang_inventaris.status_barang, barang_inventaris.kd_inventaris, petugas.nm_petugas, departemen.nm_departemen FROM pengadaan 
                LEFT JOIN barang_inventaris ON pengadaan.no_pengadaan=barang_inventaris.no_pengadaan
                LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
                LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
                WHERE barang_inventaris.kd_inventaris='$inventaris'";
                $my4Qry = mysql_query($my4Sql, $koneksidb)  or die("Query 4 salah : " . mysql_error());
                $my4Data = mysql_fetch_array($my4Qry);
                $infoLokasi  = $my4Data['status_barang'];
                $infoDepartemen = $my4Data['nm_departemen'];
              }

              # Menghitung Total pengadaan (belanja) setiap nomor transaksi
              $my2Sql = "SELECT harga_service
              FROM service_item WHERE no_service='$Kode'";
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
                  <input class="check-item" name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" />
                </td>
                <td><?php echo $nomor; ?>.</td>
                <td><?php echo IndonesiaTgl($myData['tgl_service']); ?></td>
                <td><?php echo $myData['kd_inventaris']; ?></td>
                <td><?php echo $myData['nm_barang']; ?></td>
                <td><?php echo $myData['keterangan']; ?></td>
                <td><?php echo $infoDepartemen . ", " . $infoLokasi; ?></td>
                <td align="center">Rp. <?php echo format_angka($my2Data['harga_service']); ?></td>
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