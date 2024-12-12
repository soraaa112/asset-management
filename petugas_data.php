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
?>
<div style="overflow-x:auto;">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2">
      <h1><b>DATA PENGGUNA </b><a href="?open=Petugas-Add" target="_self"><img src="images/btn_add_data.png" border="0" /></a></h1>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <th width="25"><b>No</b></th>
          <th width="50">Kode</th>
          <th width="220"><b>Nama</b></th>
          <th width="145"><b>No. Telepon </b></th>
          <th width="132"><b>Username</b></th>
          <th width="132"><b>Departemen</b></th>
          <th width="100"><b>Level</b></th>
          <th width="40" colspan="2" align="right"><b>Aksi</b><b></b></th>
        </tr>
        <?php
        // Skrip menampilkan data Petugas
        $mySql  = "SELECT petugas.*, departemen.nm_departemen FROM petugas
        LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
        ORDER BY kd_petugas ASC";
        $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
        $nomor  = 0;
        while ($myData = mysql_fetch_array($myQry)) {
          $nomor++;
          $Kode = $myData['kd_petugas'];

          // gradasi warna
          if ($nomor % 2 == 1) {
            $warna = "";
          } else {
            $warna = "#F5F5F5";
          }
        ?>
          <tr bgcolor="<?php echo $warna; ?>">
            <td><?php echo $nomor; ?></td>
            <td><?php echo $myData['kd_petugas']; ?></td>
            <td><?php echo $myData['nm_petugas']; ?></td>
            <td><?php echo $myData['no_telepon']; ?></td>
            <td><?php echo $myData['username']; ?></td>
            <td><?php echo $myData['nm_departemen']; ?></td>
            <td><?php echo $myData['level']; ?></td>
            <td width="40" align="center">
              <a href="?open=Petugas-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('YAKIN AKAN MENGHAPUS DATA PETUGAS INI ... ?')">
                <button class="btn btn-danger" title="Hapus Data"><i class="fa fa-trash"></i>
                </button>
              </a>
            </td>
            <td width="40" align="center">
              <a href="?open=Petugas-Edit&Kode=<?php echo $Kode; ?>" target="_self">
                <button class="btn btn-warning" title="Edit Data"><i class="fa fa-pencil"></i>
                </button>
              </a>
            </td>
          </tr>
        <?php } ?>
      </table> <br><br>
    </td>
  </tr>
</table>
</div>