<?php
include_once "library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	$Kode	= $_GET['Kode'];

	# VALIDASI
	$pesanError = array();

	// Baca data Kode Pegawai yang akan dihapus
	// Jika ternyata Pegawai masih meminjam barang, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT pegawai.kd_pegawai, pegawai.nm_pegawai, pegawai.kd_departemen, peminjaman.no_peminjaman, peminjaman.kd_pegawai, peminjaman.status_kembali, peminjaman_item.* FROM peminjaman, pegawai, peminjaman_item WHERE pegawai.kd_pegawai = peminjaman.kd_pegawai AND peminjaman.no_peminjaman = peminjaman_item.no_peminjaman AND pegawai.kd_pegawai='$Kode' AND peminjaman.status_kembali = 'Pinjam'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Cek 1 : " . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$dataCek = mysql_fetch_array($cekQry);
		$namaPegawai = $dataCek['nm_pegawai'];

		$sql = "SELECT COUNT(peminjaman_item.kd_inventaris) AS total FROM peminjaman, peminjaman_item WHERE peminjaman.no_peminjaman = peminjaman_item.no_peminjaman AND peminjaman.kd_pegawai = '$Kode' AND peminjaman.status_kembali='Pinjam'";
		$my2Qry = mysql_query($sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
		$myData = mysql_fetch_array($my2Qry);

		$total = $myData['total'];

		$pesanError[] = "<b>$namaPegawai masih meminjam $total barang</b>, sehingga penghapusan dibatalkan !";
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
		echo "<meta http-equiv='refresh' content='3; url=?open=Pegawai-Data'>";
	} else {
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM pegawai WHERE kd_pegawai='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die("Eror hapus data" . mysql_error());
		if ($myQry) {
			// Refresh halaman
			echo "<script>alert('Data Pegawai Berhasil Dihapus')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Data'>";
		}
	}
} else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
