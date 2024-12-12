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

  $Kode  = isset($_GET['Kode']) ? $_GET['Kode'] : '-';
  $infoSql = "SELECT barang.*, kategori.nm_kategori FROM barang 
        LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
        WHERE barang.kd_barang='$Kode'";
  $infoQry = mysql_query($infoSql, $koneksidb);
  $infoData = mysql_fetch_array($infoQry);
  ?>
  <div class='table-border'>
    <table width="800" border="0" cellpadding="2" cellspacing="1" class="table-list">
      <tr>
        <td colspan="3" bgcolor="#CCCCCC"><b>DATA BARANG </b></td>
      </tr>
      <tr>
        <td width="186"><strong>Kode</strong></td>
        <td width="5"><b>:</b></td>
        <td width="1007"><?php echo $infoData['kd_barang']; ?></td>
      </tr>
      <tr>
        <td><strong>Type Barang </strong></td>
        <td><b>:</b></td>
        <td><?php echo $infoData['nm_barang']; ?></td>
      </tr>
      <tr>
        <td><strong>Kategori</strong></td>
        <td><b>:</b></td>
        <td><?php echo $infoData['nm_kategori']; ?></td>
      </tr>
      <tr>
        <td><strong>Jumlah</strong></td>
        <td><b>:</b></td>
        <td><?php echo format_angka($infoData['jumlah']); ?></td>
      </tr>
      <tr>
        <td><strong>Satuan</strong></td>
        <td><b>:</b></td>
        <td><?php echo $infoData['satuan']; ?></td>
      </tr>
    </table>
    <br>
    <form action="cetak_barcode_view_print.php" method="post" name="form2" target="_blank">
      <table id="example1" class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
        <thead>
          <tr>
            <td width="24" bgcolor="#CCCCCC"><strong>No</strong></td>
            <td width="200" bgcolor="#CCCCCC"><strong>Kode Label ( Inventaris )
                <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $Kode; ?>" />
              </strong></td>
            <td width="120" bgcolor="#CCCCCC"><strong>Status</strong></td>
            <td width="200" bgcolor="#CCCCCC"><strong>Lokasi / Nama Pegawai</strong></td>
            <td width="200" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
            <td width="61" align="center" bgcolor="#CCCCCC"><strong>Pilih</strong></td>
          </tr>
        </thead>
        <tbody>
          <?php
          // Menampilkan data Kode Label Inventaris
          $mySql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";
          $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
          $nomor = 0;
          while ($myData = mysql_fetch_array($myQry)) {
            $nomor++;
            $Kode = $myData['kd_inventaris'];

            // Mencari lokasi Penempatan Barang
            if ($myData['status_barang'] == "Ditempatkan") {
              $my2Sql = "SELECT lokasi.nm_lokasi, departemen.nm_departemen FROM penempatan_item as PI
              LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
              LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
              LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
              WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$Kode'";
              $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query salah : " . mysql_error());
              $my2Data = mysql_fetch_array($my2Qry);
              $infoLokasi  = $my2Data['nm_lokasi'];
              $infoDepartemen = $my2Data['nm_departemen'];
            }

            // Mencari Siapa Penempatan Barang
            if ($myData['status_barang'] == "Dipinjam") {
              $my3Sql = "SELECT pegawai.nm_pegawai, departemen.nm_departemen FROM peminjaman_item as PI
              LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
              LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
              LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
              WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$Kode'";
              $my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query salah : " . mysql_error());
              $my3Data = mysql_fetch_array($my3Qry);
              $infoLokasi  = $my3Data['nm_pegawai'];
              $infoDepartemen = $my3Data['nm_departemen'];
            }

            if ($myData['status_barang'] == "Tersedia") {
              $my4Sql = "SELECT pengadaan.*, barang_inventaris.kd_inventaris, petugas.nm_petugas, departemen.nm_departemen FROM pengadaan 
              LEFT JOIN barang_inventaris ON pengadaan.no_pengadaan=barang_inventaris.no_pengadaan
              LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
              LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
              WHERE barang_inventaris.kd_inventaris='$Kode'";
              $my4Qry = mysql_query($my4Sql, $koneksidb)  or die("Query 4 salah : " . mysql_error());
              $my4Data = mysql_fetch_array($my4Qry);
              $infoLokasi  = "";
              $infoDepartemen = $my4Data['nm_departemen'];
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
              <td><?php echo $myData['kd_inventaris']; ?></td>
              <td><?php echo $myData['status_barang']; ?></td>
              <td><?php echo $infoLokasi; ?></td>
              <td><?php echo $infoDepartemen; ?></td>
              <td align="center"><input name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" /></td>
            </tr>
          <?php } ?>
        </tbody>
        <tr>
          <td colspan="6" align="right"><input name="btnCetak" type="submit" value=" Cetak QR Code " /></td>
        </tr>
      </table>
    </form>
    <p><strong>* Note:</strong> Centang dulu pada Kode Barang yang akan dibuat label ( klik <strong>Pilih</strong> ), baru klik tombol <strong>Cetak QR Code</strong></p>
  </div>