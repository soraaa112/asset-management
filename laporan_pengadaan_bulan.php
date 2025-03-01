<?php
session_start();
include_once "library/inc.seslogin.php";

// Variabel SQL
$filterSQL = "";

# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
	$unit = isset($_GET['departemen']) ? $_GET['departemen'] : $_SESSION["SES_UNIT"];
	$dataunit = isset($_POST['departemen']) ? $_POST['departemen'] : $unit;
}

# Membuat Filter Bulan
if ($dataTahun and $dataBulan) {
	if ($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(tgl_pengadaan,4)='$dataTahun'";
	} else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_pengadaan,4)='$dataTahun' AND MID(tgl_pengadaan,6,2)='$dataBulan'";
	}
} else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/pengadaan_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pengadaan $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData / $barisData);
?>
<div class="table-border">
	<h2>LAPORAN DATA PENGADAAN PER BULAN &amp; TAHUN </h2>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
		<table width="900" border="0" class="table-list">
			<tr>
				<td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
			</tr>
			<tr>
				<td width="113"><strong>Periode Bulan </strong></td>
				<td width="5"><strong>:</strong></td>
				<td width="768"><select name="cmbBulan">
						<?php
						// Membuat daftar Nama Bulan
						$listBulan = array(
							"00" => "Semua", "01" => "Januari", "02" => "Februari", "03" => "Maret",
							"04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
							"08" => "Agustus", "09" => "September", "10" => "Oktober",
							"11" => "November", "12" => "Desember"
						);

						// Menampilkan Nama Bulan ke ComboBox (List/Menu)
						foreach ($listBulan as $bulanKe => $bulanNm) {
							if ($bulanKe == $dataBulan) {
								$cek = " selected";
							} else {
								$cek = "";
							}
							echo "<option value='$bulanKe' $cek>$bulanNm</option>";
						}
						?>
					</select>
					<select name="cmbTahun">
						<?php
						# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
						$thnSql = "SELECT MIN(LEFT(tgl_pengadaan,4)) As tahun_kecil, MAX(LEFT(tgl_pengadaan,4)) As tahun_besar FROM pengadaan";
						$thnQry	= mysql_query($thnSql, $koneksidb) or die("Error" . mysql_error());
						$thnRow	= mysql_fetch_array($thnQry);

						// Membaca tahun
						$thnKecil = $thnRow['tahun_kecil'];
						$thnBesar = $thnRow['tahun_besar'];

						// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
						for ($thn = $thnKecil; $thn <= $thnBesar; $thn++) {
							if ($thn == $dataTahun) {
								$cek = " selected";
							} else {
								$cek = "";
							}
							echo "<option value='$thn' $cek>$thn</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input name="btnTampil" type="submit" value=" Tampilkan " />
				</td>
			</tr>
		</table>
	</form>

	<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td width="21" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
			<td width="80" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
			<td width="120" bgcolor="#CCCCCC"><strong>No. Pengadaan</strong></td>
			<td width="200" bgcolor="#CCCCCC"><strong>Nama Petugas</strong></td>
			<td width="201" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
			<td width="40" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
			<td width="90" align="right" bgcolor="#CCCCCC"><strong>Harga</strong></td>
			<td width="90" align="right" bgcolor="#CCCCCC"><strong>Total (Rp) </strong></td>
			<td width="60" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
		</tr>
		<?php
		if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
			# Perintah untuk menampilkan Semua Data Transaksi Pengadaan, menggunakan Filter Periode
			if ($dataTahun and $dataBulan) {
				$mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen, barang.nm_barang, petugas.nm_petugas FROM pengadaan 
			  LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
			  LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
			  LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
			  LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
			  LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
				$filterSQL
				and departemen.nm_departemen = '$_SESSION[SES_UNIT]'
				ORDER BY pengadaan.no_pengadaan DESC LIMIT $halaman, $barisData";
			} else {
				$mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen, barang.nm_barang, petugas.nm_petugas FROM pengadaan 
			LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
			LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
			LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
			LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
			LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
			$filterSQL
			WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'
			ORDER BY pengadaan.no_pengadaan DESC LIMIT $halaman, $barisData";
			}
			$myQry = mysql_query($mySql, $koneksidb)  or die("Query pengadaan salah : " . mysql_error());
			$nomor = $hal;
		} else {
			# Skrip untuk menampilkan Data Trans Pengadaan, dilengkapi informasi Supplier dari tabel relasi
			$mySql = "SELECT pengadaan.*, supplier.nm_supplier, petugas.nm_petugas, barang.nm_barang FROM pengadaan 
			LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
			LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
			LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
			LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
			LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
			$filterSQL
			ORDER BY pengadaan.no_pengadaan DESC LIMIT $halaman, $barisData";
			$myQry = mysql_query($mySql, $koneksidb)  or die("Query 1 salah : " . mysql_error());
			$nomor = $halaman;
		}
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;

			# Membaca Kode pengadaan/ Nomor transaksi
			$Kode = $myData['no_pengadaan'];

			# Menghitung Total pengadaan (belanja) setiap nomor transaksi
			$my2Sql = "SELECT SUM(jumlah) AS total_barang,  
						  SUM(harga_beli * jumlah) AS total_belanja, harga_beli 
				   FROM pengadaan_item WHERE no_pengadaan='$Kode'";
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
			$my2Data = mysql_fetch_array($my2Qry);

			// gradasi warna
			if ($nomor % 2 == 1) {
				$warna = "";
			} else {
				$warna = "#F5F5F5";
			}
		?>
			<tr bgcolor="<?php echo $warna; ?>">
				<td align="center"><?php echo $nomor; ?></td>
				<td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
				<td><?php echo $myData['no_pengadaan']; ?></td>
				<td><?php echo $myData['nm_petugas']; ?></td>
				<td><?php echo $myData['keterangan']; ?></td>
				<td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
				<td align="right"><?php echo format_angka($my2Data['harga_beli']); ?></td>
				<td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
				<td align="center">
					<a href="cetak/pengadaan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">
						<button class="btn btn-success" title="Cetak Data"><i class="fa fa-print"></i>
						</button>
					</a>
				</td>
			</tr>
		<?php } ?>
		<tr>
			<td colspan="3"><b>Jumlah Data :</b> <?php echo $jumData; ?></td>
			<td colspan="6" align="right"><b>Halaman ke :</b>
				<?php
				for ($h = 1; $h <= $maksData; $h++) {
					$list[$h] = $barisData * $h - $barisData;
					echo " <a href='?open=Laporan-Pengadaan-Bulan&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
				}
				?></td>
		</tr>
	</table>
	<br />
	<a <?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) { ?> href="cetak/pengadaan_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>&departemen=<?php echo $dataunit ?>" <?php } else { ?> href="cetak/pengadaan_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" <?php } ?> target="_blank"><img src="images/btn_print2.png" border="0" title="Cetak ke Format HTML" /></a>
</div>