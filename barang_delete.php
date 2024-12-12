<?php
include_once "library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	// Kode
	$Kode	 = $_GET['Kode'];

	# VALIDASI
	$pesanError = array();

	$cekSql	= "SELECT * FROM pengadaan_item WHERE pengadaan_item.kd_barang ='$Kode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Cek 1 : " . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {

		$pesanError[] = "<b>Barang sudah masuk di transaksi pengadaan</b>, sehingga penghapusan dibatalkan !";
	}
	// Baca data Kode Inventaris dari Pengadaan yang akan dihapus
	// Jika ternata Kode/Barang sudah ada yang Ditempatkan, atau ditempatkan, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT * FROM penempatan_item, barang_inventaris WHERE penempatan_item.kd_inventaris = barang_inventaris.kd_inventaris AND barang_inventaris.kd_barang='$Kode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Cek 1 : " . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$qtyPenempatan	= mysql_num_rows($cekQry);

		$pesanError[] = "<b>Ada $qtyPenempatan Barang yang sudah Ditempatkan</b>, sehingga penghapusan dibatalkan !";
	}

	// Baca data Kode Inventaris dari Pengadaan yang akan dihapus
	// Jika ternata Kode/Barang sudah ada yang dipinjam, atau ditempatkan, maka Penghapusan Gagal (Tidak diijinkan)
	$cekSql	= "SELECT * FROM peminjaman_item, barang_inventaris WHERE peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris AND barang_inventaris.kd_barang='$Kode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die("Gagal Query Cek 1 : " . mysql_error());
	if (mysql_num_rows($cekQry) >= 1) {
		$qtyPeminjaman	= mysql_num_rows($cekQry);

		$pesanError[] = "<b>Ada $qtyPeminjaman Barang yang sudah Dipinjam</b>, sehingga penghapusan dibatalkan !";
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
		echo "<meta http-equiv='refresh' content='3; url=?open=Barang-Data'>";
	} else {
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM barang WHERE kd_barang='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die("Eror hapus data" . mysql_error());
		if ($myQry) {
			// Hapus data pada tabel Inventaris
			$my2Sql = "DELETE FROM barang_inventaris WHERE kd_inventaris='$Kode'";
			mysql_query($my2Sql, $koneksidb) or die("Eror hapus data" . mysql_error());

			// Refresh halaman
			echo "<script>alert('Data Barang Berhasil Dihapus')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
		}
	}
} else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
