<?php
include_once "library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	$Kode	= $_GET['Kode'];

	# VALIDASI
	$pesanError = array();

	// Baca data Kode Lokasi yang akan dihapus
	// Jika ternyata Kode/Barang sudah ada yang Ditempatkan, atau ditempatkan, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT lokasi.*, penempatan.kd_lokasi, penempatan.kd_departemen, penempatan.no_penempatan, penempatan.keterangan, penempatan.jenis, penempatan_item.kd_inventaris, penempatan_item.status_aktif
	FROM penempatan, penempatan_item, lokasi
	WHERE penempatan.kd_lokasi = lokasi.kd_lokasi
	AND penempatan.no_penempatan = penempatan_item.no_penempatan
	AND lokasi.kd_lokasi='$Kode'
	AND penempatan_item.status_aktif = 'Yes'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Cek 1 : " . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$qtyPenempatan	= mysql_num_rows($cekQry);
		$dataCek = mysql_fetch_array($cekQry);
		$lokasi = $dataCek['nm_lokasi'];

		$pesanError[] = "<b>Ada $qtyPenempatan Barang yang sudah Ditempatkan di lokasi $lokasi</b>, sehingga penghapusan dibatalkan !";
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
		echo "<meta http-equiv='refresh' content='3; url=?open=Lokasi-Data'>";
	} else {
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM lokasi WHERE kd_lokasi='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die("Eror hapus data" . mysql_error());
		if ($myQry) {
			// Refresh halaman
			echo "<script>alert('Data Lokasi Berhasil Dihapus')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Lokasi-Data'>";
		}
	}
} else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
