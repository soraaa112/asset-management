<?php
include_once "library/inc.seslogin.php";
?>
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2"><h1><b>DATA PENGGUNA </b><a href="?open=Petugas-Add" target="_self"><img src="images/btn_add_data.png"  border="0" /></a> </h1></td>
  </tr>
  <tr>
    <td colspan="2">
  <table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="25"><b>No</b></th>
        <th width="50">Kode</th>
        <th width="324"><b>Nama Petugas </b></th>
        <th width="142"><b>No. Telepon </b></th>
        <th width="132"><b>Username</b></th>
        <th width="132"><b>Unit</b></th>
        <th width="100"><b>Level</b></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
      <?php
    // Skrip menampilkan data Petugas
  $mySql  = "SELECT * FROM petugas ORDER BY kd_petugas ASC";
  $myQry  = mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
  $nomor  = 0; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
    $Kode = $myData['kd_petugas'];
    
    // gradasi warna
    if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
  ?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_petugas']; ?></td>
        <td><?php echo $myData['nm_petugas']; ?></td>
        <td><?php echo $myData['no_telepon']; ?></td>
        <td><?php echo $myData['username']; ?></td>
        <td><?php echo $myData['unit']; ?></td>
        <td><?php echo $myData['level']; ?></td>
        <td width="40" align="center"><a href="?open=Petugas-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" 
        onclick="return confirm('YAKIN AKAN MENGHAPUS DATA PETUGAS INI ... ?')">Delete</a></td>
    <td width="40" align="center"><a href="?open=Petugas-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
      </tr>
      <?php } ?>
    </table>    <br><br></td>
  </tr>
</table>

