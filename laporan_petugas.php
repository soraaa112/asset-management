<div class="table-border">
<h2> LAPORAN DATA PENGGUNA </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="22" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="372" bgcolor="#CCCCCC"><b>Nama Petugas </b></td>
    <td width="130" bgcolor="#CCCCCC"><b>No. Telepon </b></td>
    <td width="120" bgcolor="#CCCCCC"><b>Username</b></td>
    <td width="75" bgcolor="#CCCCCC"><b>Level</b></td>
  </tr>
	<?php
	// Menampilkan data Petugas
	$mySql 	= "SELECT * FROM petugas ORDER BY kd_petugas";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
			
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_petugas']; ?></td>
    <td><?php echo $myData['nm_petugas']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
    <td><?php echo $myData['username']; ?></td>
    <td><?php echo $myData['level']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/petugas.php" target="_blank"><img src="images/btn_print2.png" border="0" title="Cetak ke Format HTML"/></a>
</div>