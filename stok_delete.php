<?php
include_once "library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	$Kode	= $_GET['Kode'];

	// Hapus data sesuai Kode yang didapat di URL
	$hapusSql = "DELETE FROM opname WHERE kd_opname='$Kode'";
	$myQry = mysql_query($hapusSql, $koneksidb) or die("Eror hapus data" . mysql_error());

	$hapus2Sql = "DELETE FROM opname_item WHERE kd_opname='$Kode'";
	$myQry = mysql_query($hapus2Sql, $koneksidb) or die("Eror hapus data" . mysql_error());
	// Refresh halaman
	echo "<meta http-equiv='refresh' content='0; url=?open=Stok-Opname'>";
} else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
