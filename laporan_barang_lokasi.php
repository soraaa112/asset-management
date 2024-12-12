<?php
include_once "library/inc.seslogin.php";

// Variabel SQL
$filterSQL = "";

// Variabel data Combo Lokasi
$kodeDepartemen  = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua'; // dari URL
$dataDepartemen  = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen; // dari Form

// Variabel data Combo Lokasi
$kodeLokasi  = isset($_GET['kodeLokasi']) ? $_GET['kodeLokasi'] : 'Semua'; // dari URL
$dataLokasi  = isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : $kodeLokasi; // dari Form

# MEMBUAT FILTER DATA
if (trim($dataLokasi) == "Semua") {
  if (trim($dataDepartemen) == "Semua") {
    // Jika Lokasi Kosong Semua, dan Departemen Kosong
    $filterSQL = "";
  } else {
    // dan Jika Lokasi Kosong (Semua), dan Departemen dipilih
    $filterSQL = " AND lokasi.kd_departemen='$dataDepartemen'";
  }
} else {
  // Jika Lokasi dipilih
  $filterSQL = "AND penempatan.kd_lokasi='$dataLokasi'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris   = 50;
$hal   = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penempatan_item as Pi
					LEFT JOIN penempatan ON Pi.no_penempatan=penempatan.no_penempatan 
					LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
					$filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:" . mysql_error());
$jml   = mysql_num_rows($pageQry);
$max   = ceil($jml / $baris);
?>
<div class="table-border">
  <h2> LAPORAN DATA BARANG PER LOKASI</h2>
  <SCRIPT language="JavaScript">
    function submitform() {
      document.form1.submit();
    }
  </SCRIPT>

  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
    <table width="900" border="0" class="table-list">
      <tr>
        <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
      </tr>
      <tr>
        <td><b> Departemen </b></td>
        <td><b>:</b></td>
        <td><select name="cmbDepartemen" onchange="javascript:submitform();">
            <option value="Semua">....</option>
            <?php
            // Skrip menampilkan data Departemen dalam ComboBox
            $comboSql = "SELECT * FROM departemen ORDER BY kd_departemen";
            $comboQry = mysql_query($comboSql, $koneksidb) or die("Gagal Query" . mysql_error());
            while ($comboData = mysql_fetch_array($comboQry)) {
              if ($comboData['kd_departemen'] == $dataDepartemen) {
                $cek = " selected";
              } else {
                $cek = "";
              }
              echo "<option value='$comboData[kd_departemen]' $cek>$comboData[nm_departemen]</option>";
            }
            ?>
          </select></td>
      </tr>
      <tr>
        <td width="137"><b> Lokasi </b></td>
        <td width="6"><b>:</b></td>
        <td width="743">
          <select name="cmbLokasi">
            <option value="Semua"> ....</option>
            <?php
            // Menampilkan data Lokasi per Departemen yang dipilih dari ComboBox
            $comboSql = "SELECT * FROM lokasi WHERE kd_departemen='$dataDepartemen' ORDER BY kd_lokasi";
            $comboQry = mysql_query($comboSql, $koneksidb) or die("Gagal Query" . mysql_error());
            while ($comboData = mysql_fetch_array($comboQry)) {
              if ($comboData['kd_lokasi'] == $dataLokasi) {
                $cek = " selected";
              } else {
                $cek = "";
              }
              echo "<option value='$comboData[kd_lokasi]' $cek>$comboData[nm_lokasi]</option>";
            }
            ?>
          </select>
          <input name="btnTampil" type="submit" value=" Tampilkan " />
        </td>
      </tr>
    </table>
  </form>
  <table id='example1' class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
    <thead>
      <tr>
        <td width="22" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="106" bgcolor="#CCCCCC"><strong>Kode Label </strong></td>
        <td width="371" bgcolor="#CCCCCC"><strong>Type</strong></td>
        <td width="261" bgcolor="#CCCCCC"><strong>Foto</td>
        <td width="180" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
        <td width="120" bgcolor="#CCCCCC"><strong></strong></td>
        <td width="70" bgcolor="#CCCCCC"><strong>Satuan</strong></td>
      </tr>
    </thead>
    <tbody>
      <?php
      # MENJALANKAN QUERY, menampilkan daftar nama barang yang ada di setiap Lokasi Penempatan
      $mySql   = "SELECT Pi.kd_inventaris, barang.*, kategori.nm_kategori FROM penempatan_item as Pi
					LEFT JOIN penempatan ON Pi.no_penempatan=penempatan.no_penempatan 
					LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
					LEFT JOIN barang_inventaris ON Pi.kd_inventaris=barang_inventaris.kd_inventaris
					LEFT JOIN barang ON barang.kd_barang=barang_inventaris.kd_barang
					LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
				WHERE Pi.status_aktif='Yes' $filterSQL
				ORDER BY Pi.kd_inventaris ASC LIMIT $hal, $baris";
      $myQry   = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
      $nomor  = $hal;
      while ($myData = mysql_fetch_array($myQry)) {
        $nomor++;
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
          <td></td>
          <td><?php echo $myData['satuan']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <br />
  <center><a href="cetak/barang_lokasi.php?kodeLokasi=<?php echo $dataLokasi; ?>" target="_blank"><img style='float:none !important' src="images/btn_print2.png" border="0" title="Cetak ke Format HTML" /></a></center>
</div>