<?php
include_once "library/inc.seslogin.php";

# Deklarasi variabel
$tglAwal	= ""; 
$tglAkhir	= "";
$filterSQL 	= "";
$filterPeriode	= ""; 

# Membaca Variabel filter yang dikirim Form Filter
$kodeLokasi= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : 'SEMUA';
$tglAwal 	= isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('d-m-Y');

// Sql untuk filter periode
$filterPeriode = " AND ( mutasi.tgl_mutasi BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";

# TOMBOL TAMPIL DIKLIK
if (isset($_POST['btnTampil'])) {
	
	// Jika lokasi dipilih
	if (trim($kodeLokasi)=="SEMUA") {
		//Query #1 (all)
		$filterSQL 	= $filterPeriode."";
	}
	else {
		//Query #2 (filter)
		$filterSQL 	= $filterPeriode." AND mutasi.kd_lokasi ='$kodeLokasi'";
	}
}
else {
	$filterSQL	= $filterPeriode."";
}
	
# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/mutasi_barang_lokasi.php?kodeLokasi=$kodeLokasi&tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
		echo "</script>";
}
?>
<div class="table-border">
<h2>  LAPORAN MUTASI BARANG - PER LOKASI </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="90"><strong> Lokasi  Lama</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="391"><select name="cmbLokasi">
          <option value="SEMUA">- SEMUA -</option>
          <?php
	  $mySql = "SELECT * FROM lokasi ORDER BY kd_lokasi";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($kolomData = mysql_fetch_array($myQry)) {
	  	if ($kodeLokasi == $kolomData['kd_lokasi']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$kolomData[kd_lokasi]' $cek>$kolomData[nm_lokasi]</option>";
	  }
	  $mySql ="";
	  ?>
        </select></td>
    </tr>
    <tr>
      <td><strong>Periode </strong></td>
      <td><strong>:</strong></td>
      <td><input name="cmbTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d
        <input name="cmbTglAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " />
        <input name="btnCetak" type="submit" id="btnCetak" value=" Cetak " /></td>
    </tr>
  </table>
</form>

<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="8" bgcolor="#CCCCCC"><strong>DAFTAR BARANG </strong></td>
  </tr>
  <tr>
    <td width="25" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="77" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="81" bgcolor="#F5F5F5"><strong>No. Mutasi</strong></td>
    <td width="66" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="288" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="110" bgcolor="#F5F5F5"><strong>No. Penempatan </strong></td>
    <td width="162" bgcolor="#F5F5F5"><strong>Lokasi Baru </strong></td>
    <td width="50" align="center" bgcolor="#F5F5F5"><b>Jumlah</b></td>
  </tr>
  <?php
  	// deklarasi variabel
	$totalBarang 	= 0;  
	
	//  Perintah SQL menampilkan data barang daftar mutasi
	$mySql ="SELECT mutasi.no_mutasi, penempatan.no_penempatan, penempatan.tgl_penempatan, barang.kd_barang, barang.nm_barang
			 FROM mutasi, penempatan, penempatan_item
			 	LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
			 	LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
			 WHERE mutasi.no_penempatan=penempatan.no_penempatan AND penempatan.no_penempatan=penempatan_item.no_penempatan 
			 $filterSQL
			 ORDER BY penempatan.tgl_penempatan";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	$nomor  = 0;   
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		# Membaca Kode
		$noNota = $myData['no_penempatan'];
		$kodeBrg= $myData['kd_barang'];
		
		# Menghitung Total Barang yang ditempatkan dilokasi terpilih
		$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item as PI, barang_inventaris as BI 
					WHERE PI.kd_inventaris=BI.kd_inventaris AND BI.kd_barang='$kodeBrg' AND PI.no_penempatan='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		$totalBarang= $totalBarang + $my2Data['total_barang'];
		
		# Membaca Nama Lokasi Penempatan Baru
		$my3Sql = "SELECT lokasi.nm_lokasi FROM penempatan LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
					WHERE penempatan.no_penempatan='$noNota'";
		$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
		$my3Data = mysql_fetch_array($my3Qry); 
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $my3Data['nm_lokasi']; ?></td>
    <td align="center"><?php echo $my2Data['total_barang']; ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="7" align="right"><b>  Total  : </b></td>
    <td align="center" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
  </tr>
</table>
<a href="cetak/mutasi_barang_lokasi.php?kodeLokasi=<?php echo $kodeLokasi; ?>&tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png"  border="0" title="Cetak ke Format HTML"/></a>
</div>