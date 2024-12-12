<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      /* border: 1px solid #ddd; */
    }

    th,
    td {
      text-align: left;
      padding: 8px;
    }

    .right {
      text-align: right;
      padding: 8px;
    }


    /* tr:nth-child(even){background-color: #f2f2f2} */
  </style>
</head>

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
    //   if (count($keyWord) > 1) {
    //     foreach ($keyWord as $kata) {
    //       $cariSQL  .= " OR barang.nm_barang LIKE'%$kata%'";
    //     }
    //   }

    if (trim($_POST['cmbKategori']) == "Semua") {
      //Query #1 (all)
      if (trim($statusBarang) == "Semua") {
        $filterSQL   = $cariSQL;
      } else {
        $filterSQL = $cariSQL . "AND opname.status='$statusBarang'";
      }
    } else {
      //Query #2 (filter)
      if (trim($statusBarang) == "Semua") {
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
  $filterSQL GROUP BY opname_item.kd_inventaris ORDER BY opname_item.kd_inventaris ASC";
  $pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
  $jml   = mysql_num_rows($pageQry);
  $max   = ceil($jml / $row);
  ?>
  <div class="table-border">
    <div style="overflow-x:auto;">
      <h2>LAPORAN DATA STOK OPNAME</a></h2>
      <form style='padding-top:0px !important' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
        <table width="900" border="0" class="table-list">
          <tr>
            <td colspan="4" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
          </tr>
          <tr>
            <td width="134"><strong> Kategori </strong></td>
            <td width="5"><strong>:</strong></td>
            <td width="741">
              <select name="cmbKategori" data-live-search="true" class="selectpicker">
                <option value="Semua">Semua</option>
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
                <option value="Semua">Semua</option>
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
            </td>
          </tr>
          <tr>
            <td><strong>Cari Barang </strong></td>
            <td><strong>:</strong></td>
            <td><input name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="45" maxlength="100" autofocus />
              <input name="btnCari" type="submit" value="Cari " />
            </td>
          </tr>
        </table>
      </form>
      <form action="cetak/cetak_opname.php?kodeKategori=<?php echo $kodeKategori ?>&statusKembali=<?php echo $statusBarang; ?>&txtKataKunci=<?php echo $dataKataKunci ?>" method="post" name="form2" target="_blank">
        <table id='example1' class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
          <thead>
            <tr>
              <td width="15" align="center" bgcolor="#CCCCCC"><input type="checkbox" name="cbKode[]" id="cbkode-all"></td>
              <td width="21" bgcolor="#CCCCCC"><strong>No</strong></td>
              <td width="90" bgcolor="#CCCCCC"><strong>Kode Opname</strong></td>
              <td width="100" bgcolor="#CCCCCC"><strong>Kode Label</strong></td>
              <td width="250" bgcolor="#CCCCCC"><strong>Type Barang</strong></td>
              <td width="100" bgcolor="#CCCCCC"><strong>Tgl Opname</strong></td>
              <td width="70" bgcolor="#CCCCCC"><strong>Kondisi</strong></td>
              <td width="70" bgcolor="#CCCCCC"><strong>Status</strong></td>
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
          LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori  $filterSQL 
          GROUP BY opname_item.kd_inventaris
          ORDER BY opname.kd_opname ASC";
            $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
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
                <td>
                  <input class="check-item" name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" />
                </td>
                <td><?php echo $nomor; ?>.</td>
                <td><?php echo $myData['kd_opname']; ?></td>
                <td><?php echo $myData['kd_inventaris']; ?></td>
                <td><?php echo $myData['nm_barang']; ?></td>
                <td><?php echo IndonesiaTgl($myData['tahun_opname']); ?></td>
                <td><?php echo $myData['keterangan']; ?></td>
                <td><?php echo $myData['status']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <center>
          <!-- <a href="cetak/opname_pdf.php?kodeKategori=<?php echo $kodeKategori ?>&statusKembali=<?php echo $statusBarang; ?>&txtKataKunci=<?php echo $dataKataKunci ?>" target="_blank" title="Cetak ke Format PDF"> -->
          <button type="submit" name="btnPdf" class="btn btn-danger" title="Cetak PDF"><i class="fa fa-print"> PDF</i>
          </button>
          </a>
          <!-- <a href="cetak/opname_excel.php?kodeKategori=<?php echo $kodeKategori ?>&statusKembali=<?php echo $statusBarang; ?>&txtKataKunci=<?php echo $dataKataKunci ?>" target="_blank" title="Cetak ke Format PDF"> -->
          <button type="submit" name="btnExcel" class="btn btn-success" title="Cetak EXCEL"><i class="fa fa-print"> Excel</i>
          </button>
          </a>
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