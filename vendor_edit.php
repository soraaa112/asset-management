<?php
include_once "library/inc.seslogin.php";

# TOMBOL SIMPAN DIKLIK
if (isset($_POST['btnSimpan'])) {
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$txtNama		= str_replace("'", "&acute;", $txtNama); // menghalangi penulisan tanda petik satu (')

	$txtAlamat		= $_POST['txtAlamat'];
	$txtAlamat		= str_replace("'", "&acute;", $txtAlamat); // menghalangi penulisan tanda petik satu (')

	$txtTelepon		= $_POST['txtTelepon'];

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($_POST['txtNama']) == "") {
		$pesanError[] = "Data <b>Nama Supplier</b> tidak boleh kosong !";
	}
	if (trim($_POST['txtAlamat']) == "") {
		$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong !";
	}
	if (trim($_POST['txtTelepon']) == "") {
		$pesanError[] = "Data <b>No Telepon</b> tidak boleh kosong !";
	}

	# Validasi Nama Supplier, jika sudah ada akan ditolak
	$Kode	= $_POST['txtKode'];
	$cekSql	= "SELECT * FROM vendor_service WHERE nm_vendor_service='$txtNama' AND NOT(kd_vendor_service='$Kode')";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$pesanError[] = "Maaf, Vendor <b> $txtNama </b> sudah ada, ganti dengan yang lain";
	}

	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError) >= 1) {
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
		$noPesan = 0;
		foreach ($pesanError as $indeks => $pesan_tampil) {
			$noPesan++;
			echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
		}
		echo "</div> <br>";
	} else {
		# SIMPAN PERUBAHAN DATA, Jika jumlah error pesanError tidak ada, simpan datanya
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE vendor_service SET nm_vendor_service='$txtNama', alamat='$txtAlamat',
					no_telpon='$txtTelepon' WHERE kd_vendor_service ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
		if ($myQry) {
			echo "<script>alert('Data Vendor Service Berhasil Diubah')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Vendor-Data'>";
		}
		exit;
	}
} // Penutup Tombol Simpan

# MENGAMBIL DATA YANG DIEDIT, SESUAI KODE YANG DIDAPAT DARI URL
$Kode	= $_GET['Kode'];
$mySql	= "SELECT * FROM vendor_service WHERE kd_vendor_service='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
$myData = mysql_fetch_array($myQry);

# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
$dataKode	= $myData['kd_vendor_service'];
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_vendor_service'];
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telpon'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
	<table class="table-list" width="100%">
		<tr>
			<th colspan="3">UBAH DATA VENDOR </th>
		</tr>
		<tr>
			<td width="15%"><b>Kode</b></td>
			<td width="1%"><b>:</b></td>
			<td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="8" maxlength="4" readonly="readonly" />
				<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
			</td>
		</tr>
		<tr>
			<td><b>Nama Supplier </b></td>
			<td><b>:</b></td>
			<td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
		</tr>
		<tr>
			<td><b>Alamat Lengkap </b></td>
			<td><b>:</b></td>
			<td><input name="txtAlamat" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200" /></td>
		</tr>
		<tr>
			<td><b>No Telepon </b></td>
			<td><b>:</b></td>
			<td><input name="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" maxlength="20" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="submit" name="btnSimpan" value=" Simpan ">
				<a href="?open=Vendor-Data">
					<input type="button" value=" Kembali " />
				</a>
			</td>
		</tr>
	</table>
</form>