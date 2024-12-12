<?php
session_start();
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Variabel SQL
$filterSQL	= "";
$cariSQL	= "";

// Variabel data Combo Lokasi
$kodeDepartemen	= isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua'; // dari URL
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen; // dari Form

// Variabel data Combo Lokasi
$kodeLokasi	= isset($_GET['kodeLokasi']) ? $_GET['kodeLokasi'] : 'Semua'; // dari URL
$dataLokasi	= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : $kodeLokasi; // dari Form

# MEMBUAT FILTER DATA
if (trim($dataLokasi) == "Semua") {
	if (trim($dataDepartemen) == "Semua") {
		// Jika Lokasi Kosong Semua, dan Departemen Kosong
		$filterSQL = "";
	} else {
		// dan Jika Lokasi Kosong (Semua), dan Departemen dipilih
		$filterSQL = " AND lokasi.kd_departemen='$dataDepartemen'";
	}
} else {
	// Jika Lokasi dipilih
	$filterSQL = "AND penempatan.kd_lokasi='$dataLokasi'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 10;  // Jumlah baris data
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql	= "SELECT PI.*, barang.nm_barang FROM penempatan_item as PI 
				LEFT JOIN penempatan ON PI.no_penempatan = penempatan.no_penempatan
				LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
				LEFT JOIN barang_inventaris ON PI.kd_inventaris = barang_inventaris.kd_inventaris
				LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			WHERE PI.status_aktif='Yes'
			$filterSQL ";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:" . mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml / $baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Pencarian Inventaris Barang - Inventory Kantor ( Aset Barang )</title>
	<link href="styles/style.css" rel="stylesheet" type="text/css">
	<!-- Live Search -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	<!-- Font Awwesome -->
	<link rel="stylesheet" href="https://fontawesome.com/icons/trash?f=classic&s=solid">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="styles/style.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="plugins/jQuery/jquery-1.12.3.min.js"></script>
</head>

<body>
	<SCRIPT language="JavaScript">
		function submitform() {
			document.form1.submit();
		}
	</SCRIPT>
	<div class="table-border">
		<div style="overflow-x:auto;">
			<h2><b>PENCARIAN BARANG </b>YANG DITEMPATKAN </h2>
			<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
				<table width="900" border="0" class="table-list">
					<tr>
						<td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
					</tr>
					<tr>
						<td><b> Departemen </b></td>
						<td><b>:</b></td>
						<td><select name="cmbDepartemen" onchange="javascript:submitform();" data-live-search="true" class="selectpicker">
								<option value="Semua"> Semua </option>
								<?php
								// Skrip menampilkan data Departemen dalam ComboBox
								$comboSql = "SELECT * FROM departemen ORDER BY kd_departemen";
								$comboQry = mysql_query($comboSql, $koneksidb) or die("Gagal Query" . mysql_error());
								while ($comboData = mysql_fetch_array($comboQry)) {
									if ($comboData['kd_departemen'] == $dataDepartemen) {
										$cek = " selected";
									} else {
										$cek = "";
									}
									echo "<option value='$comboData[kd_departemen]' $cek>$comboData[nm_departemen]</option>";
								}
								?>
							</select></td>
					</tr>
					<tr>
						<td width="156"><b> Lokasi </b></td>
						<td width="11"><b>:</b></td>
						<td width="719"><select name="cmbLokasi" data-live-search="true" class="selectpicker">
								<option value="Semua"> Semua </option>
								<?php
								// Menampilkan data Lokasi per Departemen yang dipilih dari ComboBox
								$comboSql = "SELECT * FROM lokasi WHERE kd_departemen='$dataDepartemen' ORDER BY kd_lokasi";
								$comboQry = mysql_query($comboSql, $koneksidb) or die("Gagal Query" . mysql_error());
								while ($comboData = mysql_fetch_array($comboQry)) {
									if ($comboData['kd_lokasi'] == $dataLokasi) {
										$cek = " selected";
									} else {
										$cek = "";
									}
									echo "<option value='$comboData[kd_lokasi]' $cek>$comboData[nm_lokasi]</option>";
								}
								?>
							</select>
							<input name="btnTampil2" type="submit" value=" Tampilkan " />
						</td>
					</tr>
				</table>
			</form>

			<table id="example1" class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
				<thead>
					<tr>
						<td width="28" bgcolor="#CCCCCC"><strong>No</strong></td>
						<td width="121" bgcolor="#CCCCCC"><strong>Kode Barang </strong></td>
						<td width="474" bgcolor="#CCCCCC"><strong>Type Barang </strong></td>
						<td width="150" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
						<td width="150" bgcolor="#CCCCCC"><strong>Lokasi</strong></td>
						<td width="150" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
					</tr>
				</thead>
				<tbody>
					<?php
					// Menampilkan data barang yang aktif ditempatkan dari tabel Penempatan_item
					$mySql	= "SELECT PI.*, barang.nm_barang, kategori.nm_kategori, lokasi.nm_lokasi, departemen.nm_departemen FROM penempatan_item as PI
					LEFT JOIN penempatan ON PI.no_penempatan = penempatan.no_penempatan
					LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
					LEFT JOIN barang_inventaris ON PI.kd_inventaris = barang_inventaris.kd_inventaris
					LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
					LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
					LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen
				WHERE PI.status_aktif='Yes' $filterSQL GROUP BY PI.kd_inventaris ";
					$myQry 	= mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
					$nomor  = $hal;
					while ($myData = mysql_fetch_array($myQry)) {
						$nomor++;
						$Kode = $myData['kd_inventaris'];
						// gradasi warna
						if ($nomor % 2 == 1) {
							$warna = "";
						} else {
							$warna = "#F5F5F5";
						}
					?>
						<tr bgcolor="<?php echo $warna; ?>">
							<td><?php echo $nomor; ?></td>
							<td>
								<a href="#" onClick="window.opener.document.getElementById('txtKodeInventaris').value = '<?php echo $myData['kd_inventaris']; ?>'; 
								window.opener.document.getElementById('txtNamaBrg').value = '<?php echo $myData['nm_barang']; ?>';
								window.close();">
									<b><?php echo $myData['kd_inventaris']; ?> </b> </a>
							</td>
							<td><?php echo $myData['nm_barang']; ?></td>
							<td><?php echo $myData['nm_kategori']; ?></td>
							<td><?php echo $myData['nm_lokasi']; ?></td>
							<td><?php echo $myData['nm_departemen']; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</body>

</html>

<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://almsaeedstudio.com/themes/AdminLTE/plugins/pace/pace.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<script type="text/javascript" src="plugins/js.popupWindow.js"></script>
<script>
	$(function() {
		$("#example1").DataTable();
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false
		});

		$('#example3').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": false,
			"info": false,
			"autoWidth": false,
			"pageLength": 200
		});

		$('#mastersiswa').DataTable({
			"paging": false,
			"lengthChange": false,
			"searching": true,
			"ordering": false,
			"info": false,
			"autoWidth": false,
			"pageLength": 200
		});

		$('#example5').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"info": false,
			"autoWidth": false,
			"pageLength": 200,
			"order": [
				[5, "desc"]
			]
		});
	});
</script>