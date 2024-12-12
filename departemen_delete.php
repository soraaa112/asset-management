<?php
include_once "library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	$Kode	= $_GET['Kode'];

	# VALIDASI
	$pesanError = array();

	// Baca data Kode Departemen yang akan dihapus
	// Jika ternyata Departemen masih ada, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT * FROM pegawai, departemen WHERE pegawai.kd_departemen = departemen.kd_departemen AND departemen.kd_departemen='$Kode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Cek 1 : " . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$total = mysql_num_rows($cekQry);

		$cekData = mysql_fetch_array($cekQry);
		$departemen = $cekData['nm_departemen'];

		$pesanError[] = "<b>Ada $total pegawai di Departemen $departemen </b>, sehingga penghapusan dibatalkan !";
	}

	// Baca data Kode Departemen yang akan dihapus
	// Jika ternyata Departemen masih ada, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT * FROM penempatan, departemen WHERE penempatan.kd_departemen = departemen.kd_departemen AND departemen.kd_departemen='$Kode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Cek 1 : " . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$cekData = mysql_fetch_array($cekQry);
		$departemen = $cekData['nm_departemen'];

		$pesanError[] = "<b>Ada barang yang ditempatkan di Departemen $departemen </b>, sehingga penghapusan dibatalkan !";
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
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='3; url=?open=Departemen-Data'>";
	} else {
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM departemen WHERE kd_departemen='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die("Eror hapus data" . mysql_error());
		if ($myQry) {
			// Refresh halaman
			echo "<script>alert('Data Departemen Berhasil Dihapus')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Departemen-Data'>";
		}
	}
} else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
