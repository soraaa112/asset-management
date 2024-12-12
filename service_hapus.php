<?php
include_once "library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	$Kode	= $_GET['Kode'];

	# JIKA TIDAK MENEMUKAN ERROR

	// Hapus data pada tabel anak (pengadaan_item)
	$hapusSql = "DELETE FROM service_item WHERE no_service='$Kode'";
	mysql_query($hapusSql, $koneksidb) or die("Eror hapus data 1 " . mysql_error());

	// Hapus data sesuai Kode yang didapat di URL
	$hapus3Sql = "DELETE FROM services WHERE no_service='$Kode'";
	mysql_query($hapus3Sql, $koneksidb) or die("Eror hapus data 3 " . mysql_error());

	// Refresh halaman
	echo "<script>alert('Data Service Berhasil Dihaous')</script>";
	echo "<meta http-equiv='refresh' content='0; url=?open=Service-Tampil'>";
} else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
