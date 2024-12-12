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
		$filterSQL = "WHERE LEFT(tgl_peminjaman,4)='$dataTahun'";
	} else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_peminjaman,4)='$dataTahun' AND MID(tgl_peminjaman,6,2)='$dataBulan'";
	}
} else {
	$filterSQL = "";
}


# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	//echo "window.open('cetak/peminjaman_bulan.php?bulan=$dataBulan&tahun=$dataTahun', width=330,height=330,left=100, top=25)";
	echo "window.open('cetak/peminjaman_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM peminjaman $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml / $baris);
?>
<div class="table-border">
	<h2>LAPORAN DATA PEMINJAMAN PER BULAN &amp; TAHUN </h2>
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
						$thnSql = "SELECT MIN(LEFT(tgl_peminjaman,4)) As tahun_kecil, MAX(LEFT(tgl_peminjaman,4)) As tahun_besar FROM peminjaman";
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
			<td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
			<td width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
			<td width="110" bgcolor="#CCCCCC"><strong>No. Peminjaman</strong></td>
			<td width="229" bgcolor="#CCCCCC"><strong>Type barang</strong></td>
			<td width="120" bgcolor="#CCCCCC"><strong>Pegawai/ Peminjam </strong></td>
			<td width="100" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
			<td width="50" bgcolor="#CCCCCC"><strong>Status</strong></td>
			<td width="50" align="center" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
			<td width="37" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
		</tr>
		<?php
		if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
			if ($dataTahun and $dataBulan) {
				$mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
				LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
				LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
				LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
				LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
				$filterSQL
				AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
				ORDER BY peminjaman.no_peminjaman DESC LIMIT $hal, $baris";
				$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
				$nomor = $hal;
			} else {
				$mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
				LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
				LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
				LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
				LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
				$filterSQL
				WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'
				ORDER BY peminjaman.no_peminjaman DESC LIMIT $hal, $baris";
				$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
				$nomor = $hal;
			}
		} else {
			// Skrip menampilkan data Transaksi Peminjaman dilengkapi informasi Pegawai
			$mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman 
			LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
			LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
			LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
			LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
			$filterSQL
			ORDER BY peminjaman.no_peminjaman DESC LIMIT $hal, $baris";
			$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
			$nomor = $hal;
		}
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;

			// Membaca Kode peminjaman/ Nomor transaksi
			$noNota = $myData['no_peminjaman'];

			// Menghitung Total barang yang dipinjam setiap nomor transaksi
			$my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
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
				<td><?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?></td>
				<td><?php echo $myData['no_peminjaman']; ?></td>
				<td><?php echo $myData['nm_barang']; ?></td>
				<td><?php echo $myData['nm_pegawai']; ?></td>
				<td><?php echo $myData['nm_departemen']; ?></td>
				<td><?php echo $myData['status_kembali']; ?></td>
				<td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
				<td align="center">
					<a href="cetak/peminjaman_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">
						<button class="btn btn-success" title="Cetak Data"><i class="fa fa-print"></i>
						</button>
					</a>
				</td>
			</tr>
		<?php } ?>
		<tr>
			<td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
			<td colspan="6" align="right"><b>Halaman ke :</b>
				<?php
				for ($h = 1; $h <= $max; $h++) {
					$list[$h] = $baris * $h - $baris;
					echo " <a href='?open=Laporan-Peminjaman-Bulan&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
				}
				?></td>
		</tr>
	</table>
	<br />
	<a <?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) { ?> href="cetak/peminjaman_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>&departemen=<?php echo $dataunit ?>" <?php } else { ?> href="cetak/peminjaman_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" <?php } ?> target="_blank"><img src="images/btn_print2.png" border="0" title="Cetak ke Format HTML" /></a>
</div>