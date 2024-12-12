<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/fpdf/fpdf.php";

// Variabel SQL
$filterSQL    = "";
# Set Tanggal skrg
$kodeKategori  = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
$dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

if ($kodeKategori == "Semua") {
    if ($dataKataKunci == "") {
        $filterSQL = "WHERE penempatan_item.status_aktif='Yes'";
    } else {
        $filterSQL = "WHERE barang.nm_barang LIKE'%$dataKataKunci%' AND penempatan_item.status_aktif='Yes'";
    }
} else {
    if ($dataKataKunci == "") {
        $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND penempatan_item.status_aktif='Yes'";
    } else {
        $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND barang.nm_barang LIKE'%$dataKataKunci%' AND penempatan_item.status_aktif='Yes'";
    }
}

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(190, 10, 'LAPORAN DATA PENEMPATAN BARANG', 0, 0, 'C');

$pdf->Cell(10, 10, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(7, 7, 'No', 1, 0, 'C');
$pdf->Cell(15, 7, 'Tanggal', 1, 0, 'C');
$pdf->Cell(25, 7, 'No. Penempatan', 1, 0, 'C');
$pdf->Cell(50, 7, 'Type Barang', 1, 0, 'C');
$pdf->Cell(20, 7, 'Kategori', 1, 0, 'C');
$pdf->Cell(31, 7, 'Departemen', 1, 0, 'C');
$pdf->Cell(25, 7, 'Lokasi', 1, 0, 'C');
$pdf->Cell(17, 7, 'Qty Barang', 1, 0, 'C');

$pdf->Cell(20, 7, '', 0, 1);
$pdf->SetFont('Times', '', 8);
$no = 1;
if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    $mySql = "SELECT penempatan_item.*, penempatan.*, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang, kategori.nm_kategori FROM penempatan_item 
    LEFT JOIN penempatan ON penempatan_item.no_penempatan=penempatan.no_penempatan
    LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
    LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
    LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
    LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
    LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
    $filterSQL AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
    GROUP BY penempatan_item.no_penempatan ASC";
} else {
    $mySql = "SELECT penempatan_item.*, penempatan.*, lokasi.nm_lokasi, departemen.nm_departemen, barang.nm_barang, kategori.nm_kategori FROM penempatan_item 
    LEFT JOIN penempatan ON penempatan_item.no_penempatan=penempatan.no_penempatan
    LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris
    LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
    LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
    LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
    LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
    $filterSQL
    GROUP BY penempatan_item.no_penempatan ASC";
}
$myQry  = mysqli_query($koneksidb, $mySql)  or die("Query  salah : " . mysql_error());
while ($d = mysqli_fetch_array($myQry)) {

    # Membaca Kode penempatan/ Nomor transaksi
    $noNota = $d['no_penempatan'];

    # Menghitung Total penempatan (belanja) setiap nomor transaksi
    $my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noNota'";
    $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
    $my2Data = mysql_fetch_array($my2Qry);

    $pdf->Cell(7, 6, $no++, 1, 0, 'C');
    $pdf->Cell(15, 6, IndonesiaTgl($d['tgl_penempatan']), 1, 0, 'C');
    $pdf->Cell(25, 6, $d['no_penempatan'], 1, 0, 'C');
    $pdf->Cell(50, 6, $d['nm_barang'], 1, 0, 'C');
    $pdf->Cell(20, 6, $d['nm_kategori'], 1, 0, 'C');
    $pdf->Cell(31, 6, $d['nm_departemen'], 1, 0, 'C');
    $pdf->Cell(25, 6, $d['nm_lokasi'], 1, 0, 'C');
    $pdf->Cell(17, 6, format_angka($my2Data['total_barang']), 1, 1, 'C');
}

$pdf->Output();
