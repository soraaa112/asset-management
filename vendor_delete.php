<?php
include_once "library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	$Kode	= $_GET['Kode'];

	# VALIDASI
	$pesanError = array();

	// Baca data Kode Lokasi yang akan dihapus
	// Jika ternyata Kode/Barang sudah ada yang Ditempatkan, atau ditempatkan, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT * FROM vendor_service, services
	WHERE vendor_service.kd_vendor_service = services.kd_vendor_service 
	AND vendor_service.kd_vendor_service = '$Kode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Cek 1 : " . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$qtyPenempatan	= mysql_num_rows($cekQry);
		$dataCek = mysql_fetch_array($cekQry);
		$lokasi = $dataCek['nm_vendor_service'];

		$pesanError[] = "<b>Ada $qtyPenempatan Data Service dengan Vendor $lokasi</b>, sehingga penghapusan dibatalkan !";
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
		echo "<meta http-equiv='refresh' content='2; url=?open=Vendor-Data'>";
	} else {

		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM vendor_service WHERE kd_vendor_service='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die("Eror hapus data" . mysql_error());
		if ($myQry) {
			// Refresh halaman
			echo "<script>alert('Data Vendor Service Berhasil Dihapus')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Vendor-Data'>";
		}
	}
} else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
