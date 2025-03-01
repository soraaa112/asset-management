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
	$cekSql	= "SELECT * FROM vendor_service WHERE kd_vendor_service='$txtNama'";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$pesanError[] = "Maaf, vendor <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database	
		$kodeBaru	= buatKode("vendor_service", "V");
		$mySql	= "INSERT INTO vendor_service (kd_vendor_service, nm_vendor_service, alamat, no_telpon) 
					VALUES ('$kodeBaru',
							'$txtNama',
							'$txtAlamat',
							'$txtTelepon')";
		$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
		if ($myQry) {
			echo "<script>alert('Data Vendor Service Berhasil Ditambah')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Vendor-Data'>";
		}
		exit;
	}
} // Penutup Tombol Simpan

if (isset($_POST['btnKembali'])) {

	echo "<meta http-equiv='refresh' content='0;  url=?open=Vendor-Data'>";
}

# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
$dataKode	= buatKode("vendor_service", "V");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
	<table width="100%" cellpadding="2" cellspacing="1" class="table-list">
		<tr>
			<th colspan="3">TAMBAH DATA SUPPLIER </th>
		</tr>
		<tr>
			<td width="15%"><b>Kode</b></td>
			<td width="1%"><b>:</b></td>
			<td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly="readonly" /></td>
		</tr>
		<tr>
			<td><b>Nama Vendor </b></td>
			<td><b>:</b></td>
			<td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
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