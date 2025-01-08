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
		// if (trim($_POST['txtAlamat']) == "") {
		// 	$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong !";
		// }
		// if (trim($_POST['txtTelepon']) == "") {
		// 	$pesanError[] = "Data <b>No Telepon</b> tidak boleh kosong !";
		// }

		# Validasi Nama Supplier, jika sudah ada akan ditolak
		$Kode	= $_POST['txtKode'];
		$cekSql	= "SELECT * FROM supplier WHERE nm_supplier='$txtNama' AND NOT(kd_supplier='$Kode')";
		$cekQry	= mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			$pesanError[] = "Maaf, Supplier <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
			$mySql	= "UPDATE supplier SET nm_supplier='$txtNama', alamat='$txtAlamat',
						no_telepon='$txtTelepon' WHERE kd_supplier ='$Kode'";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Supplier Berhasil Diubah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Supplier-Data'>";
			}
			exit;
		}
	} // Penutup Tombol Simpan

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0;  url=?open=Supplier-Data'>";
	}

	# MENGAMBIL DATA YANG DIEDIT, SESUAI KODE YANG DIDAPAT DARI URL
	$Kode	= $_GET['Kode'];
	$mySql	= "SELECT * FROM supplier WHERE kd_supplier='$Kode'";
	$myQry	= mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
	$myData = mysql_fetch_array($myQry);

	# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
	$dataKode	= $myData['kd_supplier'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_supplier'];
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
	$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	?>
	</SCRIPT>
	<div class="table-border">
		<h2>UBAH DATA SUPPLIER</h2>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group">
					<label for="textfield" class="col-lg-2 control-label">Kode</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="textfield" id="textfield" value="<?php echo $dataKode; ?>" readonly autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="txtNama" class="col-lg-2 control-label">Nama Supplier</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtNama" id="txtNama" value="<?php echo $dataNama; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="txtTelepon" class="col-lg-2 control-label">No. Telepon</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtTelepon" id="txtTelepon" value="<?php echo $dataTelepon; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="txtAlamat" class="col-lg-2 control-label">Alamat Lengkap</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtAlamat" id="txtAlamat" value="<?php echo $dataAlamat; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10" style="display: block; margin-top: 40px;">
						<button type="submit" name="btnSimpan" class="btn btn-success">
							<span class="glyphicon glyphicon-floppy-saved" aria-hidden="true">&nbsp;</span><b>SIMPAN</b>
						</button>
						<button type="submit" name="btnKembali" class="btn btn-danger">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true">&nbsp;</span><b>KEMBALI</b>
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>