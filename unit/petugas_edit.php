<?php
include_once "library/inc.seslogin.php";

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNama		= $_POST['txtNama'];
	$txtUsername	= $_POST['txtUsername'];
	$txtPassword	= $_POST['txtPassword'];	
	$txtTelepon		= $_POST['txtTelepon'];	
	$cmbLevel		= $_POST['cmbLevel'];
	$txtUnit		= $_POST['txtUnit'];
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Petugas</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($cmbLevel)=="Kosong") {
		$pesanError[] = "Data <b>Level login</b> belum dipilih, silahkan dipilih dari Combo !";		
	}
	if (trim($txtUnit)=="") {
		$pesanError[] = "Data <b>Unit</b> tidak boleh kosong, silahkan diisi !";		
	}
			
	# VALIDASI petugas LOGIN (username), jika sudah ada akan ditolak
	$Kode	= $_POST['txtKode'];
	$cekSql	= "SELECT * FROM petugas WHERE username='$txtUsername' AND NOT(kd_petugas ='$Kode')";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Username : <b> $txtUsername </b> sudah ada, ganti dengan yang lain";
	}

	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# Cek Password baru
		if (trim($txtPassword)=="") {
			$txtPassLama	= $_POST['txtPassLama'];
			
			$sqlPasword = ", password='$txtPassLama'";
		}
		else {
			$sqlPasword = ",  password ='".md5($txtPassword)."'";
		}
		
		# SIMPAN DATA KE DATABASE (Jika tidak menemukan error, simpan data ke database)
		$Kode	= $_POST['txtKode'];
		$mySql  = "UPDATE petugas SET nm_petugas='$txtNama', username='$txtUsername', 
					no_telepon='$txtTelepon', level='$cmbLevel', unit='$txtUnit'
					$sqlPasword  
					WHERE kd_petugas='$Kode'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Petugas-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan


# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
$Kode	= $_GET['Kode']; 
$mySql	= "SELECT * FROM petugas WHERE kd_petugas='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	// Data Variabel Temporary (sementara)
	$dataKode		= $myData['kd_petugas'];
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_petugas'];
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
	$dataTelepon	= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $myData['level'];
	$dataUnit		= isset($_POST['txtUnit']) ? $_POST['txtUnit'] : $myData['unit'];
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH DATA PETUGAS</b></th>
    </tr>
    <tr>
      <td width="178"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="1106"> <input name="textfield" type="text"  value="<?php echo $dataKode; ?>" size="10" maxlength="5"  readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><b>Nama Petugas </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>No. Telepon </b></td>
      <td><b>:</b></td>
      <td><input name="txtTelepon" type="text" value="<?php echo $dataTelepon; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Username</b></td>
      <td><b>:</b></td>
      <td><input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="20" maxlength="20" /></td>
    </tr>
	<tr>
      <td><b>Unit</b></td>
      <td><b>:</b></td>
      <td><input name="txtUnit" type="text"  value="<?php echo $dataUnit; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><input name="txtPassword" type="password" size="20" maxlength="20" />
      <input name="txtPassLama" type="hidden" value="<?php echo $myData['password']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Level</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbLevel">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("Petugas", "Admin", "Operator");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
