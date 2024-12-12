<?php
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
        $filterSQL = "";
        $namaKategori = "Semua";
    } else {
        $filterSQL = "WHERE barang.nm_barang LIKE'%$dataKataKunci%'";
        $namaKategori = "Semua";
    }
} else {
    if ($dataKataKunci == "") {
        $filterSQL = "WHERE barang.kd_kategori='$kodeKategori'";
    } else {
        $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND barang.nm_barang LIKE'%$dataKataKunci%'";
    }
}
?>

<?php

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(270, 10, 'LAPORAN DATA PENGADAAN', 0, 0, 'C');

$pdf->Cell(10, 10, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(7, 7, 'No', 1, 0, 'C');
$pdf->Cell(30, 7, 'Tanggal', 1, 0, 'C');
$pdf->Cell(22, 7, 'No. Pengadaan', 1, 0, 'C');
$pdf->Cell(40, 7, 'Nama Petugas', 1, 0, 'C');
$pdf->Cell(60, 7, 'Type Barang', 1, 0, 'C');
$pdf->Cell(30, 7, 'Keterangan', 1, 0, 'C');
$pdf->Cell(25, 7, 'Harga', 1, 0, 'C');
$pdf->Cell(20, 7, 'Qty Barang', 1, 0, 'C');
$pdf->Cell(25, 7, 'Total Harga', 1, 0, 'C');

$pdf->Cell(20, 7, '', 0, 1);
$pdf->SetFont('Times', '', 8);
$no = 1;
$totalBarang  = 0;
$totalBelanja = 0;
$mySql = "SELECT pengadaan.*, supplier.nm_supplier, departemen.nm_departemen, petugas.nm_petugas, barang.nm_barang FROM pengadaan 
LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier
LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
LEFT JOIN pengadaan_item ON pengadaan.no_pengadaan=pengadaan_item.no_pengadaan
LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang
$filterSQL 
ORDER BY pengadaan.no_pengadaan ASC";
$myQry  = mysqli_query($koneksidb, $mySql)  or die("Query  salah : " . mysql_error());
while ($d = mysqli_fetch_array($myQry)) {

    # Membaca Kode pengadaan/ Nomor transaksi
    $noNota = $d['no_pengadaan'];

    # Menghitung Total pengadaan (belanja) setiap nomor transaksi
    $my2Sql = "SELECT SUM(jumlah) AS total_barang,  
						  SUM(harga_beli * jumlah) AS total_belanja, harga_beli 
				   FROM pengadaan_item WHERE no_pengadaan='$noNota'";
    $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
    $my2Data = mysql_fetch_array($my2Qry);

    $totalBarang  = $totalBarang + $my2Data['total_barang'];
    $totalBelanja = $totalBelanja + $my2Data['total_belanja'];

    $pdf->Cell(7, 6, $no++, 1, 0, 'C');
    $pdf->Cell(30, 6, IndonesiaTgl2($d['tgl_pengadaan']), 1, 0, 'C');
    $pdf->Cell(22, 6, $d['no_pengadaan'], 1, 0);
    $pdf->Cell(40, 6, $d['nm_petugas'], 1, 0);
    $pdf->Cell(60, 6, $d['nm_barang'], 1, 0);
    $pdf->Cell(30, 6, $d['keterangan'], 1, 0);
    $pdf->Cell(25, 6, 'Rp. ' . format_angka($my2Data['harga_beli']), 1, 0, 'C');
    $pdf->Cell(20, 6, $my2Data['total_barang'], 1, 0, 'C');
    $pdf->Cell(25, 6, 'Rp. ' . format_angka($my2Data['total_belanja']), 1, 1, 'C');
}
$pdf->Cell(214, 6, 'GRAND TOTAL', 1, 0, 'C');
$pdf->Cell(20, 6, $totalBarang, 1, 0, 'C');
$pdf->Cell(25, 6, 'Rp. ' . format_angka($totalBelanja), 1, 0, 'C');

$pdf->Output();
?>