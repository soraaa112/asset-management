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

		# Validasi form, jika kosong sampaikan pesan error
		$pesanError = array();
		if (trim($txtNama) == "") {
			$pesanError[] = "Data <b>Nama Departemen</b> tidak boleh kosong !";
		}

		# Validasi Nama Departemen, jika sudah ada akan ditolak
		$cekSql = "SELECT * FROM departemen WHERE nm_departemen='$txtNama'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			$pesanError[] = "Maaf, Departemen <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
			$kodeBaru	= buatKode4($koneksidb, "departemen", "D");
			$mySql	= "INSERT INTO departemen (kd_departemen, nm_departemen) VALUES ('$kodeBaru', '$txtNama')";
			$myQry	= mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
			if ($myQry) {
				echo "<script>alert('Data Departemen Berhasil Ditambah')</script>";
				echo "<meta http-equiv='refresh' content='0; url=?open=Departemen-Data'>";
			}
			exit;
		}
	} // Penutup Tombol Simpan

	if (isset($_POST['btnKembali'])) {

		echo "<meta http-equiv='refresh' content='0; url=?open=Departemen-Data'>";
	}

	# MASUKKAN DATA KE VARIABEL
	// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
	$dataKode	= buatKode4($koneksidb, "departemen", "D");
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';

	?>

	</SCRIPT>
	<div class="table-border">
		<h2>TAMBAH DATA DEPARTEMEN</h2>
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
					<label for="txtNama" class="col-lg-2 control-label">Nama Departemen</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="txtNama" id="txtNama" value="<?php echo $dataNama; ?>" autocomplete="off" style="display: block; margin-bottom: 10px;">
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