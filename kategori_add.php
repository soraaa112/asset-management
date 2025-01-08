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

	# Tombol Simpan diklik
	if (isset($_POST['btnSimpan'])) {
		# Baca Variabel Form
		$txtNama = $_POST['txtNama'];
		$txtDeskripsi = $_POST['txtDeskripsi'];

		# Validasi form, jika kosong sampaikan pesan error
		$pesanError = array();
		if (trim($txtNama) == "") {
			$pesanError[] = "Data <b>Nama Kategori</b> tidak boleh kosong !";
		}
		if (trim($txtDeskripsi) == "") {
			$pesanError[] = "<b>Deskripsi Barang</b> tidak boleh kosong !";
		}

		# Validasi Nama Kategori, jika sudah ada akan ditolak
		$cekSql = "SELECT * FROM kategori WHERE nm_kategori='$txtNama'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			$pesanError[] = "Maaf, Nama Kategori <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
			$kodeBaru	= buatKode4($koneksidb, "kategori", "K");
			$mySql	= "INSERT INTO kategori (kd_kategori, nm_kategori, deskripsi) VALUES ('$kodeBaru','$txtNama', '$txtDeskripsi')";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Kategori Berhasil Ditambah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Data'>";
			}
			exit;
		}
	} // Penutup Tombol Simpan

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Data'>";
	}

	# MASUKKAN DATA KE VARIABEL
	// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
	$dataKode	= buatKode4($koneksidb, "kategori", "K");
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataDeskripsi	= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : '';
	?>

	</SCRIPT>
	<div class="table-border">
		<h2>TAMBAH DATA KATEGORI</h2>
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
					<label for="txtNama" class="col-lg-2 control-label">Nama Kategori</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtNama" id="txtNama" value="<?php echo $dataNama; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="txtDeskripsi" class="col-lg-2 control-label">Deskripsi</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtDeskripsi" id="txtDeskripsi" value="<?php echo $dataDeskripsi; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
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
		</form>
	</div>