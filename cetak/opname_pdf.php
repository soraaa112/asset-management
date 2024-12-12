<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/fpdf/fpdf.php";

# Set Tanggal skrg
$statusBarang = isset($_GET['cmbStatus']) ? $_GET['cmbStatus'] : 'Semua';

// Membuat SQL Filter data
if ($statusBarang == "Semua") {
  $filterSQL = "";
} else {
  $filterSQL = "WHERE status='$statusBarang'";
}
?>
<?php

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(190, 10, 'LAPORAN STOK OPNAME', 0, 0, 'C');

$pdf->Cell(10, 10, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(7, 7, 'No', 1, 0, 'C');
$pdf->Cell(22, 7, 'Kode Opname', 1, 0, 'C');
$pdf->Cell(22, 7, 'Kode Label', 1, 0, 'C');
$pdf->Cell(60, 7, 'Type Barang', 1, 0, 'C');
$pdf->Cell(20, 7, 'Tgl Opname', 1, 0, 'C');
$pdf->Cell(30, 7, 'Kondisi', 1, 0, 'C');
$pdf->Cell(30, 7, 'Status', 1, 0, 'C');


$pdf->Cell(20, 7, '', 0, 1);
$pdf->SetFont('Times', '', 8);
$no = 1;
$mySql  = "SELECT opname.*, barang.nm_barang, barang_inventaris.kd_inventaris 
FROM opname
LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori $filterSQL 
ORDER BY kd_opname ASC";
$myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
while ($d = mysql_fetch_array($myQry)) {
  $Kode = $d['kd_opname'];
  $pdf->Cell(7, 6, $no++, 1, 0, 'C');
  $pdf->Cell(22, 6, $d['kd_opname'], 1, 0, 'C');
  $pdf->Cell(22, 6, $d['kd_inventaris'], 1, 0, 'C');
  $pdf->Cell(60, 6, $d['nm_barang'], 1, 0, 'C');
  $pdf->Cell(20, 6, IndonesiaTgl($d['tahun_opname']), 1, 0, 'C');
  $pdf->Cell(30, 6, $d['keterangan'], 1, 0, 'C');
  $pdf->Cell(30, 6, $d['status'], 1, 1, 'C');
}

$pdf->Output();
?>