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
  include_once "library/fpdf.php";

  # Deklarasi variabel
  $filterSQL = "";
  $SQL = "";
  $SQLPage = "";

  # BACA VARIABEL KATEGORI
  $kodeKategori = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
  $kodeKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

  # PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
  if (isset($_POST['btnCari'])) {
    $txtKataKunci  = trim($_POST['txtKataKunci']);

    // Pencarian Multi String (beberapa kata)
    $keyWord     = explode(" ", $txtKataKunci);
    $cariSQL    = " WHERE barang.kd_barang='$txtKataKunci' OR barang.nm_barang LIKE '%$txtKataKunci%' ";
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
  $pageSql = "SELECT * FROM pengadaan
  LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan = pengadaan_item.no_pengadaan
  LEFT JOIN barang ON pengadaan_item.kd_barang = barang.kd_barang
  LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
  $filterSQL";
  $pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
  $jml   = mysql_num_rows($pageQry);
  $max   = ceil($jml / $row);
  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">
      <h2>LAPORAN DATA PENGADAAN </h2>
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
                <option value="Semua"> Pilih Kategori </option>
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
            <td><input id="txtBarang" name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="26" maxlength="100" autocomplete="off" autofocus />
              <input name="btnCari" type="submit" value="Cari " />
            </td>
          </tr>
        </table>
      </form>
      <form action="cetak/cetak_pengadaan.php?kodeKategori=<?php echo $kodeKategori ?>&txtKataKunci=<?php echo $dataKataKunci ?>" method="post" name="form2" target="_blank">
        <table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
          <thead>
            <tr>
              <td width="15" align="center" bgcolor="#CCCCCC"><input type="checkbox" name="cbKode[]" id="cbkode-all"></td>
              <td width="21" bgcolor="#CCCCCC"><strong>No</strong></td>
              <td width="80" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
              <td width="100" bgcolor="#CCCCCC"><strong>No. Pengadaan</strong></td>
              <td width="150" bgcolor="#CCCCCC"><strong>Nama Petugas</strong></td>
              <td width="220" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
              <td width="40" align="center" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
              <td width="60" align="center" bgcolor="#CCCCCC"><strong>Harga</strong></td>
              <td width="70" align="right" bgcolor="#CCCCCC"><strong>Total (Rp) </strong></td>
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
              # Perintah untuk menampilkan Semua Data Transaksi Pengadaan, menggunakan Filter Periode
              if (isset($_POST['btnCari'])) {
                $mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen, barang.nm_barang, petugas.nm_petugas FROM pengadaan 
                LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
                LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
                LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
                LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
                LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
                $filterSQL
                AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
                ORDER BY pengadaan.no_pengadaan ASC";
              } else {
                $mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen, barang.nm_barang, petugas.nm_petugas FROM pengadaan 
                LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
                LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
                LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
                LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
                LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
                $filterSQL
                WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'
                ORDER BY pengadaan.no_pengadaan ASC";
              }
              $myQry = mysql_query($mySql, $koneksidb)  or die("Query pengadaan salah : " . mysql_error());
              $nomor = $hal;
            } else {
              # Perintah untuk menampilkan Semua Data Transaksi Pengadaan, menggunakan Filter Periode
              $mySql = "SELECT pengadaan.*, supplier.nm_supplier, petugas.nm_petugas, barang.nm_barang FROM pengadaan
              LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan = pengadaan_item.no_pengadaan
              LEFT JOIN barang ON pengadaan_item.kd_barang = barang.kd_barang
              LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
              LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
              $filterSQL
              ORDER BY pengadaan.no_pengadaan ASC";
              $myQry = mysql_query($mySql, $koneksidb)  or die("Query pengadaan salah : " . mysql_error());
              $nomor = $hal;
            }
            while ($myData = mysql_fetch_array($myQry)) {
              $nomor++;

              # Membaca Kode pengadaan/ Nomor transaksi
              $Kode = $myData['no_pengadaan'];

              # Menghitung Total pengadaan (belanja) setiap nomor transaksi
              $my2Sql = "SELECT SUM(jumlah) AS total_barang,  
						  SUM(harga_beli * jumlah) AS total_belanja, harga_beli 
				   FROM pengadaan_item WHERE no_pengadaan='$Kode'";
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
                  <input class="check-item" name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" placeholder="PDF" />
                </td>
                <td><?php echo $nomor; ?>.</td>
                <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
                <td><?php echo $myData['no_pengadaan']; ?></td>
                <td><?php echo $myData['nm_petugas']; ?></td>
                <td><?php echo $myData['nm_barang']; ?></td>
                <td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
                <td align="center">Rp. <?php echo format_angka($my2Data['harga_beli']); ?></td>
                <td align="center">RP. <?php echo format_angka($my2Data['total_belanja']); ?></td>
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