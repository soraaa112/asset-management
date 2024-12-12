<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/bar128.php";
?>
<html>

<head>
	<title> :: Cetak Label Barang</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		<!--
		body,
		td,
		th {
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 11px;
		}

		body {
			margin-top: 1px;
		}
		-->
	</style>

</head>

<body>
	<table class="table-list" width="200" border="0" cellspacing="40" cellpadding="4">
		<tr>
			<?php
			$Kode = $_POST['txtKode'];

			# JIKA MENEMUKAN CBKODE, salah satu Cekbox dipilih dan klik tombol Cetak Barcode
			if (isset($_POST['cbKode'])) {
				$cbKode = $_POST['cbKode'];
				$jum  = count($cbKode);
				if ($jum == 0) {
					echo "BELUM ADA KODE BARANG YANG DIPILIH";
					echo "<meta http-equiv='refresh' content='1; url=index.php?open=Cetak-Barcode-View&Kode=$Kode'>";
				} else {
					$no = 0;
					$lebar = 3;
					$no++;
					foreach ($_POST['cbKode'] as $indeks => $nilai) {
			?>
						<td width="201" valign="top" align="center">
							<br>
							<?php
							$mySql = "SELECT barang_inventaris.*, barang.nm_barang, kategori.nm_kategori FROM barang_inventaris 
							LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
							LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
							WHERE barang_inventaris.kd_inventaris='$nilai' AND barang_inventaris.status_barang !='' ";
							$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
							while ($myData = mysql_fetch_array($myQry)) {
								$KodeInventory = $myData['kd_inventaris'];

								if ($myData['status_barang'] == "Ditempatkan") {
									$my2Sql = "SELECT lokasi.nm_lokasi, departemen.nm_departemen FROM penempatan_item as PI
									LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
									LEFT JOIN departemen ON penempatan.kd_departemen=departemen.kd_departemen
									LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
									WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$KodeInventory'";
									$my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query salah : " . mysql_error());
									$my2Data = mysql_fetch_array($my2Qry);
									$infoLokasi	= $my2Data['nm_lokasi'];
									$infoDepartemen	= $my2Data['nm_departemen'];

									$data = $myData['kd_inventaris'] . " / "  . $myData['status_barang'] . " / " . $infoLokasi . " / " . $infoDepartemen . " / " . $myData['nm_barang'] . " / " . $myData['nm_kategori'] . " / "  . Inggris($myData['tgl_masuk']);
									$simpan = "kode " . $myData["kd_inventaris"] . ".png";
									require_once('library/phpqrcode/qrlib.php');
									QRcode::png("$data", "images/qrcode/" . $simpan, "M", 2, 1);
								} elseif
								// Mencari Siapa Penempatan Barang
								($myData['status_barang'] == "Dipinjam") {
									$my3Sql = "SELECT pegawai.nm_pegawai, departemen.nm_departemen FROM peminjaman_item as PI
									LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
									LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
									LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
									WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$KodeInventory'";
									$my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query salah : " . mysql_error());
									$my3Data = mysql_fetch_array($my3Qry);
									$infoLokasi	= $my3Data['nm_pegawai'];
									$infoDepartemen	= $my3Data['nm_departemen'];

									$data = $myData['kd_inventaris'] . " / " . $myData['status_barang'] . " / " . $infoLokasi . " / " . $infoDepartemen  . " / " . $myData['nm_barang'] . " / " . $myData['nm_kategori'] . " / "  . Inggris($myData['tgl_masuk']);
									$simpan = "kode " . $myData["kd_inventaris"] . ".png";
									require_once('library/phpqrcode/qrlib.php');
									QRcode::png("$data", "images/qrcode/" . $simpan, "M", 2, 1);
								} else {
									$my3Sql = "SELECT petugas.nm_petugas, departemen.nm_departemen FROM pengadaan as PI
									LEFT JOIN barang_inventaris ON PI.no_pengadaan = barang_inventaris.no_pengadaan
									LEFT JOIN petugas ON PI.kd_petugas=petugas.kd_petugas
									LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
									WHERE barang_inventaris.status_barang='Tersedia' AND barang_inventaris.kd_inventaris='$KodeInventory'";
									$my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query salah : " . mysql_error());
									$my3Data = mysql_fetch_array($my3Qry);
									$infoLokasi	= $my3Data['nm_petugas'];
									$infoDepartemen	= $my3Data['nm_departemen'];

									$data = $myData['kd_inventaris'] . " / " . $myData['status_barang'] . " / " . $infoLokasi . " / " . $infoDepartemen  . " / " . $myData['nm_barang'] . " / " . $myData['nm_kategori'] . " / "  . Inggris($myData['tgl_masuk']);
									$simpan = "kode " . $myData["kd_inventaris"] . ".png";
									require_once('library/phpqrcode/qrlib.php');
									QRcode::png("$data", "images/qrcode/" . $simpan, "M", 2, 1);
								}
							}
							?>
							<img src="images/favicon-nht.png" alt="" width="100" height="50">
							<img src="images/qrcode/<?= $simpan; ?>" style="width:100%; height:100%;">
							<?= $nilai; ?>
						</td>
			<?php
						// Membuat TR tabel
						if ($no == $lebar) {
							echo "</tr>";
							$lebar = $lebar + 4;
						}
					}  // End foreach
				}
			} else {
				echo "BELUM ADA KODE BARANG YANG DIPILIH";
				echo "<meta http-equiv='refresh' content='1; url=index.php?open=Cetak-Barcode-View&Kode=$Kode'>";
			} ?>
	</table>
	* Selanjutnya, label QR Code di atas dapat Anda cetak ke printer. Lalu, label dapat ditempel pada aset barang.
</body>

</html>