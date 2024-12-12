<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
// Variabel SQL
$filterSQL    = "";

# Set Tanggal skrg
$kodeKategori  = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
$dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    if ($kodeKategori == "Semua") {
        if ($dataKataKunci == "") {
            $filterSQL = "";
            $namaKategori = "Semua";
        } else {
            $filterSQL = "AND b.nm_barang LIKE'%$dataKataKunci%'";
            $namaKategori = "Semua";
        }
    } else {
        if ($dataKataKunci == "") {
            $filterSQL = "AND b.kd_kategori='$kodeKategori'";
        } else {
            $filterSQL = "AND b.kd_kategori='$kodeKategori' AND b.nm_barang LIKE'%$dataKataKunci%'";
        }
    }
} else {
    if ($kodeKategori == "Semua") {
        if ($dataKataKunci == "") {
            $filterSQL = "";
            $namaKategori = "Semua";
        } else {
            $filterSQL = "WHERE b.nm_barang LIKE'%$dataKataKunci%'";
            $namaKategori = "Semua";
        }
    } else {
        if ($dataKataKunci == "") {
            $filterSQL = "WHERE b.kd_kategori='$kodeKategori'";
        } else {
            $filterSQL = "WHERE b.kd_kategori='$kodeKategori' AND b.nm_barang LIKE'%$dataKataKunci%'";
        }
    }
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->mergeCells('A1:G1');
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('A1', 'LAPORAN DATA BARANG PER KATEGORI');
$sheet->mergeCells('A3:B3');
// $sheet->setCellValue('A3', 'KETERANGAN');
// $sheet->mergeCells('A4:B4');
// $sheet->setCellValue('A4', 'Nama Kategori');
// $sheet->setCellValue('C4', ': ' . $namaKategori);
$sheet->setCellValue('A5', 'No');
$sheet->setCellValue('B5', 'KODE');
$sheet->setCellValue('C5', 'Nama Barang');
$sheet->setCellValue('D5', 'Jumlah');
$sheet->setCellValue('E5', 'Tersedia');
$sheet->setCellValue('F5', 'Ditempatkan');
$sheet->setCellValue('G5', 'Dipinjam');

// Skrip menampilkan data Barang dengan filter Kategori
if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
	// Query menampilkan data Inventaris per Kode barang
	$mySql = "SELECT b.*, K.*, BI.status_barang, COUNT(BI.kd_inventaris) AS total FROM barang_inventaris BI
    LEFT JOIN barang b ON BI.kd_barang = b.kd_barang
    LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
    LEFT JOIN pengadaan PE ON BI.no_pengadaan = PE.no_pengadaan
    LEFT JOIN petugas PT ON PE.kd_petugas = PT.kd_petugas
    LEFT JOIN penempatan_item PI ON BI.kd_inventaris = PI.kd_inventaris
    LEFT JOIN penempatan P ON PI.no_penempatan = P.no_penempatan
    LEFT JOIN lokasi L ON P.kd_lokasi = L.kd_lokasi
    LEFT JOIN peminjaman_item PIJ ON BI.kd_inventaris = PIJ.kd_inventaris
    LEFT JOIN peminjaman PJ ON PIJ.no_peminjaman = PJ.no_peminjaman
    LEFT JOIN pegawai PG ON PJ.kd_pegawai = PG.kd_pegawai
    LEFT JOIN departemen D ON PT.kd_departemen = D.kd_departemen OR L.kd_departemen = D.kd_departemen OR PG.kd_departemen = D.kd_departemen
    WHERE b.kd_kategori !='' AND BI.status_barang != '' $filterSQL AND D.nm_departemen='$_SESSION[SES_UNIT]' GROUP BY b.kd_barang";
} else {
	$mySql 	= "SELECT * FROM barang b
    LEFT JOIN kategori K ON b.kd_kategori = K.kd_kategori
    $filterSQL ORDER BY b.kd_barang ASC";
}
$data = mysqli_query($koneksidb, $mySql) or die("Query salah5 : " . mysql_error());
$i = 6;
$no = 1;
while ($d = mysqli_fetch_array($data)) {
	$Kode = $d['kd_barang'];

	// Membuat variabel akan diisi angka
	$jumTersedia = 0;
	$jumDitempatkan = 0;
	$jumDipinjam = 0;

	if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
		if ($d['status_barang'] == "Tersedia") {
			$row = "SELECT barang_inventaris.*, COUNT(barang_inventaris.kd_inventaris) AS total FROM barang_inventaris
            LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
            LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
            LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
            WHERE barang_inventaris.kd_barang='$Kode' AND departemen.nm_departemen='$_SESSION[SES_UNIT]'";
			$Qry = mysql_query($row, $koneksidb)  or die("Query salah1 : " . mysql_error());
			$dataRow = mysql_fetch_array($Qry);
			$jumTersedia = $dataRow['total'];
		}

		if ($d['status_barang'] == "Ditempatkan") {
			$row = "SELECT barang_inventaris.*, COUNT(penempatan_item.kd_inventaris) AS total FROM barang_inventaris
            LEFT JOIN penempatan_item ON barang_inventaris.kd_inventaris = penempatan_item.kd_inventaris
            LEFT JOIN penempatan ON penempatan_item.no_penempatan = penempatan.no_penempatan
            LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
            LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen
            WHERE barang_inventaris.kd_barang='$Kode' AND departemen.nm_departemen='$_SESSION[SES_UNIT]' AND penempatan_item.status_aktif = 'Yes'";
			$Qry = mysql_query($row, $koneksidb)  or die("Query salah1 : " . mysql_error());
			$dataRow = mysql_fetch_array($Qry);
			$jumDitempatkan = $dataRow['total'];
		}

		if ($d['status_barang'] == "Dipinjam") {
			$row = "SELECT barang_inventaris.*, COUNT(peminjaman_item.kd_inventaris) AS total FROM barang_inventaris
            LEFT JOIN peminjaman_item ON barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris
            LEFT JOIN peminjaman ON peminjaman_item.no_peminjaman = peminjaman.no_peminjaman
            LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
            LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
            WHERE barang_inventaris.kd_barang='$Kode' AND departemen.nm_departemen='$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = 'Pinjam'";
			$Qry = mysql_query($row, $koneksidb)  or die("Query salah1 : " . mysql_error());
			$dataRow = mysql_fetch_array($Qry);
			$jumDipinjam = $dataRow['total'];
		}
	} else {
		// Query menampilkan data Inventaris per Kode barang
		$my2Sql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
		while ($my2Data = mysql_fetch_array($my2Qry)) {
			if ($my2Data['status_barang'] == "Tersedia") {
				$jumTersedia++;
			}

			if ($my2Data['status_barang'] == "Ditempatkan") {
				$jumDitempatkan++;
			}

			if ($my2Data['status_barang'] == "Dipinjam") {
				$jumDipinjam++;
			}
		}
	}

	$sheet->setCellValue('A' . $i, $no++);
	$sheet->setCellValue('B' . $i, $d['kd_barang']);
	$sheet->setCellValue('C' . $i, $d['nm_barang']);
	if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
		$sheet->setCellValue('D' . $i, $d['total']);
	} else {
		$sheet->setCellValue('D' . $i, $d['jumlah']);
	}
	$sheet->setCellValue('E' . $i, $jumTersedia);
	$sheet->setCellValue('F' . $i, $jumDitempatkan);
	$sheet->setCellValue('G' . $i, $jumDipinjam);
	$i++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('Data barang.xlsx');
echo "<script>window.location = 'Data barang.xlsx'</script>";
