<?php
include_once "library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	$Kode	= $_GET['Kode'];

	# JIKA TIDAK MENEMUKAN ERROR

	// Hapus data pada tabel anak (pengadaan_item)
	$hapusSql = "DELETE FROM barang_mati WHERE no_barang_mati='$Kode'";
	mysql_query($hapusSql, $koneksidb) or die("Eror hapus data 1 " . mysql_error());

	// Refresh halaman
	echo "<script>alert('Data Barang Mati Berhasil Dihapus')</script>";
	echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Mati-Tampil'>";
} else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
