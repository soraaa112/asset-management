<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/fpdf/fpdf.php";

// Baca variabel filter dari URL
if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
    $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : $_SESSION['SES_UNIT'];
} else {
    $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
}
$status = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
$dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

if ($kodeDepartemen == "Semua") {
    if ($status ==  "Semua") {
        if ($dataKataKunci ==  "") {
            $filterSQL   = "";
        } else {
            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%'";
        }
    } else {
        if ($dataKataKunci ==  "") {
            $filterSQL   = "WHERE peminjaman.status_kembali = '$status'";
        } else {
            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND peminjaman.status_kembali = '$status'";
        }
    }
} else {
    if ($status ==  "Semua") {
        if ($dataKataKunci ==  "") {
            $filterSQL   = " WHERE pegawai.kd_departemen ='$kodeDepartemen'";
        } else {
            $filterSQL   = " WHERE pegawai.kd_departemen ='$kodeDepartemen' AND peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%'";
        }
    } else {
        if ($dataKataKunci ==  "") {
            $filterSQL   = "WHERE pegawai.kd_departemen ='$kodeDepartemen' AND peminjaman.status_kembali = '$status'";
        } else {
            $filterSQL   = " WHERE pegawai.kd_departemen ='$kodeDepartemen' AND peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND peminjaman.status_kembali = '$status'";
        }
    }
}
?>

<?php

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(270, 10, 'LAPORAN DATA PEMINJAMAN BARANG', 0, 0, 'C');

$pdf->Cell(10, 10, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(7, 7, 'No', 1, 0, 'C');
$pdf->Cell(32, 7, 'Tanggal Peminjaman', 1, 0, 'C');
$pdf->Cell(32, 7, 'Tanggal Pengembalian', 1, 0, 'C');
$pdf->Cell(25, 7, 'No. Peminjaman', 1, 0, 'C');
$pdf->Cell(22, 7, 'Kode Label', 1, 0, 'C');
$pdf->Cell(70, 7, 'Type Barang', 1, 0, 'C');
$pdf->Cell(30, 7, 'Pegawai', 1, 0, 'C');
$pdf->Cell(25, 7, 'Departemen', 1, 0, 'C');
$pdf->Cell(15, 7, 'Status', 1, 0, 'C');
$pdf->Cell(20, 7, 'Qty Barang', 1, 0, 'C');

$pdf->Cell(20, 7, '', 0, 1);
$pdf->SetFont('Times', '', 8);
$no = 1;
$mySql = "SELECT peminjaman.*, departemen.nm_departemen, pegawai.nm_pegawai, barang.nm_barang, peminjaman_item.kd_inventaris FROM peminjaman 
LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
$filterSQL
ORDER BY peminjaman.no_peminjaman DESC";
$myQry  = mysqli_query($koneksidb, $mySql)  or die("Query  salah : " . mysql_error());
while ($d = mysqli_fetch_array($myQry)) {

    // Membaca Kode peminjaman/ Nomor transaksi
    $noNota = $d['no_peminjaman'];

    // Menghitung Total barang yang dipinjam
    $my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
    $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
    $my2Data = mysql_fetch_array($my2Qry);

    $pdf->Cell(7, 6, $no++, 1, 0, 'C');
    $pdf->Cell(32, 6, IndonesiaTgl($d['tgl_peminjaman']), 1, 0, 'C');
    if ($d['status_kembali'] == 'Kembali') {
        $pdf->Cell(32, 6, IndonesiaTgl($d['tgl_kembali']), 1, 0, 'C');
    } else {
        $pdf->Cell(32, 6, '-', 1, 0, 'C');
    }
    $pdf->Cell(25, 6, $d['no_peminjaman'], 1, 0, 'C');
    $pdf->Cell(22, 6, $d['kd_inventaris'], 1, 0);
    $pdf->Cell(70, 6, $d['nm_barang'], 1, 0);
    $pdf->Cell(30, 6, $d['nm_pegawai'], 1, 0);
    $pdf->Cell(25, 6, $d['nm_departemen'], 1, 0);
    $pdf->Cell(15, 6, $d['status_kembali'], 1, 0);
    $pdf->Cell(20, 6, $my2Data['total_barang'], 1, 1, 'C');
}

$pdf->Output();
?>