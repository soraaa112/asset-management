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

  // Set variabel SQL
  $filterSQL = "";
  $SQL = "";
  $SQLPage = "";

  # BACA VARIABEL KATEGORI
  $kodeKategori = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
  $kodeKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;
  if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    # Pegawai terpilih
    $unit = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : $_SESSION['SES_UNIT'];
  }

  # PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
  if (isset($_SESSION['SES_PETUGAS']) && ($_SESSION['SES_UNIT'])) {
    if (isset($_POST['btnCari'])) {
      $txtKataKunci  = trim($_POST['txtKataKunci']);

      // Pencarian Multi String (beberapa kata)
      $keyWord     = explode(" ", $txtKataKunci);
      $cariSQL    = "AND b.kd_barang = '$txtKataKunci' OR b.nm_barang LIKE '%$txtKataKunci%' ";
      // if (count($keyWord) > 1) {
      //   foreach ($keyWord as $kata) {
      //     $cariSQL  .= " OR barang.nm_barang LIKE'%$kata%'";
      //   }
      // }

      if (trim($_POST['cmbKategori']) == "Semua") {
        //Query #1 (all)
        $filterSQL   = $cariSQL . " AND D.nm_departemen = '$_SESSION[SES_UNIT]'";
      } else {
        //Query #2 (filter)
        $filterSQL   = $cariSQL . " AND b.kd_kategori ='$kodeKategori' AND D.nm_departemen = '$_SESSION[SES_UNIT]'";
      }
    } else {
      //Query #1 (all)
      $filterSQL   = "AND D.nm_departemen = '$_SESSION[SES_UNIT]'";
    }
  } else {
    if (isset($_POST['btnCari'])) {
      $txtKataKunci  = trim($_POST['txtKataKunci']);

      // Pencarian Multi String (beberapa kata)
      $keyWord     = explode(" ", $txtKataKunci);
      $cariSQL    = " WHERE barang.kd_barang = '$txtKataKunci' OR barang.nm_barang LIKE '%$txtKataKunci%' ";
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
  }

  # Simpan Variabel TMP
  $dataKataKunci = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

  # UNTUK PAGING (PEMBAGIAN HALAMAN)
  $row   = 10;
  $hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
  if (isset($_SESSION['SES_PETUGAS']) && ($_SESSION['SES_UNIT'])) {
    $pageSql = "SELECT b.*, COUNT(BI.kd_inventaris) AS total FROM barang_inventaris BI
    LEFT JOIN barang b ON BI.kd_barang = b.kd_barang
    LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
    LEFT JOIN pengadaan PE ON BI.no_pengadaan = PE.no_pengadaan
    LEFT JOIN petugas PT ON PE.kd_petugas = PT.kd_petugas
    LEFT JOIN penempatan_item PI ON BI.kd_inventaris = PI.kd_inventaris
    LEFT JOIN penempatan P ON PI.no_penempatan = P.no_penempatan
    LEFT JOIN lokasi L ON P.kd_lokasi = L.kd_lokasi
    LEFT JOIN peminjaman_item PIJ ON BI.kd_inventaris = PIJ.kd_inventaris
    LEFT JOIN peminjaman PJ ON PIJ.no_peminjaman = PJ.no_peminjaman
    LEFT JOIN pegawai PG ON PJ.kd_pegawai = PG.kd_pegawai
    LEFT JOIN departemen D ON PT.kd_departemen = D.kd_departemen OR L.kd_departemen = D.kd_departemen OR PG.kd_departemen = D.kd_departemen
    WHERE b.kd_kategori !='' AND BI.status_barang != '' $filterSQL GROUP BY b.kd_barang";
  } else {
    $pageSql = "SELECT * FROM barang
    LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori $filterSQL";
  }
  $pageQry = mysqli_query($koneksidb, $pageSql) or die("error paging:" . mysql_error());
  $jml   = mysqli_num_rows($pageQry);
  $max   = ceil($jml / $row);
  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">
      <h2> LAPORAN DATA BARANG PER KATEGORI</h2>
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
        <table width="900" border="0" class="table-list">
          <tr>
            <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
          </tr>
          <tr>
            <td width="137"><b>Kategori </b></td>
            <td width="5"><b>:</b></td>
            <td width="744">
              <select name="cmbKategori" data-live-search="true" class="selectpicker">
                <option value="Semua"> Semua Kategori </option>
                <?php
                // Menampilkan data Kategori ke dalam ComboBox (ListMenu)
                $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
                $dataQry = mysql_query($dataSql, $koneksidb) or die("Gagal Query" . mysql_error());
                while ($dataRow = mysql_fetch_array($dataQry)) {
                  if ($kodeKategori == $dataRow['kd_kategori']) {
                    $cek = " selected";
                  } else {
                    $cek = "";
                  }
                  echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
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
      <table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
        <thead>
          <tr>
            <td width="23" bgcolor="#CCCCCC"><strong>No</strong></td>
            <td width="45" bgcolor="#CCCCCC"><strong>Kode</strong></td>
            <td width="329" bgcolor="#CCCCCC"><strong>Type</strong></td>
            <td width="261" bgcolor="#CCCCCC"><strong>Foto</td>
            <td width="140" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
            <td width="50" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
            <td width="50" align="right" bgcolor="#CCCCCC"><strong> Tersedia </strong></td>
            <td width="87" align="right" bgcolor="#CCCCCC"><strong>Ditempatkan</strong></td>
            <td width="50" align="right" bgcolor="#CCCCCC"><strong>Dipinjam</strong></td>
            <td width="40" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
          </tr>
        </thead>
        <tbody>
          <?php
          // Skrip menampilkan data Barang dengan filter Kategori
          if (isset($_SESSION['SES_PETUGAS']) && ($_SESSION['SES_UNIT'])) {
            # MENJALANKAN QUERY
            $mySql = "SELECT b.*, K.*, BI.kd_inventaris, BI.status_barang, COUNT(BI.kd_inventaris) AS total FROM barang_inventaris BI
            LEFT JOIN barang b ON BI.kd_barang = b.kd_barang
            LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
            LEFT JOIN pengadaan PE ON BI.no_pengadaan = PE.no_pengadaan
            LEFT JOIN petugas PT ON PE.kd_petugas = PT.kd_petugas
            LEFT JOIN penempatan_item PI ON BI.kd_inventaris = PI.kd_inventaris
            LEFT JOIN penempatan P ON PI.no_penempatan = P.no_penempatan
            LEFT JOIN lokasi L ON P.kd_lokasi = L.kd_lokasi
            LEFT JOIN peminjaman_item PIJ ON BI.kd_inventaris = PIJ.kd_inventaris
            LEFT JOIN peminjaman PJ ON PIJ.no_peminjaman = PJ.no_peminjaman
            LEFT JOIN pegawai PG ON PJ.kd_pegawai = PG.kd_pegawai
            LEFT JOIN departemen D ON PT.kd_departemen = D.kd_departemen OR L.kd_departemen = D.kd_departemen OR PG.kd_departemen = D.kd_departemen
            WHERE b.kd_kategori !='' AND BI.status_barang != '' $filterSQL GROUP BY b.kd_barang";
          } else {
            // Query menampilkan data Inventaris per Kode barang
            $mySql   = "SELECT barang.*, kategori.* FROM barang 
            LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
            $filterSQL
            ORDER BY barang.kd_barang ASC";
          }
          $nomor  = $hal;
          $myQry   = mysqli_query($koneksidb, $mySql)  or die("Query salah1 : " . mysql_error());
          while ($myData = mysqli_fetch_array($myQry)) {
            $nomor++;
            $Kode = $myData['kd_barang'];
            // Membuat variabel akan diisi angka
            $jumTersedia = 0;
            $jumDitempatkan = 0;
            $jumDipinjam = 0;

            if (isset($_SESSION['SES_PETUGAS']) && ($_SESSION['SES_UNIT'])) {
              if ($myData['status_barang'] == "Tersedia") {
                $row = "SELECT barang_inventaris.*, COUNT(barang_inventaris.kd_inventaris) AS total FROM barang_inventaris
                LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
                LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
                LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
                WHERE barang_inventaris.kd_barang='$Kode' AND departemen.nm_departemen='$_SESSION[SES_UNIT]'";
                $Qry = mysql_query($row, $koneksidb)  or die("Query salah1 : " . mysql_error());
                $dataRow = mysql_fetch_array($Qry);
                $jumTersedia = $dataRow['total'];
              }

              if ($myData['status_barang'] == "Ditempatkan" || $myData['status_barang'] == "Dipinjam") {
                $row = "SELECT COUNT(penempatan_item.kd_inventaris) AS total FROM barang_inventaris
                LEFT JOIN penempatan_item ON barang_inventaris.kd_inventaris = penempatan_item.kd_inventaris
                LEFT JOIN penempatan ON penempatan_item.no_penempatan = penempatan.no_penempatan
                LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
                LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen
                WHERE barang_inventaris.kd_barang='$Kode' AND barang_inventaris.kd_inventaris = penempatan_item.kd_inventaris AND departemen.nm_departemen='$_SESSION[SES_UNIT]' AND penempatan_item.status_aktif = 'Yes'";
                $Qry = mysql_query($row, $koneksidb)  or die("Query salah1 : " . mysql_error());
                $dataRow = mysql_fetch_array($Qry);
                $jumDitempatkan = $dataRow['total'];
              }

              if ($myData['status_barang'] == "Dipinjam" || $myData['status_barang'] == "Ditempatkan") {
                $row = "SELECT COUNT(peminjaman_item.kd_inventaris) AS total FROM barang_inventaris
                LEFT JOIN peminjaman_item ON barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris
                LEFT JOIN peminjaman ON peminjaman_item.no_peminjaman = peminjaman.no_peminjaman
                LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
                LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
                WHERE barang_inventaris.kd_barang='$Kode' AND barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris AND departemen.nm_departemen='$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = 'Pinjam'";
                $Qry = mysql_query($row, $koneksidb)  or die("Query salah1 : " . mysql_error());
                $dataRow = mysql_fetch_array($Qry);
                $jumDipinjam = $dataRow['total'];
              }

              $total = array($jumTersedia, $jumDitempatkan, $jumDipinjam);
              $total_barang = array_sum($total);
            } else {
              $row = "SELECT barang_inventaris.*, departemen.nm_departemen FROM barang_inventaris
              LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
              LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
              LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
              WHERE barang_inventaris.kd_barang='$Kode'";
              $Qry = mysql_query($row, $koneksidb)  or die("Query salah1 : " . mysql_error());
              while ($Data = mysql_fetch_array($Qry)) {
                if ($Data['status_barang'] == "Tersedia") {
                  $jumTersedia++;
                }

                if ($Data['status_barang'] == "Ditempatkan") {
                  $jumDitempatkan++;
                }

                if ($Data['status_barang'] == "Dipinjam") {
                  $jumDipinjam++;
                }
              }
            }

            // gradasi warna
            if ($nomor % 2 == 1) {
              $warna = "";
            } else {
              $warna = "#F5F5F5";
            }
          ?>
            <tr bgcolor="<?php echo $warna; ?>">
              <td><?php echo $nomor; ?></td>
              <td><?php echo $myData['kd_barang']; ?></td>
              <td><?php echo $myData['nm_barang']; ?></td>
              <td><?php
                  $ex = explode(';', $myData['foto']);
                  $no = 1;
                  for ($i = 0; $i < count($ex); $i++) {
                    if ($ex[$i] != '') {
                      echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'>" . $ex[$i] . "</a>, ";
                    }
                    $no++;
                  }
                  ?></td>
              <td><?php echo $myData['nm_kategori']; ?></td>
              <?php if (isset($_SESSION['SES_PETUGAS']) && ($_SESSION['SES_UNIT'])) { ?>
                <td align="center" bgcolor="<?php echo $warna; ?>"><?php echo $total_barang; ?></td>
              <?php } else { ?>
                <td align="center" bgcolor="<?php echo $warna; ?>"><?php echo $myData['jumlah']; ?></td>
              <?php }  ?>
              <td align="center" bgcolor="<?php echo $warna; ?>"><?php echo $jumTersedia; ?></td>
              <td align="center" bgcolor="<?php echo $warna; ?>"><?php echo $jumDitempatkan; ?></td>
              <td align="center" bgcolor="<?php echo $warna; ?>"><?php echo $jumDipinjam; ?></td>
              <td>
                <?php if (isset($_SESSION['SES_PETUGAS']) && ($_SESSION['SES_UNIT'])) { ?>
                  <a href="?open=History-Barang&Kode=<?php echo $Kode; ?>&kodeDepartemen=<?php echo $unit; ?>" target="_blank">
                    <button class="btn btn-primary" title="History Data Barang"><i class="fa fa-search"></i>
                    </button>
                  </a>
                <?php } else { ?>
                  <a href="?open=History-Barang&Kode=<?php echo $Kode; ?>" target="_blank">
                    <button class="btn btn-primary" title="History Data Barang"><i class="fa fa-search"></i>
                    </button>
                  </a>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <center>
        <a href="cetak/barang_kategori_pdf.php?kodeKategori=<?php echo $kodeKategori; ?>&txtKataKunci=<?php echo $dataKataKunci ?>&kodeDepartemen=<?php echo $unit; ?>" target="_blank" title="Cetak ke Format PDF">
          <button class="btn btn-danger" title="Cetak PDF"><i class="fa fa-print"> PDF</i>
          </button>
        </a>
        <a href="cetak/barang_kategori.php?kodeKategori=<?php echo $kodeKategori; ?>&txtKataKunci=<?php echo $dataKataKunci ?>&kodeDepartemen=<?php echo $unit; ?>" target="_blank" title="Cetak ke Format Excel">
          <button class="btn btn-success" title="Cetak EXCEL"><i class="fa fa-print"> Excel</i>
          </button>
        </a>
      </center>
    </div>
  </div>