<?php
include_once "library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	$Kode	= $_GET['Kode'];

	# VALIDASI
	$pesanError = array();

	// Baca data Kode Inventaris dari Pengadaan yang akan dihapus
	// Jika ternata Kode/Barang sudah ada yang Ditempatkan, atau ditempatkan, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT petugas.kd_petugas, petugas.nm_petugas, pengadaan.* FROM petugas, pengadaan
	WHERE petugas.kd_petugas = pengadaan.kd_petugas
	AND petugas.kd_petugas='$Kode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Cek 1 : " . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$dataRow = mysql_fetch_array($cekQry);
		$user = $dataRow['nm_petugas'];

		$pesanError[] = "<b>User $user sudah melakukan pengadaan barang</b>, sehingga penghapusan dibatalkan !";
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
		echo "<meta http-equiv='refresh' content='3; url=?open=Petugas-Data'>";
	} else {
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM petugas WHERE kd_petugas='$Kode' AND username !='admin'";
		$myQry = mysql_query($mySql, $koneksidb) or die("Eror hapus data" . mysql_error());
		if ($myQry) {
			// Refresh halaman
			echo "<script>alert('Data Pengguna Berhasil Dihapus')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Petugas-Data'>";
		}
	}
} else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
